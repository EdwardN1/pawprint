<?php

add_action( 'init', 'clean_commerce_child_custom_woo_fix' );

function clean_commerce_child_custom_woo_fix() {

    add_filter( 'woocommerce_show_page_title', '__return_true', 1 );
    add_filter( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 6 );
}