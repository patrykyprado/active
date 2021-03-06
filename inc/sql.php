<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 27/01/15
 * Time: 09:26
 */


function func_config_app()
{
    global $conn;
    $sql_config = "SELECT * FROM config_app";
    //PEGA OS DADOS DA APLICAÇÃO
    $sql_config_app = $conn->prepare($sql_config);
    $sql_config_app->execute();
    return $sql_config_app;
}

function func_acessar_usuario($usuario, $senha)
{
    global $conn;
    $sql = "SELECT id_usuario 
    FROM usuarios where usuario = '".$usuario."' and senha='".$senha."'";
    //PEGA OS DADOS DA APLICAÇÃO
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}


function func_pagina($pagina)
{
    global $conn;
    $sql_mapa_pagina = "SELECT * FROM mapa_arquivos WHERE arquivo LIKE '$pagina'";
    //PEGA OS DADOS DA PAGINA ATUAL
    $sql_pagina = $conn->prepare($sql_mapa_pagina);
    $sql_pagina->execute();
    return $sql_pagina;
}

function func_usuario($id_usuario){
    global $conn;
    $sql_usuario = "SELECT * FROM usuarios WHERE id_usuario LIKE '$id_usuario'";
    //PEGA OS DADOS DO USUÁRIO LOGADO
    $sql_usuario_dados = $conn->prepare($sql_usuario);
    $sql_usuario_dados->execute();
    return $sql_usuario_dados;
}

function func_montar_menu($usuario_id, $usuario_nivel){
    global $conn;
    $sql_menu = "SELECT * FROM app_menu 
WHERE nivel_permissoes LIKE '%".$usuario_nivel."%' 
ORDER BY ordem";
    //PEGA OS DADOS PARA MONTAR O MENU
    $sql_montar_menu = $conn->prepare($sql_menu);
    $sql_montar_menu->execute();
    return $sql_montar_menu;
}

function func_montar_submenu($usuario_id, $usuario_nivel, $tipo, $id_submenu){
    global $conn;
    switch($tipo){
        case 1:
            $sql_submenu = "SELECT * FROM app_submenu WHERE (nivel_permissoes LIKE '%".$usuario_nivel."%') AND id_subraiz = 0 AND id_raiz = $id_submenu ORDER BY ordem";
        break;
        case 2:
            $sql_submenu = "SELECT * FROM app_submenu WHERE (nivel_permissoes LIKE '%".$usuario_nivel."%' ) AND id_subraiz = $id_submenu ORDER BY ordem";
        break;
    }
    //PEGA OS DADOS PARA MONTAR O SUBMENU
    $sql_montar_submenu = $conn->prepare($sql_submenu);
    $sql_montar_submenu->execute();
    return $sql_montar_submenu;
}

function func_drop_uf($uf){
    global $conn;
    $sql_uf = "SELECT DISTINCT uf 
    FROM cidades 
    ORDER BY uf";
    //PEGA OS DADOS PARA MONTAR O DROP ESTADOS / UF
    $sql_drop_uf = $conn->prepare($sql_uf);
    $sql_drop_uf->execute();
    return $sql_drop_uf;
}

function func_drop_convenios(){
    global $conn;
    $sql = "SELECT * 
    FROM convenios 
    ORDER BY convenio";
    //PEGA OS DADOS PARA MONTAR O DROP ESTADOS / UF
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_drop_cidade($uf){
    global $conn;
    $sql_cidade = "SELECT DISTINCT cidade 
    FROM cidades 
    WHERE uf LIKE '%$uf%'";
    //PEGA OS DADOS PARA MONTAR O DROP CIDADES
    $sql_drop_cidades = $conn->prepare($sql_cidade);
    $sql_drop_cidades->execute();
    return $sql_drop_cidades;
}

function func_cad_cliente($dados_cliente){
    global $conn;
        $sql_cad_cliente = "INSERT INTO cliente_fornecedor (codigo, razao_social, nome_fantasia, documento,insc_estadual, insc_municipal,tipo_documento,
        endereco, numero, bairro, cidade, uf, cep, telefone, celular, contatos, emails, site, observacoes, data_cadastro, status_cliente, rg,
        tipo_convenio, convenio, convenio_validade, nascimento) VALUES
        (NULL, '".$dados_cliente['razao_social']."','".$dados_cliente['nome_fantasia']."', '".$dados_cliente['cnpj']."',
        '".$dados_cliente['insc_estadual']."','".$dados_cliente['insc_municipal']."','".$dados_cliente['tipo_documento']."',
        '".$dados_cliente['endereco']."','".$dados_cliente['numero']."', '".$dados_cliente['bairro']."', '".$dados_cliente['cidade']."',
        '".$dados_cliente['uf']."', '".$dados_cliente['cep']."', '".$dados_cliente['telefone']."', '".$dados_cliente['celular']."',
        '".$dados_cliente['contatos']."', '".$dados_cliente['email']."',
          '".$dados_cliente['site']."', '".$dados_cliente['observacoes']."', '".$dados_cliente['datahora']."', 1, '".$dados_cliente['rg']."', '".$dados_cliente['convenio_id']."',
        '".$dados_cliente['convenio_n']."', '".$dados_cliente['convenio_validade']."', '".$dados_cliente['nascimento']."');";
        //INSERE OS DADOS DO CLIENTE NO BANCO DE DADOS
        $sql_inserir_cliente = $conn->prepare($sql_cad_cliente);
        $sql_inserir_cliente->execute();

        return $sql_inserir_cliente;

}

