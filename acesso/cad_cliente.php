<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php'?>
<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php';


$sql_convenios = func_drop_convenios();
$dropConvenio = '<select name="convenio_id" id="convenio_id" required="required" width="100px">
<option value="">Selecione o Convênio</option>
';
while($dados_convenios = $sql_convenios->fetch(PDO::FETCH_ASSOC)){
 $dropConvenio .= '<option value="'.$dados_convenios['id'].'">'.$dados_convenios['convenio'].'</option>';
}
$dropConvenio .= '</select>';


$sql_uf = func_drop_uf('Espirito Santo');
$dropUf = '<select name="uf" id="uf" required="required" width="100px">
<option value="">Selecione o Estado</option>
';
while($dados_uf = $sql_uf->fetch(PDO::FETCH_ASSOC)){
    $dropUf .= '<option value="'.$dados_uf['uf'].'">'.$dados_uf['uf'].'</option>';
}
$dropUf .= '</select>';

$sql_uf2 = func_drop_uf('Espirito Santo');
$dropUf2 = '<select name="uf" id="uf2" required="required" width="100px">
<option value="">Selecione o Estado</option>
';
while($dados_uf2 = $sql_uf2->fetch(PDO::FETCH_ASSOC)){
    $dropUf2 .= '<option value="'.$dados_uf2['uf'].'">'.$dados_uf2['uf'].'</option>';
}
$dropUf2 .= '</select>';

$sql_cidade = func_drop_cidade('Espirito Santo');
$dropCidade = '<select name="cidade" id="cidade" required="required" width="140px">
<option value="">Selecione a Cidade</option>
';
while($dados_cidade = $sql_cidade->fetch(PDO::FETCH_ASSOC)){
    $dropCidade .= '<option value="'.$dados_cidade['cidade'].'">'.$dados_cidade['cidade'].'</option>';
}
$dropCidade .= '</select>';

$sql_cidade2 = func_drop_cidade('Espirito Santo');
$dropCidade2 = '<select name="cidade" id="cidade2" required="required" width="140px">
<option value="">Selecione a Cidade</option>
';
while($dados_cidade2 = $sql_cidade2->fetch(PDO::FETCH_ASSOC)){
    $dropCidade2 .= '<option value="'.$dados_cidade2['cidade'].'">'.$dados_cidade2['cidade'].'</option>';
}
$dropCidade2 .= '</select>';


$trocarEsse = array('#selectConvenio', '#selectUf', '#selectCidade', '#select2Uf', '#select2Cidade');
$trocarPorEsse = array(utf8_decode($dropConvenio), $dropUf, $dropCidade, $dropUf2, $dropCidade2);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $cad_cliente_array = array();
    $cad_cliente_array['razao_social'] = utf8_decode($_POST['razao_social']);
    $cad_cliente_array['nome_fantasia'] = utf8_decode($_POST['nome_fantasia']);
    $cad_cliente_array['cnpj'] = utf8_decode($_POST['cnpj']);
    $cad_cliente_array['rg'] = utf8_decode($_POST['rg']);
    $cad_cliente_array['endereco'] = utf8_decode($_POST['endereco']);
    $cad_cliente_array['insc_municipal'] = utf8_decode($_POST['insc_municipal']);
    $cad_cliente_array['insc_estadual'] = utf8_decode($_POST['insc_estadual']);
    $cad_cliente_array['endereco'] = utf8_decode($_POST['endereco']);
    $cad_cliente_array['numero'] = utf8_decode($_POST['numero']);
    $cad_cliente_array['uf'] = utf8_decode($_POST['uf']);
    $cad_cliente_array['cidade'] = utf8_decode($_POST['cidade']);
    $cad_cliente_array['bairro'] = utf8_decode($_POST['bairro']);
    $cad_cliente_array['cep'] = utf8_decode($_POST['cep']);
    $cad_cliente_array['site'] = utf8_decode($_POST['site']);
    $cad_cliente_array['contatos'] = utf8_decode($_POST['contatos']);
    $cad_cliente_array['email'] = utf8_decode($_POST['email']);
    $cad_cliente_array['telefone'] = utf8_decode($_POST['telefone']);
    $cad_cliente_array['celular'] = utf8_decode($_POST['celular']);
    $cad_cliente_array['observacoes'] = utf8_decode($_POST['observacoes']);
    $cad_cliente_array['convenio_n'] = utf8_decode($_POST['convenio_n']);
    $cad_cliente_array['convenio_validade'] = utf8_decode($_POST['convenio_validade']);
    $cad_cliente_array['convenio_id'] = utf8_decode($_POST['convenio_id']);
    $cad_cliente_array['nascimento'] = utf8_decode($_POST['nascimento']);
    $cad_cliente_array['datahora'] = date("Y-m-d H:i:s");
    $cad_cliente_array['status_cliente'] =  1;
    $cad_cliente_array['tipo_documento'] =  utf8_decode($_POST['tipo_documento']);

    $inserir_cliente = func_cad_cliente($cad_cliente_array);
    if($inserir_cliente->rowCount() == 0){
        echo "<script language=\"javascript\">
    alert('Não foi possível inserir o cliente!');
    location.href='cad_cliente.php';
    </script>";
    } else {
        echo "<script language=\"javascript\">
    alert('Cliente cadastrado com sucesso!');
    location.href='listar_clientes.php';
    </script>";
    }


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
                        <a href="listar_clientes.php"><button class="btn btn-info">Visualizar Clientes / Fornecedores</button></a>
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
               echo " <div class=\"tab-pane $tab_ativo\" id=\"$tab_nome\">".utf8_encode(str_replace($trocarEsse, $trocarPorEsse, $tab_formulario))."</div>";
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
    $(function(){
        $('#uf').change(function(){
            if( $(this).val() ) {
                $('#cidade').hide();
                $.getJSON('../ajax/cidade.php?search=',{uf: $(this).val(), ajax: 'true'}, function(j){
                    var options = '<option selected value="selecione"> Escolha a Cidade </option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].cidade + '">'+ j[i].cidade + '</option>';
                    }
                    $('#cidade').html(options).show();
                    $('.carregando').hide();

                });
            } else {
                $('#cidade').html('<option value=""> Escolha a Cidade </option>');
            }
        });
    });
    $(function(){
        $('#uf2').change(function(){
            if( $(this).val() ) {
                $('#cidade2').hide();
                $.getJSON('../ajax/cidade.php?search=',{uf: $(this).val(), ajax: 'true'}, function(j){
                    var options = '<option selected value="selecione"> Escolha a Cidade </option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].cidade + '">'+ j[i].cidade + '</option>';
                    }
                    $('#cidade2').html(options).show();
                    $('.carregando').hide();

                });
            } else {
                $('#cidade2').html('<option value=""> Escolha a Cidade </option>');
            }
        });
    });
</script>

