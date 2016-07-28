<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');

$sql_cliente_fornecedor = '';
if(isset($_GET['busca'])){
    $sql_cliente_fornecedor = func_lista_cliente_fornecedor(0,$_GET['busca']);
    $total_encontrado = $sql_cliente_fornecedor->rowCount();
}

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
                        <h1>Clientes e Fornecedores</h1>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="header-section">
                        <ul class="breadcrumb breadcrumb-top">
                            <a href="cad_cliente.php"><button class="btn btn-warning"><i class="fa fa-plus"></i> Novo Cliente / Fornecedor </button></a>
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
                <form method="get" action="listar_clientes.php">
                    <b>Buscar: </b> <input name="busca" type="text" style="width: 50%"/>
                    <button class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                </form>
            </div>
            <!-- END Get Started Title -->
            <?php
            if(empty($sql_cliente_fornecedor)) {
                echo '<center>Realize a busca acima para encontrar o Cliente / Fornecedor.</center>';
            } else {
                if ($total_encontrado == 0) {
                    echo '<center>Nenhum resultado Encontrado</center>';
                } else {
                    echo "<table border=\"1\" width=\"100%\" class=\"table-bordered table-striped table-condensed table-hover\">
                <tr>
                    <td align=\"center\"><b><font size=\"+0.5\">Ações</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Cód. Cliente</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Nome</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Documento</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Convênio</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Convênio Validade</b></font></td>
               </tr>";
                    while ($dados_cliente_fornecedor = $sql_cliente_fornecedor->fetch(PDO::FETCH_ASSOC)) {
                        $cliente_codigo = $dados_cliente_fornecedor['codigo'];
                        $cliente_razao_social = utf8_encode($dados_cliente_fornecedor['razao_social']);
                        if (!empty($dados_cliente_fornecedor['nome_fantasia'])) {
                            $cliente_razao_social .= ' (' . utf8_encode($dados_cliente_fornecedor['nome_fantasia']) . ')';
                        }
                        $cliente_cnpj = $dados_cliente_fornecedor['documento'];
                        $cliente_tipo = $dados_cliente_fornecedor['tipo_cliente'];
                        $cliente_status = $dados_cliente_fornecedor['status_cliente'];
                        if ($cliente_status != '0') {
                            $icone_inativar = "<i data-toggle=\"tooltip\" data-placement=\"top\" title=\"Inativar Cliente/Fornecedor\" style=\"color: green;\" class=\"fa fa-check\"></i>";
                            $link_inativar = "0";
                        } else {
                            $icone_inativar = "<i data-toggle=\"tooltip\" data-placement=\"top\" title=\"Ativar Cliente/Fornecedor\" style=\"color: red;\" class=\"fa fa-times\"></i>";
                            $link_inativar = "1";
                        }
                        echo "
                <tr>
                    <td align=\"center\">
                    <a target='_blank' href=\"inativar_cliente.php?codigo=$cliente_codigo&tipo=$link_inativar\" title=\"Inativar/Ativar Cliente/Fornecedor\">$icone_inativar</a>
                    <a target='_blank' href=\"editar_cliente.php?codigo=$cliente_codigo\" title=\"Editar Cliente/Fornecedor\"><i data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar Cliente/Fornecedor\" style=\"color: cornflowerblue;\" class=\"fa fa-pencil-square-o\"></i></a> </b></td>

                    <td align=\"center\"><b>$cliente_codigo</b></td>
                    <td align=\"left\">$cliente_razao_social</td>
                    <td align=\"center\"><b>$cliente_cnpj</b></td>
                    <td align=\"center\"><b>" . $dados_cliente_fornecedor['convenio'] . ' ' . ($dados_cliente_fornecedor['convenio_nome']) . "</b></td>
                    <td align=\"center\"><b>" . $dados_cliente_fornecedor['convenio_validade'] . "</b></td>
               </tr>";

                    }
                    echo "</table>";
                }
            }
            ?>
        </div>

        <!-- END Get Started Block -->


    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>