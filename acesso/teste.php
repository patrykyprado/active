<form action="#" method="POST">
    <input type="hidden" name="tipo_documento" value="1" />
    <table width="100%">
        <tr>
            <td width="150px"><b>Nome Completo: </b></td>
            <td colspan="3"><input type="text" style="width: 80%" name="razao_social" id="razao_social"/> </td>
        </tr>
        <tr>
            <td width="150px"><b>Data de Nascimento: </b></td>
            <td colspan="3"><input type="text" style="width: 100px" name="nascimento" id="nascimento"/> </td>
        </tr>
        <tr>
            <td><b>CPF: </b></td>
            <td colspan="3"> <input type="text" style="width: 150px" name="cnpj" id="cpf"/>
                <b>RG: </b> <input type="text" style="width: 150px" name="rg" id="rg"/> </td>
        </tr>
        <tr>
            <td><b>Estado: </b></td>
            <td colspan="3">#select2Uf
                <B>Cidade: </B>
                #select2Cidade
        </tr>
        <tr>
            <td><b>Endereço: </b></td>
            <td colspan="3"> <input type="text" style="width: 60%" name="endereco" id="endereco"/> <b>Nº:</b> <input type="text" style="width: 10%" name="numero" id="numero"/></td>
        </tr>
        <tr>
            <td><b>Bairro</b></td>
            <td colspan="3"><input type="text" style="width: 300px;" name="bairro" id="bairro"/>
                <b>CEP: </b><input type="text" style="width: 100px;" name="cep" id="cep"/></td>
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
                #selectConvenio
            </td>
        </tr>
        <tr>
            <td width="100px"><b>Carteirinha: </b></td>
            <td colspan="3"><input type="text" style="width: 150px" name="convenio_n" id="convenio_n"/>
                <b>Validade</b>  <input type="text" style="width: 150px" class="default-date-picker" name="convenio_validade" id="convenio_validade"/>
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