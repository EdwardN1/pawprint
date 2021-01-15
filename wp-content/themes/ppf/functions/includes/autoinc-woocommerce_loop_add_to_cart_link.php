<?php
add_filter( 'woocommerce_loop_add_to_cart_link', 'replacing_add_to_cart_button', 10, 2 );
function replacing_add_to_cart_button( $button, $product  ) {

    if(is_product_category('free-resources') || has_term( array('free-resources'), 'product_cat', $product->get_id() )){
        $button = '<a class="button" href="' . $product->get_permalink() . '">Get Resource</a>';
    }

    return $button;

}