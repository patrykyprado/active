<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php'?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php';

$sql_banners = func_banner_site();
$total_banners = $sql_banners->rowCount();

if($_GET['acao'] == 1){//acao de edição
    $uploaddir = '../website/banners/img/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    $edicao_banner_array = array();
    $edicao_banner_array['id_banner'] = $_GET['id_banner'];
    $edicao_banner_array['link'] = $_GET['link'];
    $edicao_banner_array['img'] = basename($_FILES['userfile']['name']);

    //CONFIRMA A EDIÇÃO
    $editar_banner = func_edicao_banner($edicao_banner_array);
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "<script language=\"javascript\">
    alert('".$editar_banner."');
    history.go(-1);
    location.reload;
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
                        <h1>Banners do Site</h1>
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

<?php
if($total_banners == 0){
    echo '<center>Nenhum banner cadastrado!</center>';
} else {
    echo "<table border=\"1\" width=\"100%\" class=\"table-bordered table-striped table-condensed table-hover\">
                <tr>
                    <td align=\"center\"><b><font size=\"+0.5\">Ações</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">ID. Banner</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Arquivo</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Link</b></font></td>
               </tr>";

    while($dados_banner = $sql_banners->fetch(PDO::FETCH_ASSOC)){
        $banner_id = $dados_banner['id_banner'];
        $banner_img = $dados_banner['img'];
        $banner_url = $dados_banner['link'];

        echo "<tr>
                    <td align=\"center\"><a href=\"javascript:abrir('editar_banner.php?id_banner=$banner_id');\" title=\"Editar Banner\"><i data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar Banner\" style=\"color: cornflowerblue;\" class=\"fa fa-pencil-square-o\"></i></a> </b>
                    <a data-toggle=\"modal\" href=\"excluir_banner.php?id_banner=$banner_id\" data-target=\"#modal-excluir\" data-placement=\"top\" title=\"Excluir Banner\"><i data-toggle=\"tooltip\" data-placement=\"top\" title=\"Excluir Banner\" style=\"color:#ff0000;\" class=\"fa fa-trash\"></i></a> </b></td>
</td>
                    <td align=\"center\"><b>$banner_id</b></td>
                    <td align=\"\">$banner_img</td>
                    <td align=\"\">$banner_url</td>
               </tr>";
    }
    echo '</table>';
}
?>
            <br><br><br>
            <div class="block-title">
                <h2>Pré-Visualização de Banners</h2>
            </div>
<iframe src="../website/banners/index.php" frameborder="0" width="100%" height="400"></iframe>

            <div id="modal-editar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title"><strong>Editar Cliente / Fornecedor</strong></h3>
                        </div>
                        <div class="modal-body">
                            Deseja realmente excluir o cliente abaixo?<br>

                            <br><br>
                            <div align="center" style="color: #fffacd; background: #ff0000;">Atenção: a exclusão não poderá ser desfeita e todos os dados do cliente serão apagados.</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-effect-ripple btn-primary">Salvar Edição</button>
                            <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>

<script language="JavaScript">
    function abrir(URL) {

        var width = 700;
        var height = 400;

        var left = 99;
        var top = 99;

        window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

    }
</script>