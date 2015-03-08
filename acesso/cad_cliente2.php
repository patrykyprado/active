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
            <form action="#" method="POST">
                <table width="100%">
                    <tr>
                        <td width="100px"><b>Razão Social: </b></td>
                        <td colspan="3"><input type="text" style="width: 80%" name="razao_social" id="razao_social"/> </td>
                    </tr>
                    <tr>
                        <td><b>Nome Fantasia: </b></td>
                        <td colspan="3"> <input type="text" style="width: 80%" name="nome_fantasia" id="nome_fantasia"/></td>
                    </tr>
                    <tr>
                        <td><b>CNPJ: </b></td>
                        <td colspan="3"> <input type="text" style="width: 150px" name="cnpj" id="cnpj"/></td>
                    </tr>
                    <tr>
                        <td><b>Endereço: </b></td>
                        <td colspan="3"> <input type="text" style="width: 60%" name="endereco" id="endereco"/> <b>Nº:</b> <input type="text" style="width: 10%" name="numero" id="numero"/></td>
                    </tr>
                    <tr>
                        <td><b>Estado: </b></td>
                        <td colspan="3"><select name="uf" id="uf">
                                <option value="ES">ES</option>
                                <?php
                                $sql_estados = func_drop_uf('ES');
                                while($dados_estados = $sql_estados ->fetch(PDO::FETCH_ASSOC)){
                                    $estado_sigla = $dados_estados['uf'];
                                    echo "<option value=\"$estado_sigla\">$estado_sigla</option>";
                                }

                                ?>
                            </select>
                            <B>Cidade: </B>
                            <select name="cidade" id="cidade">
                                <?php
                                $sql_cidade = func_drop_cidade('ES');
                                while($dados_cidade = $sql_cidade ->fetch(PDO::FETCH_ASSOC)){
                                    $cidade_nome = $dados_cidade['cidade'];
                                    echo "<option value=\"$cidade_nome\">$cidade_nome</option>";
                                }

                                ?>
                            </select>
                            <b>Bairro: </b><input type="text" style="width: 300px;" name="bairro" id="bairro"/>
                            <b>CEP: </b><input type="text" style="width: 100px;" name="cep" id="cep"/></td>
                    </tr>
                    <tr>
                        <td><b>Site: </b></td>
                        <td colspan="3"> <input type="text" style="width: 80%" name="site" id="site"/></td>
                    </tr>
                </table>
                <br><br>
                <div class="block-title">
                    <h2>Dados de Contato</h2>
                </div>
                    <table width="100%">
                        <tr>
                            <td width="100px"><b>Contatos: </b></td>
                            <td colspan="3"><input type="text" style="width: 80%" name="contatos" id="contatos"/> </td>
                        </tr>
                        <tr>
                            <td><b>E-mail </b></td>
                            <td colspan="3"> <input type="text" style="width: 200px" name="e-mail" id="e-mail"/>
                                <b>Telefone:</b> <input type="text" style="width: 200px" name="telefone" id="telefone"/>
                                <b>Celular:</b> <input type="text" style="width: 200px" name="celular" id="celular"/>
                            </td>
                        </tr>
                        <tr>
                             <td colspan="4"><b>Observações:</b></td>
                        </tr>
                        <tr>
                            <td colspan="4"><textarea style="width: 100%" name="observacoes" id="observacoes" class="ckeditor"></textarea> </td>
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