function func_lista_cliente_fornecedor($pagina, $busca){
    global $conn;
    if($busca != null){
        $sql_busca = " WHERE (cf.nome_fantasia LIKE '%$busca%' OR cf.razao_social LIKE '%$busca%' OR cf.documento LIKE '%$busca%' OR cf.codigo LIKE '$busca' OR cf.convenio LIKE '%$busca%')";
    }
    if($pagina == 0){
        $sql_lista_cliente_fornecedor= "SELECT cf.codigo, UPPER(cf.razao_social) as razao_social,
  UPPER(cf.nome_fantasia) as nome_fantasia,
  UPPER(cf.nascimento) as nascimento,
  UPPER(cf.documento) as documento,
  UPPER(cf.rg) as rg,
  UPPER(cf.convenio) as convenio,
  UPPER(cf.convenio_validade) as convenio_validade,
  UPPER(cf.status_cliente) as status_cliente, c.convenio as convenio_nome 
  FROM cliente_fornecedor cf 
 INNER JOIN convenios c 
 ON cf.tipo_convenio = c.id $sql_busca";
    }
    //PEGA OS DADOS PARA LISTAR OS CLIENTES ATIVOS
    $sql_listagem_cliente_fornecedor = $conn->prepare($sql_lista_cliente_fornecedor);
    $sql_listagem_cliente_fornecedor->execute();
    return $sql_listagem_cliente_fornecedor;
}

function func_editar_cliente_fornecedor($id_cliente){
    global $conn;
    $sql_editar_cliente_fornecedor= "SELECT  cf.*, c.convenio as convenio_nome 
FROM cliente_fornecedor cf 
 INNER JOIN convenios c 
 ON cf.tipo_convenio = c.id 

WHERE c.codigo = $id_cliente";

    //PEGA OS DADOS EDITAR OS CLIENTE
    $sql_edicao_cliente_fornecedor = $conn->prepare($sql_editar_cliente_fornecedor);
    $sql_edicao_cliente_fornecedor->execute();
    return $sql_edicao_cliente_fornecedor;

}

function func_edicao_cliente($dados_cliente){
    global $conn;
    $sql_editar_cliente = "UPDATE cliente_fornecedor SET razao_social = '".utf8_decode($dados_cliente['razao_social'])."', nome_fantasia ='".utf8_decode($dados_cliente['nome_fantasia'])."', documento='".utf8_decode($dados_cliente['cnpj'])."',
       endereco = '".utf8_decode($dados_cliente['endereco'])."', numero = '".$dados_cliente['numero']."', bairro ='".utf8_decode($dados_cliente['bairro'])."', cidade ='".utf8_decode($dados_cliente['cidade'])."',
        uf = '".utf8_decode($dados_cliente['uf'])."', cep='".utf8_decode($dados_cliente['cep'])."', telefone='".utf8_decode($dados_cliente['telefone'])."', celular='".utf8_decode($dados_cliente['celular'])."',
       contatos = '".utf8_decode($dados_cliente['contatos'])."', emails ='".$dados_cliente['email']."',
         site = '".$dados_cliente['site']."' WHERE codigo ='".$dados_cliente['codigo']."'";
    //ATUALIZA OS DADOS DO CLIENTE NO BANCO DE DADOS
    $sql_edicao_cliente = $conn->prepare($sql_editar_cliente);
    $sql_edicao_cliente->execute();
    return $sql_edicao_cliente;

}

