<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$get_codigo = $_GET['codigo'];

$sql_edicao_cliente_fornecedor = func_editar_cliente_fornecedor($get_codigo);
$dados_cliente = $sql_edicao_cliente_fornecedor->fetch(PDO::FETCH_ASSOC);

?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title"><strong>Editar Cliente / Fornecedor</strong></h3>
        </div>
        <div class="modal-body">
        <form action="listar_clientes.php" method="GET">
            <input type="hidden" name="acao" value="1"/>
            <input type="hidden" name="codigo" value="<?php echo $get_codigo;?>"/>
            <input type="hidden" name="acao" value="1"/>
            <table width="100%">
                <tr>
                    <td width="100px"><b>Razão Social: </b></td>
                    <td colspan="3"><input type="text" style="width: 80%" name="razao_social" id="razao_social" value="<?php echo $dados_cliente['razao_social'];?>"/> </td>
                </tr>
                <tr>
                    <td><b>Nome Fantasia:</b></td>
                    <td colspan="3"> <input type="text" style="width: 80%" name="nome_fantasia" id="nome_fantasia" value="<?php echo $dados_cliente['nome_fantasia'];?>"/></td>
                </tr>
                <tr>
                    <td><b>CNPJ: </b></td>
                    <td colspan="3"> <input type="text" style="width: 150px" name="cnpj" id="cnpj" value="<?php echo $dados_cliente['cnpj'];?>"/></td>
                </tr>
                <tr>
                    <td><b>Endereço: </b></td>
                    <td colspan="3"> <input type="text" style="width: 60%" name="endereco" id="endereco" value="<?php echo $dados_cliente['endereco'];?>"/> <b>Nº:</b> <input type="text" style="width: 10%" name="numero" id="numero" value="<?php echo $dados_cliente['numero'];?>"/></td>
                </tr>
                <tr>
                    <td><b>Estado: </b></td>
                    <td colspan="3"><select name="uf" id="uf"> 
                            <option value="<?php echo $dados_cliente['uf'];?>"><?php echo $dados_cliente['uf'];?></option>
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
                            <option value="<?php echo $dados_cliente['cidade'];?>"><?php echo $dados_cliente['cidade'];?></option>
                            <?php
                            $sql_cidade = func_drop_cidade('ES');
                            while($dados_cidade = $sql_cidade ->fetch(PDO::FETCH_ASSOC)){
                                $cidade_nome = $dados_cidade['cidade'];
                                echo "<option value=\"$cidade_nome\">$cidade_nome</option>";
                            }

                            ?>
                        </select>
                        <b>Bairro: </b><input type="text" style="width: 300px;" name="bairro" id="bairro" value="<?php echo $dados_cliente['bairro'];?>"/>
                        <b>CEP: </b><input type="text" style="width: 100px;" name="cep" id="cep" value="<?php echo $dados_cliente['cep'];?>"/></td>
                </tr>
                <tr>
                    <td><b>Site: </b></td>
                    <td colspan="3"> <input type="text" style="width: 80%" name="site" id="site" value="<?php echo $dados_cliente['site'];?>"/></td>
                </tr>
            </table>
            <br><br>
            <div class="block-title">
                <h2>Dados de Contato</h2>
            </div>
            <table width="100%">
                <tr>
                    <td width="100px"><b>Contatos: </b></td>
                    <td colspan="3"><input type="text" style="width: 80%" name="contatos" id="contatos" value="<?php echo $dados_cliente['contatos'];?>"/> </td>
                </tr>
                <tr>
                    <td><b>E-mail </b></td>
                    <td colspan="3"> <input type="text" style="width: 200px" name="email" id="email" value="<?php echo $dados_cliente['emails'];?>"/>
                        <b>Telefone:</b> <input type="text" style="width: 200px" name="telefone" id="telefone" value="<?php echo $dados_cliente['telefone'];?>"/>
                        <b>Celular:</b> <input type="text" style="width: 200px" name="celular" id="celular" value="<?php echo $dados_cliente['celular'];?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><b>Observações:</b></td>
                </tr>
                <tr>
                    <td colspan="4"><?php echo $dados_cliente['observacoes'];?><br><Br><br>
                        <center><input type="submit" class="btn btn-effect-ripple btn-primary" value="Salvar Edição"/> <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Cancelar</button></center></td>
                </tr>
            </table>

        </div>

            </form>
    </div>
</div>

<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#cnpj").mask("99.999.999/9999-99");});
</script>

