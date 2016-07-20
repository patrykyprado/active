<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sql_inserir = func_inserir_exercicio($_POST);
    if($sql_inserir->rowCount() == 0){
        echo "<script language=\"javascript\">
    alert('Não foi possível inserir a atividade!');
    location.href='cad_exercicio.php';
    </script>";
    } else {
        echo "<script language=\"javascript\">
    alert('Exercício cadastrado com sucesso!');
    location.href='listar_exercicios.php';
    </script>";
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
                        <h1>Cadastro de Exercícios</h1>
                    </div>
                </div>
                <div class="col-sm-6 hidden-xs">
                    <div class="header-section">
                        <ul class="breadcrumb breadcrumb-top">
                            <a href="listar_exercicios.php"><button class="btn btn-danger"><i class="fa fa-list"></i> Lista de Exercicios </button></a>
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
                <h2>Exercicios Disponíveis</h2>
            </div>
            <!-- END Get Started Title -->

            <!-- Get Started Content -->
            <form action="#" method="POST">
                <input type="hidden" name="tipo_documento" value="1" />
                <table width="100%">
                    <tr>
                        <td width="150px"><b>Nome do Exercício: </b></td>
                        <td colspan="3"><input type="text" style="width: 80%" name="exercicio" id="exercicio"/> </td>
                    </tr>
                </table>

                <br><br>
                <div class="block-title">
                    <h2>Relação e Recomendações de Equipamentos</h2>
                </div>
                <table width="100%">
                    <tr>
                        <td colspan="4"><textarea style="width: 100%" name="equipamentos" id="equipamentos" class="ckeditor"></textarea> </td>
                    </tr>
                </table>
                <br><br>
                <div class="block-title">
                    <h2>Descrição do Exercício</h2>
                </div>
                <table width="100%">

                    <tr>
                        <td colspan="4"><textarea style="width: 100%" name="descricao" id="descricao" class="ckeditor"></textarea> </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center"><br><br><button type="submit" class="btn btn-effect-ripple btn-primary">Salvar</button></td>
                    </tr>
                </table>
            </form>
            <!-- END Get Started Content -->
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>