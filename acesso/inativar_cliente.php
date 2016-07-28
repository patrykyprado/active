<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$semMenu = 1;
include '../inc/config.php';
include '../inc/restricao.php';
$sql_cliente = func_dados_cliente($_GET['codigo']);
$dados_cliente = $sql_cliente->fetch(PDO::FETCH_ASSOC);
if (!empty($dados_cliente['nome_fantasia'])) {
    $nomeFantasia = ' (' . utf8_encode($dados_cliente['nome_fantasia']) . ')';
}
$tipoExib = '<font color="red"><b>INATIVAR</b></font>';
if($_GET['tipo'] == 1){
    $tipoExib = '<font color="green"><b>ATIVAR</b></font>';
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){//INATIVAR CLIENTE
    $get_codigo = $_POST['codigo'];
    $get_tipo = $_POST['tipo'];
    $inativar_cliente = func_inativar_cliente($get_codigo,$get_tipo);
    echo "<script language=\"javascript\">
    alert('".$inativar_cliente."');
    window.opener.location.reload();
    window.close()
    </script>";
}
?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php'; ?>

    <!-- Page content -->
    <div id="page-content">
        <!-- Blank Header -->
        <!-- END Blank Header -->

        <!-- Get Started Block -->
        <div class="block full">
            <center>Deseja realmente <?= $tipoExib;?> o <b>Cliente / Fornecedor: </b><?= $dados_cliente['codigo'].' - '.utf8_encode($dados_cliente['razao_social']).$nomeFantasia;?>?
            <form action method="post">
                <br>
                <input type="hidden" name="codigo" value="<?= $dados_cliente['codigo'];?>" />
                <input type="hidden" name="tipo" value="<?= $_GET['tipo'];?>" />
                <button class="btn btn-success">
                    <i class="fa fa-check"></i> Confirmar
                </button>
                <button onclick="window.close();" class="btn btn-danger">
                    <i class="fa fa-times-circle"></i> Cancelar
                </button>
            </form>
            </center>

        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>