<?php
/* Sistema Pincel Atomico by Vanderlei Cavassani */
/* Carrega a classe MPdf */

ini_set("memory_limit","2048M");
ini_set("display_errors",0);
require_once("../externos/mpdf/mpdf.php");

require_once('../inc/conectar.php');
require_once('../inc/sql.php');
require_once('../inc/restricao.php');
if(!empty($usuario_filial)){
    $_GET['cc2'] = $usuario_filial;
}
$sql_cc1 = func_dados_cc1($_GET['cc1']);
$dados_cc1 = $sql_cc1->fetch(PDO::FETCH_ASSOC);
$sql_cc2 = func_dados_cc2($_GET['cc2']);
$filial = '';
if($sql_cc2->rowCount() == 1){
    $dados_cc2 = $sql_cc2->fetch(PDO::FETCH_ASSOC);
    $filial = '<b>Filial: </b>'.utf8_encode($dados_cc2['nome_filial']);
}
$tipo = '<b>Transações:</b> <font color="blue">Realizadas</font>';
$colspanCliente = 2;
$colspanDescricao = 1;
if($_GET['efetivado'] == 2){
    $tipo = '<b>Transações:</b> <font color="red">Não Realizadas</font>';
    $colspanCliente = 3;
    $colspanDescricao = 2;
}

$sql_titulos = func_buscar_titulos_periodo($_GET['cc1'],$_GET['cc2'],$_GET['inicio'],$_GET['fim'],1,$_GET['efetivado']);

//monto o cache de cada_pagina
//    <!-- CSS DE IMPRESSAO -->

$css = '
.tbl-topo {
    font-family: "Open Sans", sans-serif;
    font-size: 12px;
    color: #707070;
}

.tbl-corpo {
    font-family: "Open Sans", sans-serif;
    font-size: 12px;
    color: #3E3E3E;
    margin-top: -10px;
    vertical-align: top;
}

.tbl-rodape {
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    color: #FFFFFF;
    position:absolute;
    bottom:0;
    width:100%;
    margin-top: 10px;
}
';

$html_texto = '
<html>

<body>
<table style="font-size: 10px" width="100%" cellpadding="4" cellspacing="0" class="tbl-topo" border="1">
<thead>
    <tr  style="margin-bottom:20px">
        <td colspan="2" align="center"><img height="80px" src="../img/sistema/logo.jpg" /><br>
        <font size="-4">'.date('d/m/Y H:i:s').'<br>
            '.$usuario_nome.'</font>
        </td>
        <td colspan="7" align="center"><b>Relatório de Despesas</b><br>
        <b>Empresa: </b> '.utf8_encode($dados_cc1['nome']).'<br>
        '.$filial.'<br>
        <b>Período: </b>'.$_GET['inicio'].' até '.$_GET['fim'].'.<br>
        '.$tipo.'
        </td>
    </tr>
                <tr bgcolor="silver">
                    <td align="center" width="10%"><b>Título</b></td>
                    <td align="center" colspan="'.$colspanCliente.'" ><b>Cliente / Fornecedor</b></td>
                    <td align="center" colspan="'.$colspanDescricao.'"><b>Descrição</b></td>
                    <td align="center" width=""><b>Vencimento</b></td>
                    <td align="center" width=""><b>Valor</b></td>';

                    if($_GET['efetivado'] == 1){
                       $html_texto .='
                        <td align="center" width=""><b>Data de Pagamento</b></td>
                        <td align="center" width=""><b>Valor Pago</b></td>';
                    }
$html_texto .='<td align="center" width=""><b>Conta</b></td>
                </tr>
</thead>
<tbody>
';
$totalValor = 0;
$totalValorPago = 0;
while($dados_despesa = $sql_titulos->fetch(PDO::FETCH_ASSOC)){
    $totalValor += $dados_despesa['valor'];
    $totalValorPago += $dados_despesa['valor_pagto'];
    $nomeFantasia = '';
    if(!empty($dados_despesa['nome_fantasia'])){
        $nomeFantasia = ' ('.utf8_encode($dados_despesa['nome_fantasia']).')';
    }
    $html_texto .= '<tr>
                    <td align="center" width="10%">'.$dados_despesa['id_titulo'].'</td>
                    <td align="left" colspan="'.$colspanCliente.'" >'.utf8_encode($dados_despesa['nome']).$nomeFantasia.'</td>
                    <td align="left" colspan="'.$colspanDescricao.'" >'.substr(utf8_encode($dados_despesa['descricao']),0,30).'..'.'</td>
                    <td align="center">'.format_data($dados_despesa['vencimento']).'</td>
                    <td align="right"><font color="red">- R$ '.format_valor($dados_despesa['valor']).'</font></td>';
    if($_GET['efetivado'] == 1){
        $html_texto .='
                        <td align="center">'.format_data($dados_despesa['data_pagto']).'</td>
                    <td align="right"><font color="red">- R$ '.format_valor($dados_despesa['valor_pagto']).'</font></td>';
    }
    $html_texto .= '
<td align="left">'.utf8_encode($dados_despesa['nome_conta']).'</td>
</tr>';
}
if($_GET['efetivado'] == 2) {
    $html_texto .= '
<tr bgcolor="silver">
    <td colspan="7" align="right"><b>Total: </b></td>
    <td align="right"><b><font color="red">- R$ ' . format_valor($totalValor) . '</font></b></td>
    <td align="right"></td>
</tr>
</tbody>
</table>

</body>

</html>
';
}
if($_GET['efetivado'] == 1) {
    $html_texto .= '
<tr bgcolor="silver">
    <td colspan="5" align="right"><b>Total: </b></td>
    <td align="right"><b><font color="red">- R$ ' . format_valor($totalValor) . '</font></b></td>
    <td align="right"></td>
    <td align="right"><b><font color="red">- R$ ' . format_valor($totalValorPago) . '</font></b></td>
    <td></td>
</tr>
</tbody>
</table>

</body>

</html>
';
}
//echo $html_texto;

$mpdf=new mPDF('c', 'A4-L');
$mpdf->SetAuthor('ActiveApp'); //Autor
//$mpdf->SetSubject(''); //Assunto
$mpdf->SetTitle('Despesas'); //Titulo
//$mpdf->SetProtection(array('copy','print'), '', '#minhasenha'); // Permite apenas copiar e imprimir
//$mpdf->SetHeader($head);
//$rodape = '{DATE j/m/Y H:i}|{PAGENO}/{nb}';
$rodape = '{PAGENO} / {nb}';
$mpdf->SetFooter($rodape);
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetMargins(2,2,7,15);
//$mpdf->watermark('prado');
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html_texto);
$mpdf->Output('despesas.pdf', 'I'); // 'D' para forçar o download;
