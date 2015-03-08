<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php'?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php';

$sql_cliente_fornecedor = func_lista_cliente_fornecedor(0,null);
$total_encontrado = $sql_cliente_fornecedor->rowCount();
if($_GET['acao'] == 1){//acao de edição
    $edicao_cliente_array = array();
    $edicao_cliente_array['codigo'] = $_GET['codigo'];
    $edicao_cliente_array['razao_social'] = $_GET['razao_social'];
    $edicao_cliente_array['nome_fantasia'] = $_GET['nome_fantasia'];
    $edicao_cliente_array['cnpj'] = $_GET['cnpj'];
    $edicao_cliente_array['endereco'] = $_GET['endereco'];
    $edicao_cliente_array['numero'] = $_GET['numero'];
    $edicao_cliente_array['uf'] = $_GET['uf'];
    $edicao_cliente_array['cidade'] = $_GET['cidade'];
    $edicao_cliente_array['bairro'] = $_GET['bairro'];
    $edicao_cliente_array['cep'] = $_GET['cep'];
    $edicao_cliente_array['site'] = $_GET['site'];
    $edicao_cliente_array['contatos'] = $_GET['contatos'];
    $edicao_cliente_array['email']= $_GET['email'];
    $edicao_cliente_array['telefone'] = $_GET['telefone'];
    $edicao_cliente_array['celular'] = $_GET['celular'];
    //CONFIRMA A EDIÇÃO
    $editar_cliente = func_edicao_cliente($edicao_cliente_array);
    echo "<script language=\"javascript\">
    alert('".$editar_cliente."');
    history.go(-1);
    location.reload;
    </script>";
}
if($_GET['acao'] == 2){//INATIVAR CLIENTE
    $get_codigo = $_GET['codigo'];
    $get_tipo = $_GET['tipo'];
    $inativar_cliente = func_inativar_cliente($get_codigo,$get_tipo);
    echo "<script language=\"javascript\">
    alert('".$inativar_cliente."');
    history.go(-1);
    location.reload;
    </script>";
}
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
                <h2>Listagem de Clientes</h2>
            </div>
            <!-- END Get Started Title -->
            <?php
            if($total_encontrado == 0){
                echo '<center>Nenhum resultado Encontrado</center>';
            } else {
                echo "<table border=\"1\" width=\"100%\" class=\"table-bordered table-striped table-condensed table-hover\">
                <tr>
                    <td align=\"center\"><b><font size=\"+0.5\">Ações</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Cód. Cliente</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Razão Social</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">Nome Fantasia</b></font></td>
                    <td align=\"center\"><b><font size=\"+0.5\">CNPJ</b></font></td>
               </tr>";
               while($dados_cliente_fornecedor = $sql_cliente_fornecedor->fetch(PDO::FETCH_ASSOC)){
                   $cliente_codigo = $dados_cliente_fornecedor['codigo'];
                   $cliente_razao_social = $dados_cliente_fornecedor['razao_social'];
                   $cliente_nome_fantasia = $dados_cliente_fornecedor['nome_fantasia'];
                   $cliente_cnpj = $dados_cliente_fornecedor['cnpj'];
                   $cliente_tipo = $dados_cliente_fornecedor['tipo_cliente'];
                   if($cliente_tipo != '0'){
                       $icone_inativar = "<i data-toggle=\"tooltip\" data-placement=\"top\" title=\"Inativar Cliente/Fornecedor\" style=\"color: green;\" class=\"fa fa-check\"></i>";
                       $link_inativar = "0";
                   } else {
                       $icone_inativar = "<i data-toggle=\"tooltip\" data-placement=\"top\" title=\"Ativar Cliente/Fornecedor\" style=\"color: red;\" class=\"fa fa-times\"></i>";
                       $link_inativar = "1";
                   }
                   echo "
                <tr>
                    <td align=\"center\">
                    <a data-toggle=\"modal\" href=\"inativar_cliente.php?codigo=$cliente_codigo&tipo=$link_inativar\" data-target=\"#modal-excluir\" data-placement=\"top\" title=\"Inativar/Ativar Cliente/Fornecedor\">$icone_inativar</a>
                    <a data-toggle=\"modal\" href=\"editar_cliente.php?codigo=$cliente_codigo\" data-target=\"#modal-editar\" data-placement=\"top\" title=\"Editar Cliente/Fornecedor\"><i data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar Cliente/Fornecedor\" style=\"color: cornflowerblue;\" class=\"fa fa-pencil-square-o\"></i></a> </b></td>

                    <td align=\"center\"><b>$cliente_codigo</b></td>
                    <td align=\"left\">$cliente_nome_fantasia</td>
                    <td align=\"left\">$cliente_razao_social</td>
                    <td align=\"center\"><b>$cliente_cnpj</b></td>
               </tr>";

               }
                echo "</table>";
            }
            ?>

            <div id="modal-excluir" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title"><strong>Excluir Cliente / Fornecedor</strong></h3>
                        </div>
                        <div class="modal-body">
                            Deseja realmente excluir o cliente abaixo?<br>
                            <div class="modal-excluir-cliente"></div>
                            <br><br>
                            <div align="center" style="color: #fffacd; background: #ff0000;">Atenção: a exclusão não poderá ser desfeita e todos os dados do cliente serão apagados.</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-effect-ripple btn-primary">Confirmar</button>
                            <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

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