function func_inativar_cliente($id_cliente,$get_tipo){
    global $conn;
    $sql_inativar = "UPDATE cliente_fornecedor SET status_cliente = '$get_tipo' WHERE codigo = $id_cliente";
    //INATIVA O CLIENTE
    $sql_inativar_cliente = $conn->prepare($sql_inativar);
    $sql_inativar_cliente->execute();
    $total_alterado = $sql_inativar_cliente->rowCount();
    if($get_tipo != 0){
        $texto_comp = 'Ativado';
    } else {
        $texto_comp = 'Inativado';
    }
    if($total_alterado == 0){
        return 'Não foi possível realizar a ação.!';
    } else {
        return "$texto_comp com sucesso!";
    }

}

function func_tipos_clientes(){
    global $conn;
    $sql_tipos_clientes = "SELECT * FROM tipos_documento ORDER BY div_tab";

    //PEGA OS DADOS EDITAR OS CLIENTE
    $sql_montar_tipos = $conn->prepare($sql_tipos_clientes);
    $sql_montar_tipos->execute();
    return $sql_montar_tipos;

}


function func_banner_site(){
    global $conn;
    $sql_banner = "SELECT * FROM site_banners";
    //PEGA OS DADOS PARA MONTAR OS BANNERS DO SITE
    $sql_montar_banner = $conn->prepare($sql_banner);
    $sql_montar_banner->execute();
    return $sql_montar_banner;
}

function func_noticias_site($id_noticia){
    global $conn;
    $sql_noticia = "SELECT * FROM site_noticias WHERE id_noticia = $id_noticia";
    //PEGA OS DADOS DA NOTICIA PARA EXIBIR
    $sql_exibir_noticia = $conn->prepare($sql_noticia);
    $sql_exibir_noticia->execute();
    return $sql_exibir_noticia;
}

function func_editar_banner($id_banner){
    global $conn;
    $sql_banner = "SELECT * FROM site_banners WHERE id_banner = $id_banner";
    //PEGA OS DADOS PARA MONTAR OS BANNERS DO SITE
    $sql_editar_banner = $conn->prepare($sql_banner);
    $sql_editar_banner->execute();
    return $sql_editar_banner;
}

function func_edicao_banner($array_banner){
    global $conn;
    $sql_edicao_banner = "UPDATE site_banners SET img='".$array_banner['img']."',link='".$array_banner['link']."' WHERE id_banner = '".$array_banner['id_banner']."'";
    //ATUALIZA OS DADOS DOS BANNERS DO SITE
    $sql_salvar_edicao = $conn->prepare($sql_edicao_banner);
    $sql_salvar_edicao->execute();
    $total_alterado = $sql_salvar_edicao->rowCount();
    if($total_alterado == 0){
        return 'Não foi possível realizar a ação.!';
    } else {
        return "Banner alterado com sucesso!";
    }
}

function func_cad_noticia($dados_noticia){
    global $conn;
    $sql_cad_noticia = "INSERT INTO site_noticias (id_noticia, titulo, imagem, data, conteudo) VALUES
    (NULL, '".$dados_noticia['titulo']."', '".$dados_noticia['img_principal']."', '".$dados_noticia['data']."', '".$dados_noticia['conteudo']."')";
    //INSERE OS DADOS DA NOTICIA NO BANCO DE DADOS
    $sql_inserir_noticia = $conn->prepare($sql_cad_noticia);
    $sql_inserir_noticia->execute();
    $total_inserido = $sql_inserir_noticia->rowCount();
    if($total_inserido == 0){
        return "<script language=\"javascript\">
        alert('Erro ao inserir notícia');
        location.href='listar_noticias.php';
    </script>";
    } else {
        return "<script language=\"javascript\">
        alert('Notícia inserida com sucesso!');
        location.href='cad_noticia.php';
        </script>";
    }

}

