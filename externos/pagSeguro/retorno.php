<?php
require_once('../../includes/conectar_pdo.php');
require_once('../../includes/funcoes.php');
require_once('../../includes/sql.php');
require_once('../../includes/sql2.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>RETORNO PAGSEGURO</title>
</head>
<body>
<h1>RETORNO PAGSEGURO</h1>
<?php
header('Content-Type: text/html; charset=utf-8');
if(isset($_POST['notificationCode'])){
    $email = 'financeiroserra@cedtec.com.br';
    $tokem = '55B5184AC3CE4996B870F6F0150E13D4';
    $pagSeguroConta = 'P00QA';
    $conta_ref = $pagSeguroConta;
    $idTransacao = $_POST['notificationCode'];
    $linkNotificacao = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/".$idTransacao."?email=".$email."&token=".$tokem.""; //link do arquivo xml
    $xmlNotificacao = simplexml_load_file($linkNotificacao); //carrega o arquivo XML e retornando um Array
    $idTransacao2 = $xmlNotificacao->code;

    ##pega transacao
$link = "https://ws.pagseguro.uol.com.br/v2/transactions/".$idTransacao2."?email=".$email."&token=".$tokem.""; //link do arquivo xml
    $xml = simplexml_load_file($link); //carrega o arquivo XML e retornando um Array

$status[1] = 'Aguardando Pagamento';
$status[2] = 'Em Analise';
$status[3] = 'Paga';
$status[4] = 'Disponivel';
$status[5] = 'Em Disputa';
$status[6] = 'Devolvida';
$status[7] = 'Cancelada';

$codigo = $xml->reference;
$transacao = $xml->code;
$data = $xml->date;
$ultimaAtualizacao = $xml->lastEventDate;
$valorBruto = $xml->grossAmount;
$valorLiquido = $xml->netAmount;
$valorTaxa = $xml->feeAmount;
$idStatus = $xml->status;
$nomeStatus = $status[trim($idStatus)];

##atualiza requisicao pagseguro
func_atualizar_pagseguro_requisicao($transacao, $link,$linkNotificacao, format_data_hora($ultimaAtualizacao), $valorBruto, $valorLiquido, $valorTaxa, $idStatus, $nomeStatus, $codigo);
    ## se for situação Devolvida matricula o aluno
    if(trim($idStatus) == 6){
        func_pagSeguro_estorno_titulo($codigo);
    }

    ## se for situação Paga matricula o aluno
    if(trim($idStatus) == 3){
        $dataLiberacao = data_hora_servidor()->modify('+30 day');
        func_pagSeguro_atualizar_liberacao($codigo, $dataLiberacao);

        $sql_titulo = func_dados_boleto_id($codigo);
        if($sql_titulo->rowCount() == 1){
            ##baixa de titulo
            $dadosTituloBaixa = $sql_titulo->fetch(PDO::FETCH_ASSOC);

            $sql_contar_baixa = func_baixar_titulo($dadosTituloBaixa['id_titulo'], data_hora_servidor()->format('Y-m-d'), $valorBruto, $dadosTituloBaixa['ref_conta_cartao']);

            if($sql_contar_baixa->rowCount() == 1){
                ##gera tiulo com a taxa
                $sql_conta_taxa = func_dados_conta($dadosTituloBaixa['ref_conta_cartao']);
                $dados_conta_taxa = $sql_conta_taxa->fetch(PDO::FETCH_ASSOC);
                //GERA O TITULO
                $dados = array();
                $dados['fornecedor']        = $dadosTituloBaixa['cliente_fornecedor'];
                $dados['vencimento']        = data_hora_servidor()->format('Y-m-d');
                $dados['valor']        = $valorTaxa;
                $dados['parcela']        = 1;
                $dados['tipo']        = 1;
                $dados['dt_doc']       = data_hora_servidor()->format('Y-m-d');
                $dados['descricao']       = 'Boleto de taxa referente ao titulo '.$dadosTituloBaixa['id_titulo'];
                $dados['nfe'] = $dadosTituloBaixa['id_titulo'];
                $dados['conta'] 		= $dados_conta_taxa['ref_conta'];
                $dados['empresa'] 		= $dados_conta_taxa['empresa'];
                $dados['cc2']		= $dados_conta_taxa['id_filial'];
                $dados['cc3']		= 15; #despesas
                $dados['cc4']		= 1503; #despesas financeiras
                $dados['cc5']		= 006; #taxas online
                $dados['cc6'] 		= 10; ##pagseguro
                $dados['c_custo']        = $dados['empresa'].$dados['cc2'].$dados['cc3'].$dados['cc4'].$dados['cc5'].$dados['cc6'];
                $venc = $dados['vencimento'];
                $parcelas = 1;
                $dados['mes_comp'] = date('m');
                $dados['ano_comp'] = date('Y');

                $dados['valor_final'] 		= str_replace(",",".",$dados['valor']);
                $dados['acrescimo']		= 0;
                $dados['desconto']		= 0;
                func_gerar_titulo($dados);

                $sql_buscar_titulo_taxa = func_buscar_titulo_taxa($dados_conta_taxa['ref_conta'], $valorTaxa);
                $dados_titulo_taxa = $sql_buscar_titulo_taxa->fetch(PDO::FETCH_ASSOC);
                func_baixar_titulo($dados_titulo_taxa['id_titulo'], data_hora_servidor()->format('Y-m-d'), $valorTaxa, $dados_conta_taxa['ref_conta']);
            }

        } else {
           ##matricula
            $sql_buscar_matricula = func_buscar_inscrito($codigo);
            if($sql_buscar_matricula->rowCount() >= 1){
                $dados_inscrito = $sql_buscar_matricula->fetch(PDO::FETCH_ASSOC);
                $nome_baixa = utf8_encode($dados_inscrito['nome']);
                $cpf_baixa = $dados_inscrito['cpf'];
                $vencimento_baixa = data_hora_servidor()->format('Y-m-d');
                $valor_baixa = $valorBruto;
                $valorpago = $valor_baixa;
                $datapag = substr($ultimaAtualizacao,0,10);
                $cor_baixa = 'yellow';
                $situacao = 'Matrícula';
                //VERIFICA SE JA ESTÁ MATRICULADO
                $sql_aluno = func_buscar_aluno_id($codigo);
                if($sql_aluno->rowCount() == 0){
                    $sql_matricula_aluno = func_matricular_aluno($codigo);
                    $sql_aluno_buscar = func_buscar_aluno_id($codigo);
                    $dados_aluno = $sql_aluno_buscar->fetch(PDO::FETCH_ASSOC);

                    $html_email = 'Caro(a) '.utf8_encode(strtoupper($dados_aluno['nome'])).',

Sua matrícula já foi efetivada.<br>
Para acessar seu ambiente acadêmico basta clicar em \'Sistema Acadêmico\' no nosso site. Digite a sua matrícula (usuário) e a senha inicial.<br><br>


<table width="200px" align="center" border="1px" cellspacing="0">
                <tr style="height: 30px">
                    <td bgcolor="silver"><b>Usuário</b></td>
                    <td bgcolor="" style="padding-left: 5px">'.$dados_aluno['codigo'].'</td>
                </tr>
                <tr style="height: 30px">
                    <td bgcolor="silver"><b>Senha</b></td>
                    <td bgcolor="" style="padding-left: 5px">'.str_replace('/','',$dados_aluno['nascimento']).'</td>
                </tr>
            </table>

A senha inicial é a sua data de nascimento com todos os dígitos sem as barras. Altere sua senha no primeiro acesso evitando senhas óbvias.';
                    enviarEmail($dados_aluno['email'], 'Confirmação de Matrícula', $html_email);
                    func_novo_usuario_aluno($dados_aluno['codigo'], str_replace('/','',$dados_aluno['nascimento']));
                    $sql_inscrito = func_buscar_inscrito($dados_aluno['codigo']);
                    $dados_inscrito = $sql_inscrito->fetch(PDO::FETCH_ASSOC);
                    $sql_curso_contratado = func_curso_inscrito($dados_aluno['codigo'], $dados_inscrito['curso']);
                    if($sql_curso_contratado->rowCount() == 1){
                        $dados_curso_contratado = $sql_curso_contratado->fetch(PDO::FETCH_ASSOC);
                        $sql_curso = func_cad_curso_aluno($dados_curso_contratado);
                        func_atualizar_empresa_aluno($dados_aluno['codigo'], $dados_curso_contratado['empresa']);
                        $montarCentroCusto = func_montar_centro_custo($dados_curso_contratado);
                        $n_parcela = 1;
                        $dadosTitulo['fornecedor'] = $dados_aluno['codigo'];
                        $dadosTitulo['descricao'] = 'Mensalidade ' . $n_parcela . '/' . $dados_curso_contratado['parcelas'] . ' do curso ' . $dados_curso_contratado['nivel'] . ': ' . $dados_curso_contratado['curso'];
                        $dadosTitulo['vencimento'] = substr($dados_curso_contratado['vencimento'], 0, 8) . $dados_curso_contratado['dia_venc'];
                        $dadosTitulo['valor'] = $dados_curso_contratado['valor'] / $dados_curso_contratado['parcelas'];
                        if ($dados_curso_contratado['parcelas'] == 1) {
                            $descontoFinal = $dados_curso_contratado['desconto_avista'];
                        } else {
                            $descontoFinal = $dados_curso_contratado['desconto'];
                        }

                        $dadosTitulo['desconto'] = $descontoFinal;
                        $dadosTitulo['parcela'] = $n_parcela;
                        $dadosTitulo['c_custo'] = $montarCentroCusto;
                        $dadosTitulo['conta'] = $dados_curso_contratado['conta'];
                        while ($dadosTitulo['parcela'] <= $dados_curso_contratado['parcelas']) {
                            $sql_teste = func_gerar_titulos_matricula($dadosTitulo);
                            $dadosTitulo['parcela'] += 1;
                            $dadosTitulo['descricao'] = 'Mensalidade ' . $dadosTitulo['parcela'] . '/' . $dados_curso_contratado['parcelas'] . ' do curso ' . $dados_curso_contratado['nivel'] . ': ' . $dados_curso_contratado['curso'];
                            $vencimentoNovo = date("Y-m-d", strtotime("1 Month", strtotime($dadosTitulo['vencimento'])));
                            $dadosTitulo['vencimento'] = $vencimentoNovo;
                        }
                        $sql_baixar_matricula = func_buscar_titulo_matricula($codigo);
                        $dadosTituloMatricula = $sql_baixar_matricula->fetch(PDO::FETCH_ASSOC);

                        $sql_titulo = func_dados_boleto_id($dadosTituloMatricula['id_titulo']);
                        $dadosTituloBaixa = $sql_titulo->fetch(PDO::FETCH_ASSOC);
                        $sql_contar_baixa = func_baixar_titulo($dadosTituloMatricula['id_titulo'], $datapag, $valorpago, $dadosTituloBaixa['ref_conta_cartao']);

                        if($sql_contar_baixa->rowCount() == 1){
                            ##gera tiulo com a taxa
                            $sql_conta_taxa = func_dados_conta($conta_ref);
                            $dados_conta_taxa = $sql_conta_taxa->fetch(PDO::FETCH_ASSOC);
                            //GERA O TITULO
                            $dados = array();
                            $dados['fornecedor']        = $dadosTituloMatricula['cliente_fornecedor'];
                            $dados['vencimento']        = data_hora_servidor()->format('Y-m-d');
                            $dados['valor']        = $valorTaxa;
                            $dados['parcela']        = 1;
                            $dados['tipo']        = 1;
                            $dados['dt_doc']       = data_hora_servidor()->format('Y-m-d');
                            $dados['descricao']       = 'Boleto de taxa referente ao titulo '.$dadosTituloMatricula['id_titulo'];
                            $dados['nfe'] = $dadosTituloMatricula['id_titulo'];
                            $dados['conta'] 		= $dados_conta_taxa['ref_conta'];
                            $dados['empresa'] 		= $dados_conta_taxa['empresa'];
                            $dados['cc2']		= $dados_conta_taxa['id_filial'];
                            $dados['cc3']		= 15; #despesas
                            $dados['cc4']		= 1503; #despesas financeiras
                            $dados['cc5']		= 006; #taxas online
                            $dados['cc6'] 		= 10; ##pagseguro
                            $dados['c_custo']        = $dados['empresa'].$dados['cc2'].$dados['cc3'].$dados['cc4'].$dados['cc5'].$dados['cc6'];
                            $venc = $dados['vencimento'];
                            $parcelas = 1;
                            $dados['mes_comp'] = date('m');
                            $dados['ano_comp'] = date('Y');

                            $dados['valor_final'] 		= str_replace(",",".",$dados['valor']);
                            $dados['acrescimo']		= 0;
                            $dados['desconto']		= 0;
                            func_gerar_titulo($dados);

                            $sql_buscar_titulo_taxa = func_buscar_titulo_taxa($dados_conta_taxa['ref_conta'], $valorTaxa);
                            $dados_titulo_taxa = $sql_buscar_titulo_taxa->fetch(PDO::FETCH_ASSOC);
                            func_baixar_titulo($dados_titulo_taxa['id_titulo'], data_hora_servidor()->format('Y-m-d'), $valorTaxa, $dados_conta_taxa['ref_conta']);

                        }

                    } else {
                        //qualificacao
                        $sql_curso_qualificacao = func_buscar_curso_matricula_aluno_id(substr($dados_inscrito['curso'],3,10));
                        $dados_curso_contratado = $sql_curso_qualificacao->fetch(PDO::FETCH_ASSOC);
                        $dados_curso_contratado['modulo'] = 1;
                        $dados_curso_contratado['turno'] = 'Diurno';
                        $dados_curso_contratado['polo'] = '';
                        $dados_curso_contratado['valor'] = $dados_curso_contratado['valor_total'];
                        $dados_curso_contratado['codigo'] = $dados_inscrito['codigo'];
                        $sql_curso = func_cad_curso_aluno($dados_curso_contratado);
                        func_atualizar_empresa_aluno($dados_aluno['codigo'], $dados_curso_contratado['id_empresa']);
                        $montarCentroCusto = $dados_curso_contratado['id_empresa'].$dados_curso_contratado['cc2'].$dados_curso_contratado['cc3'].$dados_curso_contratado['cc4'].$dados_curso_contratado['cc5'].$dados_curso_contratado['cc6'];
                        $n_parcela = 1;
                        $dadosTitulo['fornecedor'] = $dados_aluno['codigo'];
                        $dadosTitulo['descricao'] = 'Mensalidade ' . $n_parcela . '/' . $dados_curso_contratado['parcelas'] . ' do curso ' . $dados_curso_contratado['nivel'] . ': ' . $dados_curso_contratado['curso'];
                        $dadosTitulo['vencimento'] = substr($dados_curso_contratado['vencimento'], 0, 8) . $dados_curso_contratado['dia_venc'];
                        $dadosTitulo['valor'] = $dados_curso_contratado['valor_total'] / $dados_curso_contratado['parcelas'];
                        if ($dados_curso_contratado['parcelas'] == 1) {
                            $descontoFinal = $dados_curso_contratado['desconto_avista'];
                        } else {
                            $descontoFinal = $dados_curso_contratado['desconto'];
                        }

                        $dadosTitulo['desconto'] = $descontoFinal;
                        $dadosTitulo['parcela'] = $n_parcela;
                        $dadosTitulo['c_custo'] = $montarCentroCusto;
                        $dadosTitulo['conta'] = $pagSeguroConta;
                        while ($dadosTitulo['parcela'] <= $dados_curso_contratado['parcelas']) {
                            $sql_teste = func_gerar_titulos_matricula($dadosTitulo);
                            $dadosTitulo['parcela'] += 1;
                            $dadosTitulo['descricao'] = 'Mensalidade ' . $dadosTitulo['parcela'] . '/' . $dados_curso_contratado['parcelas'] . ' do curso ' . $dados_curso_contratado['nivel'] . ': ' . $dados_curso_contratado['curso'];
                            $vencimentoNovo = date("Y-m-d", strtotime("1 Month", strtotime($dadosTitulo['vencimento'])));
                            $dadosTitulo['vencimento'] = $vencimentoNovo;
                        }
                        $sql_baixar_matricula = func_buscar_titulo_matricula($codigo);
                        $dadosTituloMatricula = $sql_baixar_matricula->fetch(PDO::FETCH_ASSOC);

                        $sql_contar_baixa = func_baixar_titulo($dadosTituloMatricula['id_titulo'], $datapag, $valorpago, $conta_ref);

                        if($sql_contar_baixa->rowCount() == 1){
                            ##gera tiulo com a taxa
                            $sql_conta_taxa = func_dados_conta($conta_ref);
                            $dados_conta_taxa = $sql_conta_taxa->fetch(PDO::FETCH_ASSOC);
                            //GERA O TITULO
                            $dados = array();
                            $dados['fornecedor']        = $dadosTituloMatricula['cliente_fornecedor'];
                            $dados['vencimento']        = data_hora_servidor()->format('Y-m-d');
                            $dados['valor']        = $valorTaxa;
                            $dados['parcela']        = 1;
                            $dados['tipo']        = 1;
                            $dados['dt_doc']       = data_hora_servidor()->format('Y-m-d');
                            $dados['descricao']       = 'Boleto de taxa referente ao titulo '.$dadosTituloMatricula['id_titulo'];
                            $dados['nfe'] = $dadosTituloMatricula['id_titulo'];
                            $dados['conta'] 		= $dados_conta_taxa['ref_conta'];
                            $dados['empresa'] 		= $dados_conta_taxa['empresa'];
                            $dados['cc2']		= $dados_conta_taxa['id_filial'];
                            $dados['cc3']		= 15; #despesas
                            $dados['cc4']		= 1503; #despesas financeiras
                            $dados['cc5']		= 006; #taxas online
                            $dados['cc6'] 		= 10; ##pagseguro
                            $dados['c_custo']        = $dados['empresa'].$dados['cc2'].$dados['cc3'].$dados['cc4'].$dados['cc5'].$dados['cc6'];
                            $venc = $dados['vencimento'];
                            $parcelas = 1;
                            $dados['mes_comp'] = date('m');
                            $dados['ano_comp'] = date('Y');

                            $dados['valor_final'] 		= str_replace(",",".",$dados['valor']);
                            $dados['acrescimo']		= 0;
                            $dados['desconto']		= 0;
                            func_gerar_titulo($dados);

                            $sql_buscar_titulo_taxa = func_buscar_titulo_taxa($dados_conta_taxa['ref_conta'], $valorTaxa);
                            $dados_titulo_taxa = $sql_buscar_titulo_taxa->fetch(PDO::FETCH_ASSOC);
                            func_baixar_titulo($dados_titulo_taxa['id_titulo'], data_hora_servidor()->format('Y-m-d'), $valorTaxa, $dados_conta_taxa['ref_conta']);

                        }

                        //cria turma e enturma o aluno
                        $dados['organizacao'] = 1;
                        $dados['grupo'] = $dados_curso_contratado['grupo'];
                        $dados['nivel'] = $dados_curso_contratado['nivel'];
                        $dados['curso'] = $dados_curso_contratado['curso'];
                        $dados['modulo'] = 1;
                        $dados['unidade'] = $dados_curso_contratado['unidade'];
                        $dados['polo'] = $dados_curso_contratado['polo'];
                        $dados['turno'] = $dados_curso_contratado['turno'];
                        $dados['anograde'] = $dados_curso_contratado['grupo'];
                        $dados['ch'] = $dados_curso_contratado['ch'];

                        $dataInicio = new DateTime();
                        $dataFinal = new DateTime();
                        $dataFinal->modify('+6 month');

                        $dados['inicio'] = $dataInicio->format('d/m/Y');
                        $dados['fim'] = $dataFinal->format('d/m/Y');
                        $dados['empresa'] = $dados_curso_contratado['id_empresa'];
                        $dados['matricula'] = $codigo;

                        func_enturmar_aluno_qualificacao($dados);
                    }

                }
            }
        }

    }

    $html_txt = 'Matrícula '.$codigo.'<br>'.
    'Transação '.$transacao.'<br>'.
    'Data / Hora '.format_data_hora($data).'<br>'.
    'Ultima Atualização '.format_data_hora($ultimaAtualizacao).'<br>'.
    'Valor Bruto '.$valorBruto.'<br>'.
        'Valor Líquido '.$valorLiquido.'<br>'.
        'Valor Taxa '.$valorTaxa.'<br>'.
        'Situação '.($idStatus).' - '.$nomeStatus.'<br>';
?>

Matrícula: <?= $codigo;?><br>
Transação: <?= $transacao;?><br>
Data: <?= format_data_hora($data);?><br>
Ultima Atualização: <?= format_data_hora($ultimaAtualizacao);?><br>
Valor Bruto: <?= ($valorBruto);?><br>
Valor Líquido: <?= ($valorLiquido);?><br>
Valor Taxa: <?= ($valorTaxa);?><br>
Situação: <?= ($idStatus).' - '.$nomeStatus;?>

<?php
echo '<br><br><br>';
//enviarEmail('patryky.oliveira@gmail.com', 'Pagamento via API PagSeguro', $html_txt);

} else {

    echo "<h1>Transação não recebida.</h1>";
}
?>
</body>
</html>


