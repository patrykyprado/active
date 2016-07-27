<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php';
$total = 0;
if(isset($_GET['busca'])){
    $sql_clientes = func_buscar_cliente_fornecedor($_GET['busca']);
    $total = $sql_clientes->rowCount();
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
                        <h1>Buscar - Receitas</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Blank Header -->

        <!-- Get Started Block -->
        <div class="block full">
            <!-- Get Started Title -->
            <div class="block-title">
                <form action="listar_receitas.php" method="get">
                    <b>Cliente / Fornecedor: </b>
                    <input name="busca" style="width: 50%" />
                    <button class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                </form>
            </div>
            <!-- END Get Started Title -->

            <!-- Get Started Content -->
            <?php
            if($total == 0){
                ?>
                <center>Realize a busca acima para encontrar o Cliente / Fornecedor.</center>
                <?php
            } else {
                ?>
                <table border="1" width="100%" class="table-bordered table-striped table-condensed table-hover">
                    <tr>
                        <td align="center" width="10%"><b><font size="+0.5">Código</b></font></td>
                        <td align="center" width=""><b><font size="+0.5">Nome</b></font></td>
                        <td align="center" width=""><b><font size="+0.5">Documento</b></font></td>
                        <td align="center" width=""><b><font size="+0.5">Convênio</b></font></td>
                    </tr>
                    <?php
                    while($dados_cliente = $sql_clientes->fetch(PDO::FETCH_ASSOC)){
                        $nomeFantasia = '';
                        if($dados_cliente['']){
                            $nomeFantasia = ' ('.utf8_encode($dados_cliente['nome_fantasia']).')';
                        }
                        ?>
                        <tr>
                            <td align="center"  width="10%"><a href="detalhes_receita.php?id=<?= $dados_cliente['codigo'];?>"><?= $dados_cliente['codigo'];?></a></td>
                            <td align="left"><a href="detalhes_receita.php?id=<?= $dados_cliente['codigo'];?>"><?= utf8_encode($dados_cliente['razao_social']).$nomeFantasia;?></a></td>
                            <td align="left"><a href="detalhes_receita.php?id=<?= $dados_cliente['codigo'];?>"><?= $dados_cliente['documento'];?></a></td>
                            <td align="left"><a href="detalhes_receita.php?id=<?= $dados_cliente['codigo'];?>"><?= $dados_cliente['convenio'].' ('.($dados_cliente['convenio_nome']).')';?></a></td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
                <?php
            }
            ?>
            <!-- END Get Started Content -->
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>