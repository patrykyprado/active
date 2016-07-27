<?php
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
include '../inc/config.php';
include '../inc/restricao.php';

$sql_contas = func_drop_contas($usuario_empresa, $usuario_filial);
$sql_cc1 = func_drop_cc1($usuario_empresa);
$sql_cc2 = func_drop_cc2($usuario_empresa, $usuario_filial);
$sql_cc3 = func_drop_cc3($_GET['tipo']);


$tipoExibir = ' - A Pagar';
if($_GET['tipo'] == 2){
    $tipoExibir = ' - A Receber';
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $iParcela = 1;
    $vencimento = DateTime::CreateFromFormat('d/m/Y', $_POST['vencimento']);
    while($iParcela <= $_POST['parcelas']) {
        $_POST['parcela'] = $iParcela;
        $_POST['vencimento'] = $vencimento->format('d/m/Y');
        $sql = func_gerar_titulo($_POST);
        $vencimento->modify('+1 Month');
        $iParcela += 1;
    }

    echo "<script language='javascript'>
alert('".$_POST['parcelas']." titulo(s) gerado(s).') ;
location.href='cad_titulo.php?tipo=".$_POST['tipo']."';
</script>";
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
                <input type="hidden" name="tipo" value="<?= $_GET['tipo']?>"/>
                <table width="100%">
                    <tr>
                        <td width="15%"><b>Conta: </b> </td>
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
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><b>Cliente / Fornecedor: </b> </td>
                        <td colspan="3">
                            <input type="text" name="cliente_fornecedor_nome" id="cliente_fornecedor_nome" onclick="javascript:abrir('pesquisar_clientefornecedor.php')" readonly="readonly" style="width: 70%; background-color: #CBE8F6; cursor: zoom-in"/>
                            <input type="hidden" name="cliente_fornecedor" id="cliente_fornecedor" style="width: 70%"/>
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Data de Emissão:</b></td>
                        <td width="55%"><input name="emissao" value="<?= date('d/m/Y');?>" type="text" class="default-date-picker"/>
                            <?= requerido()?>
                        </td>
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
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Vencimento: </b></td>
                        <td width="55%"><input name="vencimento" required="required" type="text" class="default-date-picker"/>
                            <?= requerido()?>
                        </td>
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
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Valor: </b></td>
                        <td width="55%"><input name="valor" required="required" type="text" />
                            <?= requerido()?>
                        </td>
                        <td colspan="2">
                            <select name="cc3" id="cc3" required="required" style="width: 200px">
                                <option selected="selected" value="">Selecione o CC3</option>
                                <?php
                                while($dados_cc3 = $sql_cc3->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option value="<?= $dados_cc3['id'];?>"><?= utf8_encode($dados_cc3['nome_cc3']);?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Desconto (%): </b></td>
                        <td width="55%"><input name="desconto_porcentagem" value="0" type="text" />
                        </td>
                        <td colspan="2">
                            <select name="cc4" id="cc4" required="required" style="width: 200px">
                                <option selected="selected" value="">Selecione o CC4</option>
                            </select>
                            <?= requerido()?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Desconto (R$): </b></td>
                        <td width="55%"><input name="desconto_real" value="0"  type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td><b>Qtd. Parcelas: </b></td>
                        <td width="55%"><input name="parcelas" value="1" required="required" type="number" />
                            <?= requerido()?>
                        </td>
                    </tr>
                </table>
                <br><br>
                <div class="block-title">
                    <h2><center>Descrição do Título</center></h2>
                </div>
                <textarea style="width: 100%; height: 80px" name="descricao" id="descricao"></textarea>

            <br>
                <center><button class="btn btn-info">Gerar Títulos</button> </center>
            </form>
            <!-- END Get Started Content -->
        </div>
        <!-- END Get Started Block -->
    </div>
    <!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>

<?php include '../inc/template_end.php'; ?>

<script language="JavaScript">
    $(function(){
        $('#cc3').change(function(){
            if( $(this).val() ) {
                $('#cc4').hide();
                $.getJSON('../ajax/cc4.php?search=',{cc3: $(this).val(), ajax: 'true'}, function(j){
                    var options = '<option selected value="selecione"> Selecione o CC4 </option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].cc4_id + '">'+ j[i].cc4_nome + '</option>';
                    }
                    $('#cc4').html(options).show();
                    $('.carregando').hide();

                });
            } else {
                $('#cc4').html('<option value=""> Selecione o CC4 </option>');
            }
        });
    });
</script>
