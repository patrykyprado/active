<?php
session_start();
//PEGA OS DADOS DA PAGINA
$sql_pagina = func_pagina(basename($_SERVER['PHP_SELF']));
$dados_pagina = $sql_pagina->fetch(PDO::FETCH_ASSOC);

//PEGA OS DADOS DO APP
$sql_config_app = func_config_app();
$dados_config = $sql_config_app->fetch(PDO::FETCH_ASSOC);

//ENVIA PARA A VARIAVEL TEMPLATE
$template['header_link'] = utf8_encode($dados_pagina['titulo']);
$template['permissao_pagina'] = $dados_pagina['permissoes'];
$template['nome_app'] = $dados_config['nome_app'];

//PEGA OS DADOS DO USU�RIO LOGADO
$sql_usuario = func_usuario($_SESSION['user_id']);
$dados_usuario = $sql_usuario->fetch(PDO::FETCH_ASSOC);
$usuario_nome = $dados_usuario['nome'];
$usuario_email = $dados_usuario['email'];
$usuario_nivel = $dados_usuario['nivel'];
$usuario_nivel_nome = $dados_usuario['nivel_nome'];
$usuario_empresa = $dados_usuario['empresa'];
$usuario_filial = $dados_usuario['filial'];
$usuario_foto = $dados_usuario['foto'];
$usuario_id = $dados_usuario['id_usuario']
?>