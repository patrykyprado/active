<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$semMenu = 1;
include '../inc/config.php';
include '../inc/restricao.php';
$sql_contas = func_drop_contas($usuario_empresa, $usuario_filial);
$sql_titulo = func_dados_boleto_id($_GET['id']);
$dados_titulo = $sql_titulo->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sql_atualizar = func_atualizar_titulo($_POST);
    if($sql_atualizar->rowCount() >= 1){
        echo "<script language='javascript'>
alert('Título alterado com sucesso.') ;
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
                        <h1>Edição de Título</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Blank Header -->

        <!-- Get Started Block -->
        <div class="block full">
            <!-- Get Started Title -->
            <div class="block-title">
                <h2>Dados do Título - <?= $dados_titulo['id_titulo'];?></h2>
            </div>
            <!-- END Get Started Title -->

            <!-- Get Started Content -->
            <form action="#" method="POST">
                <input name="id_titulo" type="hidden" value="<?= $dados_titulo['id_titulo'];?>"/>
                <table width="100%">
                    <tr>
                        <td width="15%"><b>Cliente / Fornecedor: </b> </td>
                        <td colspan="3">
                            <input type="text" name="cliente_fornecedor_nome" id="cliente_fornecedor_nome" readonly="readonly" value="<?= $dados_titulo['codigo'].' - '.utf8_encode($dados_titulo['razao_social']);?>" style="width: 70%; background-color: #CBE8F6; cursor: no-drop"/>
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Data de Emissão:</b></td>
                        <td width="55%"><input name="emissao" value="<?= format_data($dados_titulo['emissao']);?>" type="text" class="default-date-picker"/>
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Vencimento: </b></td>
                        <td width="55%"><input name="vencimento" required="required" type="text" value="<?= format_data($dados_titulo['vencimento']);?>" class="default-date-picker"/>
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Valor: </b></td>
                        <td width="55%"><input name="valor" required="required" value="<?= format_valor($dados_titulo['valor']);?>" type="text" />
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Desconto (%): </b></td>
                        <td width="55%"><input name="desconto_porcentagem" value="<?= format_valor($dados_titulo['desconto_porcentagem']);?>" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td><b>Desconto (R$): </b></td>
                        <td width="55%"><input name="desconto_real" value="<?= format_valor($dados_titulo['desconto_real']);?>"  type="text" />
                        </td>
                    </tr>
                </table>
                <br><br>
                <div class="block-title">
                    <h2><center>Descrição do Título</center></h2>
                </div>
                <textarea style="width: 100%; height: 80px" name="descricao" id="descricao"><?= utf8_encode($dados_titulo['descricao']);?></textarea>
                <br><br>
                <div class="block-title" style="background-color: springgreen">
                    <h2><center>Dados da Baixa</center></h2>
                </div>
                <table width="100%">
                    <tr>
                        <td width="15%"><b>Conta de Baixa: </b> </td>
                        <td colspan="3">
                            <select name="conta" id="conta" style="width: 70%;background-color: darkseagreen;'">
                                <?php
                                while($dados_conta = $sql_contas->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option <?= selected($dados_conta['id'], $dados_titulo['conta_id']);?> value="<?= $dados_conta['id'];?>"><?= utf8_encode($dados_conta['nome_conta']);?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Data de Efetivação: </b></td>
                        <td width="55%"><input name="data_pagto" style="background-color: darkseagreen;" type="text" value="<?= format_data($dados_titulo['data_pagto']);?>" class="default-date-picker"/>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Valor Efetivado: </b></td>
                        <td width="55%"><input name="valor_pagto" style="background-color: darkseagreen;" value="<?= format_valor($dados_titulo['valor_pagto']);?>" type="text" />
                        </td>
                    </tr>
                </table>
                <br>
                <center><button class="btn btn-danger">Salvar Título</button> </center>
            </form>
            <!-- END Get Started Content -->
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>