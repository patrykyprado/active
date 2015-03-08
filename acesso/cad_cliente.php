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
    $cad_cliente_array['cnpj'] = $_POST['documento'];
    $cad_cliente_array['endereco'] = $_POST['endereco'];
    $cad_cliente_array['insc_municipal'] = $_POST['insc_municipal'];
    $cad_cliente_array['insc_estadual'] = $_POST['insc_estadual'];
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
    $cad_cliente_array['status_cliente'] =  1;
    $cad_cliente_array['tipo_documento'] =  $_POST['tipo_documento'];
    if(2 == $cad_cliente_array['tipo_documento'])
        $cad_cliente_array['razao_social'] = $cad_cliente_array['nome_fantasia'];
    //envia dados para o sql.php para inserir em banco de dados
    $inserir_cliente = func_cad_cliente($cad_cliente_array);
    echo $inserir_cliente;

}

?>

<!-- Page content -->
<div id= "page-content">
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

    <!-- Block Tabs -->
    <div class="block full">
        <!-- Block Tabs Title -->
        <div class="block-title">
            <ul class="nav nav-tabs" data-toggle="tabs">
                <?php
                $x_tipo = 1;
                $sql_tipos_cliente = func_tipos_clientes();
                $array_tipo_cliente = array();
                $x_array_tipo = 1;
                while($dados_tipos = $sql_tipos_cliente->fetch(PDO::FETCH_ASSOC)){
                    $tipo_cliente = $dados_tipos['tipo_cliente'];
                    $tipo_id_documento = $dados_tipos['id_tipo_documento'];
                    $tipo_formulario = $dados_tipos['formulario'];
                    $tipo_tab = $dados_tipos['div_tab'];
                    $ativo_tab = '';
                    if($x_tipo == 1){
                        $ativo_tab = 'active';
                        $x_tipo = 0;
                    }
                    $array_tipo_cliente[$x_array_tipo]['nome_tab'] = $tipo_tab;
                    $array_tipo_cliente[$x_array_tipo]['ativo_tab'] = $ativo_tab;
                    $array_tipo_cliente[$x_array_tipo]['formulario'] = $tipo_formulario;
                    $x_array_tipo += 1;
                    echo "<li class=\"$ativo_tab\"><a href=\"$tipo_tab\">$tipo_cliente</a></li>";
                }
                ?>
            </ul>
        </div>
        <!-- END Block Tabs Title -->

        <!-- Tabs Content -->
        <div class="tab-content">
            <?php
            foreach($array_tipo_cliente as $dados_tab_tipo){
               $tab_nome = str_replace('#','',$dados_tab_tipo['nome_tab']);
               $tab_ativo = $dados_tab_tipo['ativo_tab'];
               $tab_formulario = $dados_tab_tipo['formulario'];
               echo " <div class=\"tab-pane $tab_ativo\" id=\"$tab_nome\">$tab_formulario</div>";
            }
            ?>
        </div>
        <!-- END Tabs Content -->
    </div>
    <!-- END Block Tabs -->
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
        $("#cnpj").mask("99.999.999/9999-99");
        $("#cpf").mask("999.999.999-99");

    });

</script>


