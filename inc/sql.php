<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 27/01/15
 * Time: 09:26
 */

function format_data_us($data){
    return substr($data,6,4).'-'.substr($data,3,2).'-'.substr($data,0,2);
}
function func_config_app()
{
    global $conn;
    $sql_config = "SELECT * FROM config_app";
    //PEGA OS DADOS DA APLICA��O
    $sql_config_app = $conn->prepare($sql_config);
    $sql_config_app->execute();
    return $sql_config_app;
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
    //PEGA OS DADOS DO USU�RIO LOGADO
    $sql_usuario_dados = $conn->prepare($sql_usuario);
    $sql_usuario_dados->execute();
    return $sql_usuario_dados;
}

function func_montar_menu($usuario_id, $usuario_nivel){
    global $conn;
    $sql_menu = "SELECT * FROM app_menu WHERE $usuario_nivel IN (nivel_permissoes) OR nivel_permissoes = 0 OR $usuario_id IN (permissoes)";
    //PEGA OS DADOS PARA MONTAR O MENU
    $sql_montar_menu = $conn->prepare($sql_menu);
    $sql_montar_menu->execute();
    return $sql_montar_menu;
}

function func_montar_submenu($usuario_id, $usuario_nivel, $tipo, $id_submenu){
    global $conn;
    switch($tipo){
        case 1:
            $sql_submenu = "SELECT * FROM app_submenu WHERE ($usuario_nivel IN (nivel_permissoes) OR nivel_permissoes = 0 OR $usuario_id IN (permissoes)) AND id_subraiz = 0 AND id_raiz = $id_submenu";
        break;
        case 2:
            $sql_submenu = "SELECT * FROM app_submenu WHERE ($usuario_nivel IN (nivel_permissoes) OR nivel_permissoes = 0 OR $usuario_id IN (permissoes)) AND id_subraiz = $id_submenu";
        break;
    }
    //PEGA OS DADOS PARA MONTAR O SUBMENU
    $sql_montar_submenu = $conn->prepare($sql_submenu);
    $sql_montar_submenu->execute();
    return $sql_montar_submenu;
}

function func_drop_uf($uf){
    global $conn;
    $sql_uf = "SELECT DISTINCT uf FROM cidades WHERE uf NOT LIKE '%$uf%'";
    //PEGA OS DADOS PARA MONTAR O DROP ESTADOS / UF
    $sql_drop_uf = $conn->prepare($sql_uf);
    $sql_drop_uf->execute();
    return $sql_drop_uf;
}

function func_drop_cidade($uf){
    global $conn;
    $sql_cidade = "SELECT DISTINCT cidade FROM cidades WHERE uf LIKE '%$uf%'";
    //PEGA OS DADOS PARA MONTAR O DROP CIDADES
    $sql_drop_cidades = $conn->prepare($sql_cidade);
    $sql_drop_cidades->execute();
    return $sql_drop_cidades;
}

function func_cad_cliente($dados_cliente){
    global $conn;
        $sql_cad_cliente = "INSERT INTO cliente_fornecedor (codigo, razao_social, nome_fantasia, documento,
        insc_estadual, insc_municipal, tipo_documento, endereco, numero, bairro, cidade, uf, cep, telefone,
         celular, contatos, emails, site, observacoes, data_cadastro, status_cliente) VALUES
        (NULL, '".$dados_cliente['razao_social']."','".$dados_cliente['nome_fantasia']."', '".$dados_cliente['cnpj']."',
        '".$dados_cliente['insc_estadual']."','".$dados_cliente['insc_municipal']."','".$dados_cliente['tipo_documento']."',
        '".$dados_cliente['endereco']."','".$dados_cliente['numero']."', '".$dados_cliente['bairro']."', '".$dados_cliente['cidade']."',
        '".$dados_cliente['uf']."', '".$dados_cliente['cep']."', '".$dados_cliente['telefone']."', '".$dados_cliente['celular']."',
        '".$dados_cliente['contatos']."', '".$dados_cliente['email']."',
          '".$dados_cliente['site']."', '".$dados_cliente['observacoes']."', '".$dados_cliente['datahora']."',1);";
        //INSERE OS DADOS DO CLIENTE NO BANCO DE DADOS
        $sql_inserir_cliente = $conn->prepare($sql_cad_cliente);
        $sql_inserir_cliente->execute();
        $total_inserido = $sql_inserir_cliente->rowCount();
        if($total_inserido == 0){
            return "<script language=\"javascript\">
    alert('Não foi possível cadastrar o cliente. Erro.');
    </script>";

        } else {
            return "<script language=\"javascript\">
    alert('Cliente cadastrado com sucesso!.');
    location.href= 'listar_clientes.php';
    </script>";
        }

}

