<?php
require_once('../../inc/conectar.php');
require_once('../../inc/funcoes.php');
require_once('../../inc/sql.php');
$sql_dados_boleto = func_dados_boleto($_GET['idTitulo'], $_GET['clienteFornecedor'], $_GET['parcela']);
if(0 == $sql_dados_boleto->rowCount()){
    echo "<script language='javascript'>
alert('Dados informados inválidos!');
window.close();
</script>";
    return;
}
$dados_boleto = $sql_dados_boleto->fetch(PDO::FETCH_ASSOC);

// DADOS DO BOLETO PARA O SEU CLIENTE
//$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0;
$data_venc = format_data($dados_boleto['vencimento']);  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $dados_boleto['valor']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $dados_boleto['id_titulo'];  // Nosso numero sem o DV - REGRA: M�ximo de 11 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = utf8_encode($dados_boleto['nome']);
$dadosboleto["endereco1"] = utf8_encode($dados_boleto['endereco']);
$dadosboleto["endereco2"] = utf8_encode($dados_boleto['cidade'])." - ".utf8_encode($dados_boleto['uf'])." -  CEP: ".utf8_encode($dados_boleto['cep']);

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Boleto - ".utf8_encode($dados_boleto['nome_cc1']);
$dadosboleto["demonstrativo2"] = utf8_encode($dados_boleto['descricao']);
$dadosboleto["demonstrativo3"] = "";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 15 dias após o vencimento";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = $dados_boleto['agencia']; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = $dados_boleto['agencia_dv']; // Digito do Num da agencia
$dadosboleto["conta"] = $dados_boleto['conta']; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = $dados_boleto['conta_dv']; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = $dados_boleto['conta']; // ContaCedente do Cliente, sem digito (Somente N�meros)
$dadosboleto["conta_cedente_dv"] = $dados_boleto['conta_dv']; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "06";  // C�digo da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = utf8_encode($dados_boleto['razao_social']);
$dadosboleto["cedente"] = utf8_encode($dados_boleto['razao_social']);
$dadosboleto["cpf_cnpj"] = $dados_boleto['cnpj'];

// N�O ALTERAR!
include("include/funcoes_bradesco.php");
include("include/layout_bradesco.php");
?>
