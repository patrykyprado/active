<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$get_codigo = $_GET['id'];

$sql_exercicio = func_dados_exercicio($get_codigo);
$dadosExercicio = $sql_exercicio->fetch(PDO::FETCH_ASSOC);

?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title"><strong>Descrição do Exercício - <?= utf8_encode($dadosExercicio['exercicio']);?></strong></h3>
        </div>
        <div class="modal-body">
            <?= utf8_encode($dadosExercicio['descricao']);?>
    </div>
</div>

<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#cnpj").mask("99.999.999/9999-99");});
</script>

