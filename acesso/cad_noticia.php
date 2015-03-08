<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php'?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php';

?>

    <!-- Page content -->
    <div id="page-content">
        <!-- Blank Header -->
        <div class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-section">
                        <h1>Cadastro de Notícias</h1>
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
            <div class="block-title">
                <h2>Dados da Notícia</h2>
            </div>
            <!-- END Get Started Title -->
<form method="POST" action="salvar_noticia.php" enctype="multipart/form-data">
    <table class="table-featured " width="100%">
        <tr>
            <td align="center"><b>Título: <input type="text" name="titulo" style="width: 50%;"/> Data: <input style="width: 100px;" type="text" id="data" name="data" value="<?php echo date('d/m/Y');?>" class="input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy"> </b></td>
        </tr>
        <tr>
            <td align="center"><b>Imagem Principal: <input name="userfile" type="file" /></b></td>
        </tr>
        <tr>
            <td align="center"> <br><br><br><div class="block-title">
                    <h2>Conteúdo da Notícia</h2>
                </div></td>
        </tr>
        <tr>
            <td><textarea style="width: 100%" name="conteudo" id="conteudo" class="ckeditor"></textarea> </td>
        </tr>
        <tr>
            <td align="center"><br><br><input type="submit" class="btn btn-effect-ripple btn-primary" value="Salvar Notícia"/></td>
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