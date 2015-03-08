<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 06/02/15
 * Time: 20:48
 */
require_once('../../inc/conectar.php');
require_once('../../inc/sql.php');
$get_noticia = $_GET['id'];
$sql_noticia = func_noticias_site($get_noticia);
$dados_noticia = $sql_noticia->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notícias</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Noticias PHP" />
    <style>
        .titulo_noticia {
            font-family: tahoma, verdana, arial, sans-serif;
            font-size: 30px;
            color: #252d2f;
        }
        .img_noticia {
            width: auto;
            height: 210px;
        }

        .texto_noticia{
            font-family: tahoma, verdana, arial, sans-serif;
            font-size: 14px;
            color: #252d2f;
        }

    </style>
</head>
<body style="margin:auto">
<div class="titulo_noticia">
    <?php
    echo $dados_noticia['titulo'];
    ?>
</div>
<br>
    <img src="<?php
    echo $dados_noticia['imagem'];
    ?>" class="img_noticia"/>
<br>
<div class="texto_noticia">
    <?php
    echo $dados_noticia['conteudo'];
    ?>
</div>


</body>
</html>