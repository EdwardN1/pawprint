<?php
function pawp_footer_nav($name)
{
    wp_nav_menu(array(
        'container' => false,                        // Remove nav container
        'menu_id' => 'nav-' . $name,                    // Adding custom nav id
        'menu_class' => 'footer-menu menu',    // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'theme_location' => $name,                    // Where it's located in the theme
        'depth' => 2,                            // Limit the depth of the nav
    ));
}