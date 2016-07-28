<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$semMenu = 1;
include '../inc/config.php';
include '../inc/restricao.php';
$sql_cliente = func_dados_cliente($_GET['codigo']);
$dados_cliente = $sql_cliente->fetch(PDO::FETCH_ASSOC);
if (!empty($dados_cliente['nome_fantasia'])) {
    $nomeFantasia = ' (' . utf8_encode($dados_cliente['nome_fantasia']) . ')';
}
$sql_convenios = func_drop_convenios();
$dropConvenio = '<select name="convenio_id" id="convenio_id" required="required" width="100px">
<option value="">Selecione o Convênio</option>
';
while($dados_convenios = $sql_convenios->fetch(PDO::FETCH_ASSOC)){
    $dropConvenio .= '<option '.selected($dados_convenios['id'], $dados_cliente['tipo_convenio']).' value="'.$dados_convenios['id'].'">'.$dados_convenios['convenio'].'</option>';
}
$dropConvenio .= '</select>';


$sql_uf = func_drop_uf(utf8_encode($dados_cliente['uf']));
$dropUf = '<select name="uf" id="uf" required="required" width="100px">
<option value="">Selecione o Estado</option>
';
while($dados_uf = $sql_uf->fetch(PDO::FETCH_ASSOC)){
    $dropUf .= '<option '.selected(($dados_uf['uf']), ($dados_cliente['uf'])).' value="'.$dados_uf['uf'].'">'.$dados_uf['uf'].'</option>';
}
$dropUf .= '</select>';

$sql_uf2 = func_drop_uf(utf8_encode($dados_cliente['uf']));
$dropUf2 = '<select name="uf" id="uf2" required="required" width="100px">
<option value="'.$dados_uf2.'">Selecione o Estado</option>
';
while($dados_uf2 = $sql_uf2->fetch(PDO::FETCH_ASSOC)){

    $selected = '';
    if($dados_uf2['uf'] == $dados_cliente['uf']){
        $selected = 'selected="selected"';
    }
    $dropUf2 .= '<option '.$selected.' value="'.$dados_uf2['uf'].'">'.$dados_uf2['uf'].'</option>';
}
$dropUf2 .= '</select>';

$sql_cidade = func_drop_cidade(($dados_cliente['uf']));
$dropCidade = '<select name="cidade" id="cidade" required="required" width="140px">
<option value="">Selecione a Cidade</option>
';
while($dados_cidade = $sql_cidade->fetch(PDO::FETCH_ASSOC)){
    $dropCidade .= '<option '.selected(utf8_encode($dados_cidade['cidade']), utf8_encode($dados_cliente['cidade'])).' value="'.$dados_cidade['cidade'].'">'.$dados_cidade['cidade'].'</option>';
}
$dropCidade .= '</select>';

$sql_cidade2 = func_drop_cidade(($dados_cliente['uf']));
$dropCidade2 = '<select name="cidade" id="cidade2" required="required" width="140px">
<option value="">Selecione a Cidade</option>
';
while($dados_cidade2 = $sql_cidade2->fetch(PDO::FETCH_ASSOC)){
    $dropCidade2 .= '<option '.selected(utf8_encode($dados_cidade2['cidade']), utf8_encode($dados_cliente['cidade'])).' value="'.$dados_cidade2['cidade'].'">'.$dados_cidade2['cidade'].'</option>';
}
$dropCidade2 .= '</select>';

