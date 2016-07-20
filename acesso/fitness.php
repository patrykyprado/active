<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php'?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php'; ?>

    <!-- Page content -->
    <div id="page-content">
        <!-- Blank Header -->
        <div class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-section">
                        <h1>Gerenciamento de Acadêmia</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Blank Header -->
            <!-- END Get Started Title -->
            <div class="col-xs-3">
                <a href="listar_exercicios.php" class="widget">
                    <div class="widget-content themed-background-info text-light-op text-center">
                        <div class="widget-icon">
                            <i class="fa fa-bicycle"></i>
                        </div>
                    </div>
                    <div class="widget-content text-dark text-center">
                        <strong>Cadastro de Exercicios</strong>
                    </div>
                </a>
            </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>