<?php
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;

    ob_start();

    ?>
    <a href="<?php echo wc_get_cart_url(); ?>" class="cart-customlocation">
        <img src="<?= get_template_directory_uri() ?>/assets/img/SVG/Basket.svg" alt=""
             class="basket-icon"> <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php echo WC()->cart->get_cart_total(); ?></a>
    </a>
    <?php
    $fragments['a.cart-customlocation'] = ob_get_clean();
    return $fragments;
}