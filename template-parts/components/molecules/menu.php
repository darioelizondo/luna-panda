<?php

    /**
     * Component: Molecule: Menu
     *
     * @package Darío Elizondo
     * 
     */

?>

<!-- Menu -->
<div id="menu" class="menu">
    <div class="menu__inner">
        <!-- Menu navigation -->
        <div class="menu__wrapper">
            <?php
                wp_nav_menu( array(
                    'theme_location'  => 'main_menu',
                    'menu'            => 'menu__main',
                    'container_class' => 'menu__list',
                    'menu_class'      => 'menu__nav',
                    'echo'            => true,
                    'items_wrap'      => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
                    'depth'           => 0,
                        'walker'          => new LunaPanda_Menu_Walker, 
                ));
            ?>
        </div>
        <!-- End menu navigation -->
    </div>
</div>
<!-- End menu -->