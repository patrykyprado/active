<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php'?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php';
$get_banner = $_GET['id_banner'];
$sql_banner = func_editar_banner($get_banner);
$dados_banner = $sql_banner->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $uploaddir = '../website/banners/img/';
        $uploadfile = $uploaddir . ($_FILES['userfile']['name']);

    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $array_banner = array();
        $array_banner['img'] = basename($_FILES['userfile']['name']);
        $array_banner['link'] = $_POST['link'];
        $array_banner['id_banner'] = $_POST['id_banner'];
        $sql_salvar_edicao_banner = func_edicao_banner($array_banner);
        echo "<script language=\"javascript\">
        alert('Arquivo alterado com sucesso!');
        window.close();
        </script>";
    } else {
        echo "<script language=\"javascript\">
        alert('Não foi possível salvar!');
        window.close();
        </script>";
    }
}
?>

    <!-- Page content -->
    <div id="page-content">
        <!-- Blank Header -->
        <div class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-section">
                        <h1>Edição de Banner</h1>
                    </div>
                </div>
                <div class="col-sm-6 hidden-xs">
                    <div class="header-section">
                        <ul class="breadcrumb breadcrumb-top">
                            <?php echo $dados_pagina['caminho'];?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Blank Header -->

        <!-- Get Started Block -->
        <div class="block full">
            <!-- Get Started Title -->
            <form action="#" method="post" enctype="multipart/form-data">
            <table width="40%" align="center" border="1">
                <tr>
                    <input name="id_banner" style="width: 250px" value="<?php echo $dados_banner['id_banner']?>" type="hidden" />
                    <td width="80px"><b>ID. Banner:</b></td>
                    <td align="left"><?php echo $dados_banner['id_banner'];?></td>
                </tr>
                <tr>
                    <td><b>Imagem:</b></td>
                    <td><input name="userfile" type="file" /> </td>
                </tr>
                <tr>
                    <td><b>Link:</b></td>
                    <td><input name="link" style="width: 250px" value="<?php echo $dados_banner['link']?>" type="text" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" class="btn btn-effect-ripple btn-primary" value="Salvar"/></td>
                </tr>
            </table>
            <!-- END Get Started Title -->
            </form>
        </div>

        <!-- END Get Started Block -->


    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>