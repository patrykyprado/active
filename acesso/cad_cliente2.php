<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php'?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $cad_cliente_array = array();
    $cad_cliente_array['razao_social'] = $_POST['razao_social'];
    $cad_cliente_array['nome_fantasia'] = $_POST['nome_fantasia'];
    $cad_cliente_array['cnpj'] = $_POST['cnpj'];
    $cad_cliente_array['endereco'] = $_POST['endereco'];
    $cad_cliente_array['numero'] = $_POST['numero'];
    $cad_cliente_array['uf'] = $_POST['uf'];
    $cad_cliente_array['cidade'] = $_POST['cidade'];
    $cad_cliente_array['bairro'] = $_POST['bairro'];
    $cad_cliente_array['cep'] = $_POST['cep'];
    $cad_cliente_array['site'] = $_POST['site'];
    $cad_cliente_array['contatos'] = $_POST['contatos'];
    $cad_cliente_array['email'] = $_POST['email'];
    $cad_cliente_array['telefone'] = $_POST['telefone'];
    $cad_cliente_array['celular'] = $_POST['celular'];
    $cad_cliente_array['observacoes'] = $_POST['observacoes'];
    $cad_cliente_array['datahora'] = date("Y-m-d H:i:s");
    $cad_cliente_array['tipo_cliente'] =  0;

    $inserir_cliente = func_cad_cliente($cad_cliente_array);

    echo "<script language=\"javascript\">
    alert('".$inserir_cliente."');
    </script>";

}

?>

    <!-- Page content -->
    <div id=> "page-content">
        <!-- Blank Header -->
        <div class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-section">
                        <h1>Cadastro de Cliente / Fornecedor</h1>
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
                <h2>Dados do Cliente</h2>
            </div>
            <!-- END Get Started Title -->

            <!-- Get Started Content -->
            
            <!-- END Get Started Content -->
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>
<script type="text/javascript">
    google.load('jquery', '1.3');
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#cnpj").mask("99.999.999/9999-99");});

    $(function(){
        $('#uf').change(function(){
            if( $(this).val() ) {
                $('#cidade').hide();
                $('.carregando_cidades').show();
                $.getJSON('cidade.ajax.php?search=',{uf: $(this).val(), ajax: 'true'}, function(j){
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].cidade + '">' + j[i].cidade + '</option>';
                    }
                    $('#cidade').html(options).show();
                    $('.carregando_cidades').hide();
                });
            } else {
                $('#cidade').html('<option value="">? Cidade ?</option>');
            }
        });
</script>
