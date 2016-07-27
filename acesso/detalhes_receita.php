<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php';
$sql_cliente = func_dados_cliente($_GET['id']);
$dados_cliente = $sql_cliente->fetch(PDO::FETCH_ASSOC);
$nomeFantasia = '';
if(!empty($dados_cliente['nome_fantasia'])){
    $nomeFantasia = ' ('.utf8_encode($dados_cliente['nome_fantasia']).')';
}
$sql_receitas_pendentes = func_buscar_titulos($dados_cliente['codigo'], 2, 1);
$sql_receitas_efetivados = func_buscar_titulos($dados_cliente['codigo'], 2, 2);

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
                        <h1>Detalhamento Individual</h1><br>
                        <b>Cliente: </b><?= $dados_cliente['codigo'].' - '.utf8_encode($dados_cliente['razao_social']).$nomeFantasia?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="header-section">
                        <ul class="breadcrumb breadcrumb-top">
                            <a href="listar_receitas.php"><button class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Nova Busca </button></a>
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
                <ul class="nav nav-tabs" data-toggle="tabs">
                    <li class="active"><a href="#receitasPendentes">Receitas Pendentes</a></li>
                    <li class=""><a href="#receitasEfetivadas">Receitas Efetivadas</a></li>
                </ul>
            </div>
            <!-- END Get Started Title -->

            <!-- Get Started Content -->
            <!-- Tabs Content -->
            <div class="tab-content">
                <div class="tab-pane active" id="receitasPendentes">
                    <?php
                    if($sql_receitas_pendentes->rowCount() == 0){
                        ?>
                        <center>Nenhuma receita pendente encontrada.</center>
                        <?php
                    } else {
                        ?>
                    <table border="1" width="100%" class="table-bordered table-striped table-condensed table-hover">
                        <tr>
                            <td align="center" width="10%"><b><font size="+0.5">Ações</b></font></td>
                            <td align="center" width="10%"><b><font size="+0.5">Título</b></font></td>
                            <td align="center" width=""><b><font size="+0.5">Vencimento</b></font></td>
                            <td align="center" width=""><b><font size="+0.5">Valor</b></font></td>
                            <td align="center" width=""><b><font size="+0.5">Situação</b></font></td>
                            <td align="center" width=""><b><font size="+0.5">Conta</b></font></td>
                        </tr>
                        <?php
                        $pendenteTotal = 0;
                        while($dados_pendente = $sql_receitas_pendentes->fetch(PDO::FETCH_ASSOC)){
                            $pendenteTotal += $dados_pendente['valor'];
                            $situacao = 'Normal';
                            if($dados_pendente['ativo'] == 0){
                                $situacao = 'Cancelado';
                            }
                            ?>
                        <tr>
                            <td align="center">
                                <a target="_blank" title="Editar Título" href="editar_titulo.php?id=<?= $dados_pendente['id_titulo'];?>">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <?php
                                if(!empty($dados_pendente['layout'])){
                                    ?>
                                    <a target="_blank" title="Gerar Boleto" href="../externos/boleto/<?= $dados_pendente['layout']?>?idTitulo=<?= $dados_pendente['id_titulo'];?>&clienteFornecedor=<?= $dados_pendente['cliente_fornecedor'];?>&parcela=<?= $dados_pendente['parcela'];?>">
                                        <i class="fa fa-barcode"></i>
                                    </a>
                                <?php
                                }
                                ?>
                            </td>
                            <td align="center">
                                <?= $dados_pendente['id_titulo'];?>
                            </td>
                            <td align="center">
                                <?= format_data($dados_pendente['vencimento']);?>
                            </td>
                            <td align="right">
                                R$ <?= format_valor($dados_pendente['valor']);?>
                            </td>
                            <td align="center">
                                <?= $situacao;?>
                            </td>
                            <td align="left">
                                <?= utf8_encode($dados_pendente['nome_conta']);?>
                            </td>
                        </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="3" align="right"><b>Total: </b></td>
                            <td align="right"><b>R$ <?= format_valor($pendenteTotal);?></b></td>
                        </tr>
                    </table>
                        <?php
                    }
                    ?>
                </div>

                <div class="tab-pane " id="receitasEfetivadas">
                    <?php
                    if($sql_receitas_efetivados->rowCount() == 0){
                        ?>
                        <center>Nenhuma receita efetivada encontrada.</center>
                        <?php
                    } else {
                        ?>
                        <table border="1" width="100%" class="table-bordered table-striped table-condensed table-hover">
                            <tr>
                                <td align="center" width="10%"><b><font size="+0.5">Ações</b></font></td>
                                <td align="center" width="10%"><b><font size="+0.5">Título</b></font></td>
                                <td align="center" width=""><b><font size="+0.5">Vencimento</b></font></td>
                                <td align="center" width=""><b><font size="+0.5">Valor</b></font></td>
                                <td align="center" width=""><b><font size="+0.5">Data de Pagamento</b></font></td>
                                <td align="center" width=""><b><font size="+0.5">Valor Efetivado</b></font></td>
                                <td align="center" width=""><b><font size="+0.5">Conta</b></font></td>
                            </tr>
                            <?php
                            $efetivadoTotal = 0;
                            while($dados_efetivado = $sql_receitas_efetivados->fetch(PDO::FETCH_ASSOC)){
                                $efetivadoTotal += $dados_efetivado['valor_pagto'];
                                ?>
                                <tr>
                                    <td align="center">
                                        <a target="_blank" title="Editar Título" href="editar_titulo.php?id=<?= $dados_efetivado['id_titulo'];?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <?= $dados_efetivado['id_titulo'];?>
                                    </td>
                                    <td align="center">
                                        <?= format_data($dados_efetivado['vencimento']);?>
                                    </td>
                                    <td align="right">
                                        R$ <?= format_valor($dados_efetivado['valor']);?>
                                    </td>
                                    <td align="center">
                                        <?= format_data($dados_efetivado['data_pagto']);?>
                                    </td>
                                    <td align="right">
                                        R$ <?= format_valor($dados_efetivado['valor_pagto']);?>
                                    </td>
                                    <td align="left">
                                        <?= utf8_encode($dados_efetivado['nome_conta']);?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="5" align="right"><b>Total: </b></td>
                                <td align="right"><b>R$ <?= format_valor($efetivadoTotal);?></b></td>
                            </tr>
                        </table>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- END Get Started Content -->
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>