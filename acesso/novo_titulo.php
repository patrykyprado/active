<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php'?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php';

if(1 == $_GET['tipo']){
    $tipo_titulo = "A Pagar";
} else {
    $tipo_titulo = "A Receber";
}
?>

    <!-- Page content -->
    <div id="page-content">
        <!-- Blank Header -->
        <div class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-section">
                        <h1>Cadastro de Títulos - <?php echo $tipo_titulo;?></h1>
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
                <h2>Dados do Título</h2>
            </div>
            <!-- END Get Started Title -->

            <!-- Get Started Content -->
            <form action="novo_titulo.php" method="POST">
                <table width="100%">
                    <tr>
                        <td width="150px"><b>Conta do Título</b></td>
                        <td colspan="3"><input type="text"  style="width: 80%" name="conta" id="conta"/>

                        </td>
                    </tr>
                    <tr>
                        <td width="150px"><b>Cliente / Fornecedor </b></td>
                        <td colspan="3"><input type="text" readonly style="width: 80%" name="cliente_fornecedor" id="cliente_fornecedor"/>
                            <input type="hidden" style="width: 80%" name="cliente_fornecedor_id" id="cliente_fornecedor_id"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px"><b>Documento Fiscal </b></td>
                        <td colspan=""><input type="text" style="width: 200px" name="documento_fiscal" id="documento_fiscal"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px"><b>Vencimento </b></td>
                        <td colspan=""><input type="text"  maxlength="10" id="vencimento" name="vencimento" class="input-datepicker"
                                   data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" style="width: 200px;">
                        </td>
                    </tr>
                    <tr>
                        <td width="150px"><b>Parcelas</b></td>
                        <td colspan=""><input type="text" value="1" style="width: 50px" name="parcelas" id="parcelas"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px"><b>Valor do Título </b></td>
                        <td colspan=""><input type="text" class="f_moeda" style="width: 100px" name="valor" id="valor"/>
                        </td>
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