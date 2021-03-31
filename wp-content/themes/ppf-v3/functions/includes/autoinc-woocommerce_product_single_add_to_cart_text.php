<?php
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );
function woocommerce_custom_single_add_to_cart_text() {

    global $product;

    if(is_product_category('free-resources')){
        return __('Get Resource' , 'woocommerce');
    }else{

        if(get_post_meta($product->get_id() , '_ywpo_preorder' , true) == 'yes') {
            return __( 'Pre Order Now', 'woocommerce' );
        }else {
            return __('Add To Basket', 'woocommerce');
        }

    }
}