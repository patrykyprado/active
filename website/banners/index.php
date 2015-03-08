<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 06/02/15
 * Time: 20:48
 */
require_once('../../inc/conectar.php');
require_once('../../inc/sql.php');

$sql_banners = func_banner_site();
?>

<!DOCTYPE html>
<html>
<head>
    <title>BANNER PHP</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Banner PHP" />

    <!-- Start WOWSlider.com HEAD section --> <!-- add to the <head> of your page -->
    <link rel="stylesheet" type="text/css" href="engine1/style.css" />
    <script type="text/javascript" src="engine1/jquery.js"></script>
    <!-- End WOWSlider.com HEAD section -->

</head>
<body style="margin:auto">

<!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
<div id="wowslider-container1">
    <div class="ws_images"><ul>
<?php
while($dados_banner = $sql_banners->fetch(PDO::FETCH_ASSOC)){
    $banner_id = $dados_banner['id_banner'];
    $img_link = 'img/'.$dados_banner['img'];
    $link_banner = $dados_banner['link'];
    echo "<li><a target=\"_top\" href=\"$link_banner\"><img src=\"$img_link\" alt=\"CETEPS\" title=\"CETEPS\" id=\"$banner_id\"/></a></li>";
}
?>
        </ul></div>
    <div class="ws_bullets"><div>
            <?php
            $sql_banners2 = func_banner_site();
            while($dados_banner2 = $sql_banners2->fetch(PDO::FETCH_ASSOC)){
                $banner_id = $dados_banner2['id_banner'];
                $img_link = 'img/'.$dados_banner2['img'];
                $link_banner = $dados_banner2['link'];
                echo "<a href=\"#$banner_id\" title=\"#$banner_id\"><span><img width=\"118px\" height=\"48px\" src=\"$img_link\" alt=\"$banner_id\"/>$banner_id</span></a>";
            }
            ?>
            </div>
</div>
<script type="text/javascript" src="engine1/wowslider.js"></script>
<script type="text/javascript" src="engine1/script.js"></script>
<!-- End WOWSlider.com BODY section -->

</body>
</html>