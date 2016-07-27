<!-- Main Sidebar -->
<div id="sidebar">
<!-- Sidebar Brand -->
<div id="sidebar-brand" class="themed-background">
    <a href="index.php" class="sidebar-title">
        <i class="fa fa-cube"></i> <span class="sidebar-nav-mini-hide"><?php echo $template['nome_app'] ;?></span>
    </a>
</div>
<!-- END Sidebar Brand -->

<!-- Wrapper for scrolling functionality -->
    <?php
    if(!isset($semMenu)){
    ?>
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Sidebar Navigation -->
            <ul class="sidebar-nav">
                <?php
                $sql_montar_menu = func_montar_menu($usuario_id, $usuario_nivel);
                while ($dados_menu = $sql_montar_menu->fetch(PDO::FETCH_ASSOC)) {
                    $menu_menu = $dados_menu['menu'];
                    $menu_link = $dados_menu['link'];
                    $menu_icone = $dados_menu['icone'];
                    $menu_submenu = $dados_menu['submenu'];
                    $menu_id_menu = $dados_menu['id_menu'];
                    if ($menu_link == basename($_SERVER['PHP_SELF'])) {
                        $menu_ativo = ' active';
                    } else {
                        $menu_ativo = '';
                    }
                    if ($menu_submenu == 0) {
                        echo "<li>
        <a href=\"$menu_link\" class=\"$menu_ativo\"><i class=\"$menu_icone sidebar-nav-icon\"></i><span class=\"sidebar-nav-mini-hide\">" . utf8_encode($menu_menu) . "</span></a>
    </li>";
                    } else {
                        echo "<li>
                <a href=\"$menu_link\" class=\"$menu_ativo sidebar-nav-submenu\"><i class=\"$menu_icone sidebar-nav-icon\"></i> <i class=\"fa fa-chevron-left sidebar-nav-indicator\"></i>$menu_menu</a>
                <ul>";
                        $sql_submenu1 = func_montar_submenu($usuario_id, $usuario_nivel, 1, $menu_id_menu);
                        while ($dados_submenu1 = $sql_submenu1->fetch(PDO::FETCH_ASSOC)) {
                            $submenu1_menu = $dados_submenu1['menu'];
                            $submenu1_submenu = $dados_submenu1['submenu'];
                            $submenu1_link = $dados_submenu1['link'];
                            $submenu1_id = $dados_submenu1['id_submenu'];
                            if ($submenu1_submenu == 0) {
                                echo "<li>
                        <a href=\"$submenu1_link\">" . utf8_encode($submenu1_menu) . "</a>
                    </li>";
                            } else {
                                echo "<li>
                <a href=\"$submenu1_link\" class=\"sidebar-nav-submenu\"><i class=\"fa fa-chevron-left sidebar-nav-indicator\"></i>".utf8_encode($submenu1_menu)."</a>
                        <ul>";
                                $sql_submenu2 = func_montar_submenu($usuario_id, $usuario_nivel, 2, $submenu1_id);
                                while ($dados_submenu2 = $sql_submenu2->fetch(PDO::FETCH_ASSOC)) {
                                    $submenu2_menu = $dados_submenu2['menu'];
                                    $submenu2_link = $dados_submenu2['link'];
                                    echo "<li>
                        <a href=\"$submenu2_link\">" . utf8_encode($submenu2_menu) . "</a>
                    </li>";
                                }
                                echo "</ul></li>";
                            }


                        }


                        echo "
                </ul>
            </li>";
                    }
                }

                ?>

                <li class="sidebar-separator">
                    <i class="fa fa-ellipsis-h"></i>
                </li>

        </div>
        <!-- END Sidebar Content -->
    </div>
    <!-- END Wrapper for scrolling functionality -->
<?php
}
?>

</div>
<!-- END Main Sidebar -->