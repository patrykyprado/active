<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$get_codigo = $_GET['codigo'];
$get_tipo = $_GET['tipo'];
if($get_tipo == "1"){
    $get_texto = "<b style='color: green'>ATIVAR</b>";
} else {
    $get_texto = "<b style='color: #ff0000'>INATIVAR</b>";
}

$sql_edicao_cliente_fornecedor = func_editar_cliente_fornecedor($get_codigo);
$dados_cliente = $sql_edicao_cliente_fornecedor->fetch(PDO::FETCH_ASSOC);

?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title"><strong>Inativar Cliente / Fornecedor</strong></h3>
        </div>
        <div class="modal-body">
            <form action="listar_clientes.php" method="GET">
                <input type="hidden" name="acao" value="2"/>
                <input type="hidden" name="codigo" value="<?php echo $get_codigo;?>"/>
                <input type="hidden" name="tipo" value="<?php echo $get_tipo;?>"/>
                Deseja realmente <?php echo $get_texto;?> o cliente abaixo?<br><br>
                <div style="background-color: #0088a1; color: #fffacd" align="center">
                    Razão Social: <?php echo $dados_cliente['razao_social'];?><br>
                    Nome Fantasia: <?php echo $dados_cliente['nome_fantasia'];?></div>
                <table width="100%">
                    <tr>
                        <td colspan="4"><br><br>
                            <center><input type="submit" class="btn btn-effect-ripple btn-primary" value="Confirmar"/> <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Cancelar</button></center></td>
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

