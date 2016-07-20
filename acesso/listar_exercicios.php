<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php';
$sql_exercicios = func_buscar_exercicios('');

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
                        <h1>Lista de Exercícios</h1>
                    </div>
                </div>
                <div class="col-sm-6 hidden-xs">
                    <div class="header-section">
                        <ul class="breadcrumb breadcrumb-top">
                            <a href="cad_exercicio.php"><button class="btn btn-warning"><i class="fa fa-plus"></i> Novo Exercício </button></a>
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
            <table border="1" width="100%" class="table-bordered table-striped table-condensed table-hover">
                <tr>
                    <td align="center" width="10%"><b><font size="+0.5">Ações</b></font></td>
                    <td align="center" width="10%"><b><font size="+0.5">Código</b></font></td>
                    <td align="center" width=""><b><font size="+0.5">Exercício</b></font></td>
                </tr>
                <?php
                while($dados_exercicio = $sql_exercicios->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td align="center" width="10%">
                            <a data-toggle="modal" class="tooltips" data-placement="top" data-original-title="Descrição" title="Descrição"
                               data-target="#modalBranco" href="exercicio_descricao.php?id=<?= $dados_exercicio['id'];?>">
                            <font size="+1"><i class="fa fa-exclamation-circle"></i></font>
                            </a>

                            <a data-toggle="modal" class="tooltips" data-placement="top" data-original-title="Equipamentos e Orientações" title="Equipamentos e Orientações"
                               data-target="#modalBranco" href="exercicio_equipamentos.php?id=<?= $dados_exercicio['id'];?>">
                                <font size="+1"><i class="fa fa-bicycle"></i></font>
                            </a>
                        </td>
                        <td align="center" width="10%"><?= $dados_exercicio['id'];?></td>
                        <td align="center" width="10%"><?= utf8_encode($dados_exercicio['exercicio']);?></td>
                    </tr>
                    <?php
                }
?>
            </table>
            <div id="modalBranco" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            </div>
                    </div>
                </div>
            </div>
            <!-- Get Started Content -->

            <!-- END Get Started Content -->
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>