if($_SERVER['REQUEST_METHOD'] == 'POST'){//acao de edi??o
    $edicao_cliente_array = array();
    $edicao_cliente_array['codigo'] = $_POST['codigo'];
    $edicao_cliente_array['razao_social'] = $_POST['razao_social'];
    $edicao_cliente_array['nome_fantasia'] = $_POST['nome_fantasia'];
    $edicao_cliente_array['cnpj'] = $_POST['cnpj'];
    $edicao_cliente_array['endereco'] = $_POST['endereco'];
    $edicao_cliente_array['numero'] = $_POST['numero'];
    $edicao_cliente_array['uf'] = $_POST['uf'];
    $edicao_cliente_array['cidade'] = $_POST['cidade'];
    $edicao_cliente_array['bairro'] = $_POST['bairro'];
    $edicao_cliente_array['cep'] = $_POST['cep'];
    $edicao_cliente_array['site'] = $_POST['site'];
    $edicao_cliente_array['contatos'] = $_POST['contatos'];
    $edicao_cliente_array['email']= $_POST['email'];
    $edicao_cliente_array['telefone'] = $_POST['telefone'];
    $edicao_cliente_array['celular'] = $_POST['celular'];
    //CONFIRMA A EDI??O
    $editar_cliente = func_edicao_cliente($edicao_cliente_array);
    if($editar_cliente->rowCount() == 1){
        echo "<script language=\"javascript\">
    alert('Dados atualizados com sucesso!');
    window.opener.location.reload();
    window.close();
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
                        <h1>Editar Cliente / Fornecedor</h1><br>
                        <b>Cliente / Fornecedor: </b><?= $dados_cliente['codigo'].' - '.utf8_encode($dados_cliente['razao_social']).$nomeFantasia;?>
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
            <?php
            if($dados_cliente['tipo_documento'] == 1){
                ?>
                <form action="#" method="POST">
                    <input type="hidden" name="tipo_documento" value="1" />
                    <input type="hidden" name="codigo" value="<?= $dados_cliente['codigo'];?>" />
                    <table width="100%">
                        <tr>
                            <td width="150px"><b>Nome Completo: </b></td>
                            <td colspan="3"><input type="text" style="width: 80%" value="<?= utf8_encode($dados_cliente['razao_social']);?>" name="razao_social" id="razao_social"/> </td>
                        </tr>
                        <tr>
                            <td width="150px"><b>Data de Nascimento: </b></td>
                            <td colspan="3"><input type="text" style="width: 100px" name="nascimento" value="<?= utf8_encode($dados_cliente['nascimento']);?>" class="default-date-picker" id="nascimento"/> </td>
                        </tr>
                        <tr>
                            <td><b>CPF: </b></td>
                            <td colspan="3"> <input type="text" value="<?= utf8_encode($dados_cliente['documento']);?>" style="width: 150px" name="cnpj" id="cpf"/>
                                <b>RG: </b> <input type="text" value="<?= utf8_encode($dados_cliente['rg']);?>" style="width: 150px" name="rg" id="rg"/> </td>
                        </tr>
                        <tr>
                            <td><b>Estado: </b></td>
                            <td colspan="3"><?= utf8_encode($dropUf2);?>
                                <B>Cidade: </B>
                                <?= utf8_encode($dropCidade2);?>
                        </tr>
                        <tr>
                            <td><b>Endereço: </b></td>
                            <td colspan="3"> <input type="text" style="width: 60%" name="endereco" value="<?= utf8_encode($dados_cliente['endereco']);?>" id="endereco"/> <b>Nº:</b> <input type="text" style="width: 10%" value="<?= utf8_encode($dados_cliente['numero']);?>" name="numero" id="numero"/></td>
                        </tr>
                        <tr>
                            <td><b>Bairro</b></td>
                            <td colspan="3"><input type="text" style="width: 300px;" value="<?= utf8_encode($dados_cliente['bairro']);?>" name="bairro" id="bairro"/>
                                <b>CEP: </b><input type="text" style="width: 100px;" value="<?= utf8_encode($dados_cliente['cep']);?>" name="cep" id="cep"/></td>
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <div class="block-title">
                        <h2>Dados de Convênio</h2>
                    </div>
                    <table width="100%">
                        <tr>
                            <td width="100px"><b>Convênio: </b></td>
                            <td colspan="3">
                                <?= $dropConvenio;?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px"><b>Carteirinha: </b></td>
                            <td colspan="3"><input type="text" style="width: 150px" name="convenio_n" value="<?= utf8_encode($dados_cliente['convenio']);?>" id="convenio_n"/>
                                <b>Validade</b>  <input type="text" style="width: 150px" class="default-date-picker" value="<?= utf8_encode($dados_cliente['convenio_validade']);?>" name="convenio_validade" id="convenio_validade"/>
                            </td>
                        </tr>

                    </table>
                    <br><br><br>
                    <div class="block-title">
                        <h2>Dados de Contato</h2>
                    </div>
                    <table width="100%">
                        <tr>
                            <td width="100px"><b>Contatos: </b></td>
                            <td colspan="3"><input type="text" style="width: 80%" name="contatos" value="<?= utf8_encode($dados_cliente['contatos']);?>" id="contatos"/> </td>
                        </tr>
                        <tr>
                            <td><b>E-mail </b></td>
                            <td colspan="3"> <input type="text" style="width: 200px" name="e-mail" id="e-mail" value="<?= utf8_encode($dados_cliente['emails']);?>"/>
                                <b>Telefone:</b> <input type="text" style="width: 200px" name="telefone" id="telefone" value="<?= utf8_encode($dados_cliente['telefone']);?>"/>
                                <b>Celular:</b> <input type="text" style="width: 200px" name="celular" id="celular" value="<?= utf8_encode($dados_cliente['celular']);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Observações:</b></td>
                        </tr>
                        <tr>
                            <td colspan="4"><textarea style="width: 100%" name="observacoes" id="observacoes" class="ckeditor"><?= utf8_encode($dados_cliente['observacoes']);?></textarea> </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center"><br><br><button type="submit" class="btn btn-effect-ripple btn-primary">Salvar</button></td>
                        </tr>
                    </table>
                </form>
                <?php
            } else {
                ?>
                <form action="#" method="POST">
                    <input type="hidden" name="tipo_documento" value="2" />
                    <input type="hidden" name="codigo" value="<?= $dados_cliente['codigo'];?>" />
                    <table width="100%">
                        <tr>
                            <td width="100px"><b>Razão Social: </b></td>
                            <td colspan="3"><input type="text" style="width: 80%" value="<?= utf8_encode($dados_cliente['razao_social']);?>" name="razao_social" id="razao_social"/> </td>
                        </tr>
                        <tr>
                            <td><b>Nome Fantasia: </b></td>
                            <td colspan="3"> <input type="text" style="width: 80%" value="<?= utf8_encode($dados_cliente['nome_fantasia']);?>" name="nome_fantasia" id="nome_fantasia"/></td>
                        </tr>
                        <tr>
                            <td><b>CNPJ: </b></td>
                            <td colspan="3"> <input type="text" style="width: 150px" value="<?= utf8_encode($dados_cliente['documento']);?>" name="cnpj" id="cnpj"/></td>
                        </tr>
                        <tr>
                            <td><b>Estado: </b></td>
                            <td colspan="3"><?= utf8_encode($dropUf);?>
                                <B>Cidade: </B>
                                <?= utf8_encode($dropCidade);?>
                        </tr>
                        <tr>
                            <td><b>Endereço: </b></td>
                            <td colspan="3"> <input type="text" style="width: 60%" value="<?= utf8_encode($dados_cliente['endereco']);?>" name="endereco" id="endereco"/> <b>Nº:</b> <input type="text" style="width: 10%" name="numero" value="<?= utf8_encode($dados_cliente['numero']);?>" id="numero"/></td>
                        </tr>
                        <tr>
                            <td><b>Bairro</b></td>
                            <td colspan="3"><input type="text" style="width: 300px;" value="<?= utf8_encode($dados_cliente['bairro']);?>" name="bairro" id="bairro"/>
                                <b>CEP: </b><input type="text" style="width: 100px;" value="<?= utf8_encode($dados_cliente['cep']);?>" name="cep" id="cep"/></td>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Site: </b></td>
                            <td colspan="3"> <input type="text" style="width: 80%" name="site" value="<?= utf8_encode($dados_cliente['site']);?>" id="site"/></td>
                        </tr>
                    </table>
                    <br><br>
                    <div class="block-title">
                        <h2>Dados de Convênio</h2>
                    </div>
                    <table width="100%">
                        <tr>
                            <td width="100px"><b>Convênio: </b></td>
                            <td colspan="3">
                                <?= $dropConvenio;?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px"><b>Carteirinha: </b></td>
                            <td colspan="3"><input type="text" style="width: 150px" value="<?= utf8_encode($dados_cliente['convenio']);?>" name="convenio_n" id="convenio_n"/>
                                <b>Validade</b>  <input type="text" style="width: 150px" value="<?= utf8_encode($dados_cliente['convenio_validade']);?>" class="default-date-picker" name="convenio_validade" id="convenio_validade"/>
                            </td>
                        </tr>

                    </table>
                    <br><br><br>
                    <div class="block-title">
                        <h2>Dados de Contato</h2>
                    </div>
                    <table width="100%">
                        <tr>
                            <td width="100px"><b>Contatos: </b></td>
                            <td colspan="3"><input type="text" style="width: 80%" value="<?= utf8_encode($dados_cliente['contatos']);?>" name="contatos" id="contatos"/> </td>
                        </tr>
                        <tr>
                            <td><b>E-mail </b></td>
                            <td colspan="3"> <input type="text" style="width: 200px" value="<?= utf8_encode($dados_cliente['emails']);?>" name="e-mail" id="e-mail"/>
                                <b>Telefone:</b> <input type="text" style="width: 200px" name="telefone" value="<?= utf8_encode($dados_cliente['telefone']);?>" id="telefone"/>
                                <b>Celular:</b> <input type="text" style="width: 200px" name="celular" value="<?= utf8_encode($dados_cliente['celular']);?>" id="celular"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Observações:</b></td>
                        </tr>
                        <tr>
                            <td colspan="4"><textarea style="width: 100%" name="observacoes" id="observacoes" class="ckeditor"><?= utf8_encode($dados_cliente['observacoes']);?></textarea> </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center"><br><br><button type="submit" class="btn btn-effect-ripple btn-primary">Salvar</button></td>
                        </tr>
                    </table>
                </form>
                <?php
            }
            ?>
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>