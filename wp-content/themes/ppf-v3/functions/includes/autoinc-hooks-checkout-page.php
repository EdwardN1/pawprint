<?php
//add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
//add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
//add_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );

//add_action( 'woocommerce_checkout_billing', array( self::$instance, 'checkout_form_billing' ) );
//add_action( 'woocommerce_checkout_shipping', array( self::$instance, 'checkout_form_shipping' ) );

//add_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
//add_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

add_action( 'woocommerce_checkout_create_order_line_item', 'iconic_add_engraving_text_to_order_items', 10, 4 );

function iconic_add_engraving_text_to_order_items( $item, $cart_item_key, $values, $order ) {

    $product = $item->get_product();
    $productData = $product->get_data();
    $productID = $productData['id'];

    if(get_field('estimated_delivery_date' , $productID) != '' && $product->get_stock_status() == 'onbackorder'){
        $item->add_meta_data( __( 'Estimated Dispatch Date' ), get_field('estimated_delivery_date' , $productID) );
    }

}

add_action('woocommerce_after_checkout_form' , 'ppf_order_summary');

function ppf_order_summary(){

    get_template_part('template-parts/ppf' , 'order-review');

}