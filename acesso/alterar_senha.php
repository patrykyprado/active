<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sql_usuario = func_usuario($_POST['usuario_id']);
    $dados_usuario = $sql_usuario->fetch(PDO::FETCH_ASSOC);
    if($dados_usuario['senha'] != $_POST['senha_atual']){
        echo "<script language='javascript'>
alert('Sua senha atual não confere') ;
location.href='alterar_senha.php';
</script>";
    }
    if(empty($_POST['nova_senha']) || empty($_POST['nova_senha2'])){
        echo "<script language='javascript'>
alert('Sua senha nova não pode ficar em branco.') ;
location.href='alterar_senha.php';
</script>";
    }
    if($_POST['nova_senha'] != $_POST['nova_senha2']){
        echo "<script language='javascript'>
alert('A nova senha não confere com a confirmação.') ;
location.href='alterar_senha.php';
</script>";
        return;
    }

    $sql_atualizar = func_atualizar_senha($_POST['usuario_id'], $_POST['nova_senha']);
    if($sql_atualizar->rowCount() == 1){
        echo "<script language='javascript'>
alert('Senha alterada com sucesso.') ;
location.href='index.php';
</script>";
        return;
    }
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
                        <h1>Alterar Senha</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Blank Header -->

        <!-- Get Started Block -->
        <div class="block full">
            <form action="#" method="post">
                <input type="hidden" name="usuario_id" value="<?= $usuario_id;?>"/>
                <table width="50%" align="center">
                    <tr>
                        <td><b>Senha Atual:</b></td>
                        <td><input type="password" required="required" name="senha_atual"/> </td>
                    </tr>
                    <tr>
                        <td><b>Nova Senha:</b></td>
                        <td><input type="password" required="required" name="nova_senha"/> </td>
                    </tr>
                    <tr>
                        <td><b>Confirme a Senha:</b></td>
                        <td><input type="password" required="required" name="nova_senha2"/> </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><button class="btn btn-success">Confirmar Alteração</button> </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>