function func_inserir_exercicio($dados){
    global $conn;
    $sql = "
    INSERT INTO exercicios 
    (exercicio, equipamentos, descricao) 
    VALUES 
    ('".utf8_decode($dados['exercicio'])."', '".utf8_decode($dados['equipamentos'])."', '".utf8_decode($dados['descricao'])."')";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_buscar_exercicios($busca){
    global $conn;
    $sql = "
    SELECT *
     FROM exercicios 
      WHERE  1 = 1 
    ";
    if(!empty($busca)){
        $sql .= " AND exercicio LIKE '%".utf8_encode($busca)."%'";
    }
    $sql .= "
    ORDER BY exercicio";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_dados_exercicio($id){
    global $conn;
    $sql = "
    SELECT *
     FROM exercicios 
      WHERE  id = {$id}
    ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_drop_contas($idEmpresa, $idFilial){
    global $conn;
    $sql = "
    SELECT *
     FROM conta
      WHERE  1 = 1
    ";
    if(!empty($idEmpresa)){
        $sql .= " AND id_empresa = {$idEmpresa} ";
    }
    if(!empty($idFilial)){
        $sql .= " AND (cc2_id = {$idFilial} OR cc2_id = 0) ";
    }

    $sql .= "ORDER BY nome_conta ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_drop_cc1($idEmpresa){
    global $conn;
    $sql = "
    SELECT *
     FROM cc1
      WHERE  1 = 1
    ";
    if(!empty($idEmpresa)){
        $sql .= " AND id = {$idEmpresa} ";
    }

    $sql .= "ORDER BY nome ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}
function func_dados_cc1($idEmpresa){
    global $conn;
    $sql = "
    SELECT *
     FROM cc1
      WHERE  id = {$idEmpresa} 
    ";

    $sql .= "ORDER BY nome ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_dados_cc2($idFilial){
    global $conn;
    $sql = "
    SELECT *
     FROM cc2
      WHERE  id = {$idFilial} 
    ";

    $sql .= "ORDER BY nome_filial ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_drop_cc2($idEmpresa, $idFilial = null){
    global $conn;
    $sql = "
    SELECT *
     FROM cc2
      WHERE  1 = 1
    ";
    if(!empty($idEmpresa)){
        $sql .= " AND id_empresa = {$idEmpresa} ";
    }
    if(!empty($idFilial)){
        $sql .= " AND id = {$idFilial} ";
    }
    $sql .= "ORDER BY nome_filial ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_drop_cc3($tipo){
    global $conn;
    $sql = "
    SELECT *
     FROM cc3
      WHERE  1 = 1
    ";
    if(!empty($tipo)){
        $sql .= " AND tipo = {$tipo} ";
    }
    $sql .= "ORDER BY nome_cc3 ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_drop_cc4($cc3Id){
    global $conn;
    $sql = "
    SELECT *
     FROM cc4
      WHERE  1 = 1
    ";
    if(!empty($cc3Id)){
        $sql .= " AND cc3_id = {$cc3Id} ";
    }
    $sql .= "ORDER BY nome_cc4 ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_buscar_cliente_fornecedor($busca = null){
    global $conn;
    $sql = "
    SELECT cf.*, c.convenio as convenio_nome
     FROM cliente_fornecedor cf 
     INNER JOIN convenios c 
     ON c.id = cf.tipo_convenio
      WHERE  1 = 1
    ";
    if(!empty($busca)){
        $sql .= " AND (cf.razao_social LIKE '%".$busca."%' OR 
         cf.nome_fantasia LIKE '%".$busca."%'  OR 
         cf.documento LIKE '%".$busca."%'  OR 
         cf.rg LIKE '%".$busca."%'  OR 
         cf.convenio LIKE '%".$busca."%' )";
    }
    $sql .= "ORDER BY cf.razao_social ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_gerar_titulo($dados){
    global $conn;
    $sql = "INSERT INTO titulos 
(cliente_fornecedor, tipo, emissao, vencimento, valor, desconto_porcentagem, desconto_real, descricao, 
conta_id, id_empresa, cc2_id, cc3_id, cc4_id, ativo, parcela) 
VALUES 
('".$dados['cliente_fornecedor']."','".$dados['tipo']."', '".format_data_us($dados['emissao'])."','".format_data_us($dados['vencimento'])."',
'".format_valor_db($dados['valor'])."','".format_valor_db($dados['desconto_porcentagem'])."', '".format_valor_db($dados['desconto_real'])."', 
'".utf8_decode($dados['descricao'])."', '".$dados['conta']."', '".$dados['cc1']."', '".$dados['cc2']."',
'".$dados['cc3']."', '".$dados['cc4']."', 1,'".$dados['parcela']."')";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_dados_cliente($id){
    global $conn;
    $sql = "
    SELECT *
     FROM cliente_fornecedor
      WHERE codigo = {$id}
    ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_buscar_titulos($clienteFornecedor, $tipo, $pago){
    global $conn;
    $sql = "
    SELECT tit.*, c.nome_conta, c.layout, u.nome as nome_usuario_baixa
     FROM titulos tit 
     INNER JOIN conta c 
     ON c.id = tit.conta_id 
     LEFT JOIN usuarios u 
     ON u.id_usuario = tit.usuario_baixa 
      WHERE tit.cliente_fornecedor = {$clienteFornecedor} AND tit.tipo = {$tipo} 
    ";
    if($pago == 1){
        $sql .= " AND tit.data_pagto IS NULL ORDER BY tit.vencimento";
    }
    if($pago == 2){
        $sql .= " AND tit.data_pagto IS NOT NULL ORDER BY tit.data_pagto";
    }

    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_dados_boleto($idTitulo, $clienteFornecedor, $parcela){
    global $conn;
    $sql = "
    SELECT tit.*, c.*, cf.razao_social as nome, cf.cidade, cf.uf, cf.cep, cf.endereco, cc1.nome as nome_cc1
     FROM titulos tit 
     INNER JOIN cliente_fornecedor cf 
     ON cf.codigo = tit.cliente_fornecedor 
     INNER JOIN conta c 
     ON c.id = tit.conta_id 
     INNER JOIN cc1 
     ON cc1.id = c.id_empresa
      WHERE tit.id_titulo = {$idTitulo} AND tit.cliente_fornecedor = {$clienteFornecedor} 
      AND tit.parcela = {$parcela} 
    ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_dados_boleto_id($idTitulo){
    global $conn;
    $sql = "
    SELECT tit.*, c.*, cf.codigo, cf.razao_social as nome, cf.cidade, cf.uf, cf.cep, cf.endereco, cc1.nome as nome_cc1
     FROM titulos tit 
     INNER JOIN cliente_fornecedor cf 
     ON cf.codigo = tit.cliente_fornecedor 
     INNER JOIN conta c 
     ON c.id = tit.conta_id 
     INNER JOIN cc1 
     ON cc1.id = c.id_empresa
      WHERE tit.id_titulo = {$idTitulo} 
    ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_atualizar_titulo($dados){
    global $conn;
    $sqlBaixa = '';
    if(!empty($dados['id_usuario'])){
        $sqlBaixa = ", arquivo_baixa = 'MANUAL', usuario_baixa = '".$dados['id_usuario']."', data_hora_baixa = NOW() ";
    }
    $sql = "
   UPDATE titulos 
   SET emissao =  '".format_data_us($dados['emissao'])."',
   vencimento =  '".format_data_us($dados['vencimento'])."',
   valor =  '".format_valor_db($dados['valor'])."',
   desconto_porcentagem =  '".format_valor_db($dados['desconto_porcentagem'])."',
   desconto_real =  '".format_valor_db($dados['desconto_real'])."',
   descricao =  '".utf8_decode($dados['descricao'])."',
   data_pagto =  '".format_data_us($dados['data_pagto'])."',
   valor_pagto =  '".format_valor_db($dados['valor_pagto'])."',
   conta_id =  '".format_valor_db($dados['conta'])."'
   {$sqlBaixa}
   WHERE id_titulo = '".$dados['id_titulo']."'
    ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}


function func_buscar_titulos_periodo($idEmpresa, $idFilial, $dataInicio, $dataFim, $tipo, $pago){
    global $conn;
    $sql = "
    SELECT tit.*, c.*, cf.codigo, cf.razao_social as nome, cf.cidade, cf.uf, cf.cep, cf.endereco, cc1.nome as nome_cc1
     FROM titulos tit 
     INNER JOIN cliente_fornecedor cf 
     ON cf.codigo = tit.cliente_fornecedor 
     INNER JOIN conta c 
     ON c.id = tit.conta_id 
     INNER JOIN cc1 
     ON cc1.id = c.id_empresa
      WHERE tit.tipo = {$tipo} AND tit.ativo = 1 
    ";
    if(!empty($idEmpresa)){
        $sql .= " AND cc1.id = {$idEmpresa} ";
    }
    if(!empty($idFilial)){
        $sql .= " AND tit.cc2_id = {$idFilial} ";
    }
    if($pago == 2){
        $sql .= " AND tit.vencimento BETWEEN '".format_data_us($dataInicio)."' AND '".format_data_us($dataFim)."' 
        AND (tit.data_pagto IS NULL OR tit.data_pagto = '0000-00-00') AND tit.valor_pagto = 0 ";
        $orderBy = 'tit.vencimento';
    }
    if($pago == 1){
        $sql .= " AND tit.data_pagto BETWEEN '".format_data_us($dataInicio)."' AND '".format_data_us($dataFim)."' ";
        $orderBy = 'tit.data_pagto';
    }
    $sql .= " ORDER BY {$orderBy}";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}

function func_atualizar_senha($idUsuario, $novaSenha){
    global $conn;
    $sql = "
    UPDATE usuarios 
    SET senha = '".$novaSenha."' 
      WHERE id_usuario = {$idUsuario}
    ";
    $sql_executar = $conn->prepare($sql);
    $sql_executar->execute();
    return $sql_executar;
}
?>