<?php
session_start();
require_once('inc/conectar.php');
require_once('inc/sql.php');
include 'inc/config.php';
include 'inc/template_start_login.php';
$sql_config_app = func_config_app();
$dados_app = $sql_config_app->fetch(PDO::FETCH_ASSOC);
$erro = 0;
$manutencao = $dados_app['manutencao'];
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $sql_acessar = func_acessar_usuario($_POST['login-username'], $_POST['login-password']);
    if($sql_acessar->rowCount() == 1){
        $dados_acesso = $sql_acessar->fetch(PDO::FETCH_ASSOC);
        $_SESSION["user_id"] = $dados_acesso["id_usuario"];
        echo '<script language="javascript">
location.href = "acesso/index.php";
</script>';
    } else {
        $erro = 1;
    }
}
?>

    <!-- Login Container -->
    <div id="login-container">
        <!-- Login Header -->
        <!-- END Login Header -->

        <!-- Login Block -->
        <div class="block animation-fadeInQuickInv">
            <!-- Login Title -->
            <div class="block-title">
                <div class="block-options pull-right">
                    <a href="recuperar_senha.php" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Esqueceu sua senha? Clique aqui."><i class="fa fa-exclamation-circle"></i></a>
                </div>
                <h2>Painel de Acesso</h2>
            </div>
            <!-- END Login Title -->

            <!-- Login Form -->
            <form id="form-login" action="index.php" method="post" class="form-horizontal">
                <div class="form-group">
                    <center><img src="img/sistema/logo.jpg"/></center>
                    <?php
                    if($erro == 1){
                        echo " <div style=\"background-color: #d9534f; color: #f0f0f0\" align=\"center\">Usuário ou senha inválidos!</div>";
                    }
                    ?>

                    <div class="col-xs-12">
                        <div>Usuário:</div>
                        <input type="text" id="login-username" name="login-username" class="form-control" placeholder="Seu usuário..">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div>Senha:</div>
                        <input type="password" id="login-password" name="login-password" class="form-control" placeholder="Sua senha..">
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-xs-8">
                        <label class="csscheckbox csscheckbox-primary">
                            <input type="checkbox" id="login-remember-me" name="login-remember-me">
                            <span></span>
                        </label>
                        Lembre-me?
                    </div>
                    <div class="col-xs-4 text-right">
                        <button type="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-check"></i>Acessar</button>
                    </div>
                </div>
            </form>
            <!-- END Login Form -->
        </div>
        <!-- END Login Block -->

        <!-- Footer -->
        <footer class="text-muted text-center animation-pullUp">
            <small><a href="<?php echo $dados_app['site'];?>" target="_blank"><?php echo $dados_app['footer']?></a></small>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END Login Container -->

<?php include 'inc/template_scripts.php'; ?>

    <!-- Load and execute javascript code used only in this page -->
    <script src="js/pages/readyLogin.js"></script>
    <script>$(function(){ ReadyLogin.init(); });</script>

<?php include 'inc/template_end.php'; ?>