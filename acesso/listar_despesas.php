<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php';
$sql_cc1 = func_drop_cc1($usuario_empresa);
$sql_cc2 = func_drop_cc2($usuario_empresa, $usuario_filial);
$botaoPdf = '';

if(isset($_GET['busca'])){
    $sql_titulos = func_buscar_titulos_periodo($_GET['cc1'],$_GET['cc2'],$_GET['inicio'],$_GET['fim'],1,$_GET['efetivado']);
    $botaoPdf = '<a target="_blank" href="listar_despesas_pdf.php?'.requestCompleto().'"><button class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Gerar PDF</button></a>';
}
?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php'; ?>

    <!-- Page content -->
    <div id="page-content">
        <!-- Blank Header -->
        <div class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-section">
                        <h1>Buscar - Despesas</h1>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="header-section">
                        <ul class="breadcrumb breadcrumb-top">
                            <?= $botaoPdf;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Blank Header -->

        <!-- Get Started Block -->
        <div class="block full">
            <!-- Get Started Title -->
            <div class="block-title">
                <form action="#" method="get">
                    <input type="hidden" name="busca" value="1"/>
                <b>Empresa: </b>
                <select name="cc1" required="required" style="width: 150px">
                    <?php
                    while($dados_cc1 = $sql_cc1->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <option <?= selected($dados_cc1['id'], $_GET['cc1']);?> value="<?= $dados_cc1['id'];?>"><?= utf8_encode($dados_cc1['nome']);?></option>
                        <?php
                    }
                    ?>
                </select>
                <?= requerido();?>
                <b style="margin-left: 20px">Filial: </b>
                <select name="cc2" style="width: 200px">
                    <option selected="selected" value="">Selecione a Filial</option>
                    <?php
                    while($dados_cc2 = $sql_cc2->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <option <?= selected($dados_cc2['id'], $_GET['cc2']);?> value="<?= $dados_cc2['id'];?>"><?= utf8_encode($dados_cc2['nome_filial']);?></option>
                        <?php
                    }
                    ?>
                </select>
                <?= requerido()?><br>
                <b>Período: </b>
                <input type="text" name="inicio" value="<?= $_GET['inicio'];?>" required="required" readonly="readonly" class="default-date-picker" style="width: 90px"/>
                até
                <input type="text" name="fim" required="required" value="<?= $_GET['fim'];?>" readonly="readonly" class="default-date-picker" style="width: 90px"/>
                <b style="margin-left: 20px">Efetivado: </b>
                <select name="efetivado" style="width: auto">
                    <option <?= selected(1, $_GET['efetivado']);?>  value="1">Sim</option>
                    <option <?= selected(2, $_GET['efetivado']);?> value="2">Não</option>
                </select>
                <button class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                </form>
            </div>
            <!-- END Get Started Title -->
            <?php
            if(!isset($sql_titulos)){
                ?>
                <center>Nenhuma busca realizada, pesquise acima para encontrar.</center>
            <?php
            } else {
                if($sql_titulos->rowCount() == 0){
                    ?>
                    <center>Nenhum título encontrado para o período <b><?= $_GET['inicio'];?> até <?= $_GET['fim'];?> </b>, realize outra busca.</center>
                    <?php
                } else {
                    ?>
            <table border="1" width="100%" style="font-size: 10px" class="table-bordered table-striped table-condensed table-hover">
                <tr>
                    <td align="center" width="10%"><b><font size="+0.5">Ações</b></font></td>
                    <td align="center" width="10%"><b><font size="+0.5">Título</b></font></td>
                    <td align="center" width=""><b><font size="+0.5">Cliente / Fornecedor</b></font></td>
                    <td align="center" width=""><b><font size="+0.5">Vencimento</b></font></td>
                    <td align="center" width=""><b><font size="+0.5">Valor</b></font></td>
                    <?php
                    if($_GET['efetivado'] == 1){
                        ?>
                        <td align="center" width=""><b><font size="+0.5">Data de Pagamento</b></font></td>
                        <td align="center" width=""><b><font size="+0.5">Valor Pago</b></font></td>
                        <?php
                    }
                    ?>
                    <td align="center" width=""><b><font size="+0.5">Conta</b></font></td>
                </tr>
                <?php
                $totalValor = 0;
                $totalValorPago = 0;
                while($dados_despesa = $sql_titulos->fetch(PDO::FETCH_ASSOC)) {
                    $nomeFantasia = '';
                    if(!empty($dados_despesa['nome_fantasia'])){
                        $nomeFantasia = ' ('.utf8_encode($dados_despesa['nome_fantasia']).')';
                    }
                    $totalValor += $dados_despesa['valor'];
                    $totalValorPago += $dados_despesa['valor_pagto'];
                    ?>
                    <tr>
                        <td align="center" width="10%">
                            <a target="_blank" title="Editar Título" href="editar_titulo.php?id=<?= $dados_despesa['id_titulo'];?>">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td align="center" style="cursor: help" title="<?= utf8_encode($dados_despesa['descricao']);?>">
                            <?= $dados_despesa['id_titulo'];?>
                        </td>
                        <td align="center" width="">
                            <?= utf8_encode($dados_despesa['nome']).$nomeFantasia;?>
                        </td>
                        <td align="center">
                            <?= format_data($dados_despesa['vencimento']);?>
                        </td>
                        <td align="right">
                            R$ <?= format_valor($dados_despesa['valor']);?>
                        </td>
                        <?php
                        if ($_GET['efetivado'] == 1) {
                            ?>
                            <td align="center">
                                <?= format_data($dados_despesa['data_pagto']);?>
                            </td>
                            <td align="right">
                                R$ <?= format_valor($dados_despesa['valor_pagto']);?>
                            </td>
                            <?php
                        }
                        ?>
                        <td align="left">
                            <?= utf8_encode($dados_despesa['nome_conta']);?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="4" align="right"><b>Total: </b></td>
                    <td align="right"><b>R$ <?= format_valor($totalValor);?></b></td>
                    <?php
                    if ($_GET['efetivado'] == 1) {
                        ?>
                        <td colspan="2" align="right"><b>R$ <?= format_valor($totalValorPago);?></b></td>
                        <?php
                    }
                    ?>
                </tr>


            </table>
                    <?php
                }
            }
            ?>
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>