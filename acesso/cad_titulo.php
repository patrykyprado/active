<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php';
var_dump($sql_cc1);
return;
$sql_contas = func_drop_contas($usuario_empresa, $usuario_filial);
$sql_cc1 = func_drop_cc1($usuario_empresa);

$sql_cc2 = func_drop_cc2($usuario_empresa, $usuario_filial);


$tipoExibir = ' - A Pagar';
if($_GET['tipo'] == 2){
    $tipoExibir = ' - A Receber';
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
                        <h1>Cadastro de Título <?= $tipoExibir;?></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Blank Header -->

        <!-- Get Started Block -->
        <div class="block full">
            <!-- Get Started Title -->
            <div class="block-title">
                <h2>Dados do Título</h2>
            </div>
            <!-- END Get Started Title -->

            <!-- Get Started Content -->
            <form action="#" method="POST">
                <table width="100%">
                    <tr>
                        <td width="15%"><b>Conta: <font color="red">*</font> </b> </td>
                        <td colspan="3">
                            <select name="conta" id="conta" style="width: 70%;">
                                <?php
                                while($dados_conta = $sql_contas->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option value="<?= $dados_conta['id'];?>"><?= utf8_encode($dados_conta['nome_conta']);?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </td>
                    </tr>
                    <tr>
                        <td><b>Data de Emissão: <font color="red">*</font></b></td>
                        <td width="55%"><input name="emissao" value="<?= date('d/m/Y');?>" type="text" class="default-date-picker"/></td>
                        <td colspan="2">
                            <select name="cc1" style="width: 200px">
                                <?php
                                while($dados_cc1 = $sql_cc1->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option value="<?= $dados_cc1['id'];?>"><?= utf8_encode($dados_cc1['nome']);?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <b><font color="red">*</font></b>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Vencimento: <font color="red">*</font></b></td>
                        <td width="55%"><input name="vencimento"  type="text" class="default-date-picker"/></td>
                        <td colspan="2">
                            <select name="cc2" required="required" style="width: 200px">
                                <option selected="selected" value="">Selecione a Filial</option>
                                <?php
                                while($dados_cc2 = $sql_cc2->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option value="<?= $dados_cc2['id'];?>"><?= utf8_encode($dados_cc2['nome_filial']);?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <b><font color="red">*</font></b>
                        </td>
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