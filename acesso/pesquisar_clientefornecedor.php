<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$semMenu = 1;
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
                        <h1>Cliente / Fornecedor</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Blank Header -->

        <!-- Get Started Block -->
        <div class="block full">
            <!-- Get Started Title -->
            <div class="block-title">
                <form action="pesquisar_clientefornecedor.php" method="get">
                    <b>Buscar:</b> <input name="busca" style="width: 50%"/>
                    <button class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                </form>
            </div>
            <!-- END Get Started Title -->
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
                    <td align="center" width=""><b><font size="+0.5">E-mail</b></font></td>
                </tr>
                <?php
                while($dados_cliente = $sql_clientes->fetch(PDO::FETCH_ASSOC)){
                    $nomeFantasia = '';
                    if(!empty($dados_cliente['nome_fantasia'])){
                        $nomeFantasia = ' ('.utf8_encode($dados_cliente['nome_fantasia']).')';
                    }
                    ?>
                    <tr>
                        <td align="center" style="cursor: pointer;" onclick="enviar('<?= $dados_cliente['codigo'];?>');enviar2('<?= $dados_cliente['codigo'].' - '.utf8_encode($dados_cliente['razao_social']).$nomeFantasia;?>');" width="10%"><?= $dados_cliente['codigo'];?></td>
                        <td align="left" style="cursor: pointer;" onclick="enviar('<?= $dados_cliente['codigo'];?>');enviar2('<?= $dados_cliente['codigo'].' - '.utf8_encode($dados_cliente['razao_social']).$nomeFantasia;?>');"><?= utf8_encode($dados_cliente['razao_social']).$nomeFantasia;?></td>
                        <td align="left" style="cursor: pointer;" onclick="enviar('<?= $dados_cliente['codigo'];?>');enviar2('<?= $dados_cliente['codigo'].' - '.utf8_encode($dados_cliente['razao_social']).$nomeFantasia;?>');"><?= $dados_cliente['documento'];?></td>
                        <td align="left" style="cursor: pointer;" onclick="enviar('<?= $dados_cliente['codigo'];?>');enviar2('<?= $dados_cliente['codigo'].' - '.utf8_encode($dados_cliente['razao_social']).$nomeFantasia;?>');"><?= $dados_cliente['emails'];?></td>
                    </tr>
                    <?php
                }
                ?>

            </table>
                <?php
            }
            ?>
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>
<script>
    function enviar(valor){
        opener.document.getElementById('cliente_fornecedor').value = valor;
    }
    function enviar2(valor){
        opener.document.getElementById('cliente_fornecedor_nome').value = valor;
        this.close();
    }
</script>