function func_lista_cliente_fornecedor($pagina, $busca){
    global $conn;
    if($busca != null){
        $sql_busca = " WHERE (nome_fantasia LIKE '%$busca%' OR razao_social LIKE '%$busca%' OR documento LIKE '%$busca%' OR codigo LIKE '$busca')";
    }
    if($pagina == 0){
        $sql_lista_cliente_fornecedor= "SELECT codigo, razao_social, documento, nome_fantasia, tipo_documento,
        status_cliente
         FROM cliente_fornecedor $sql_busca";
    }
    //PEGA OS DADOS PARA LISTAR OS CLIENTES ATIVOS
    $sql_listagem_cliente_fornecedor = $conn->prepare($sql_lista_cliente_fornecedor);
    $sql_listagem_cliente_fornecedor->execute();
    return $sql_listagem_cliente_fornecedor;
}

function func_editar_cliente_fornecedor($id_cliente){
    global $conn;
    $sql_editar_cliente_fornecedor= "SELECT * FROM cliente_fornecedor WHERE codigo = $id_cliente";

    //PEGA OS DADOS EDITAR OS CLIENTE
    $sql_edicao_cliente_fornecedor = $conn->prepare($sql_editar_cliente_fornecedor);
    $sql_edicao_cliente_fornecedor->execute();
    return $sql_edicao_cliente_fornecedor;

}

function func_edicao_cliente($dados_cliente){
    global $conn;
    $sql_editar_cliente = "UPDATE cliente_fornecedor SET razao_social = '".$dados_cliente['razao_social']."', nome_fantasia ='".$dados_cliente['nome_fantasia']."', documento='".$dados_cliente['cnpj']."',
       endereco = '".$dados_cliente['endereco']."', numero = '".$dados_cliente['numero']."', bairro ='".$dados_cliente['bairro']."', cidade ='".$dados_cliente['cidade']."',
        uf = '".$dados_cliente['uf']."', cep='".$dados_cliente['cep']."', telefone='".$dados_cliente['telefone']."', celular='".$dados_cliente['celular']."',
       contatos = '".$dados_cliente['contatos']."', emails ='".$dados_cliente['email']."',
         site = '".$dados_cliente['site']."' WHERE codigo ='".$dados_cliente['codigo']."'";
    //ATUALIZA OS DADOS DO CLIENTE NO BANCO DE DADOS
    $sql_edicao_cliente = $conn->prepare($sql_editar_cliente);
    $sql_edicao_cliente->execute();
    $total_alterado = $sql_edicao_cliente->rowCount();
    if($total_alterado == 0){
        return 'Nenhuma altera��o foi realizada!';
    } else {
        return 'Todos os dados foram atualizados!';
    }

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
        return 'N�o foi poss�vel realizar a a��o.!';
    } else {
        return "$texto_comp com sucesso!";
    }

}

function func_tipos_clientes(){
    global $conn;
    $sql_tipos_clientes = "SELECT * FROM tipos_documento ORDER BY tipo_documento";

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
        return 'N�o foi poss�vel realizar a a��o.!';
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
        alert('Erro ao inserir not�cia');
        location.href='listar_noticias.php';
    </script>";
    } else {
        return "<script language=\"javascript\">
        alert('Not�cia inserida com sucesso!');
        location.href='cad_noticia.php';
        </script>";
    }

}
?>