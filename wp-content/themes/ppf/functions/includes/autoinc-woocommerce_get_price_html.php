<?php
add_filter( 'woocommerce_get_price_html', 'cw_change_product_html', 10, 2 );

function cw_change_product_html( $price_html, $product ) {

    global $wp;
    $current_url = home_url( add_query_arg( array(), $wp->request ) );

    if(strpos($current_url , 'free-resources') && !is_singular()){
        $price_html = '';
    }

    return $price_html;
}

