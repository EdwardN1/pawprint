<?php
//add_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );

//add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
//add_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

//add_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );

add_action('woocommerce_after_cart' , 'ppf_delivery_date');

function ppf_delivery_date(){

    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    $dates = array();

    foreach ($items as $item) {

        $_product =  wc_get_product( $item['data']->get_id());

        if($_product->get_stock_status() == 'onbackorder' && get_field('estimated_delivery_date' , $item['data']->get_id()) != ''){
            $date = str_replace('/' , '-' , get_field('estimated_delivery_date' , $item['data']->get_id()));
            $dates[] = strtotime($date);
        }

    }

    $date = max($dates);
    $dateFormat = date('dS F Y' , $date);

    if(!empty($dates)){
        echo '<p class="cart-delivery-date">Based on the products that are in your basket, the estimated dispatch date for your order is:<br/>'.$dateFormat.'</p>';
    }

}

add_filter ('woocommerce_cart_item_name', 'add_estimated_date' , 10, 3 );

function add_estimated_date($product_title, $cart_item, $cart_item_key){

    if(get_field('estimated_delivery_date' , $cart_item['product_id']) != ''){
        if(get_post_meta($cart_item['product_id'] , '_ywpo_preorder' , true) == 'yes') {
            return $product_title.'<span style="color: red;">Estimated Dispatch Date: '.get_field('estimated_delivery_date' , $cart_item['product_id']).' (Pre-order)</span>';
        }else{
            return $product_title.'<span style="color: red;">Estimated Dispatch Date: '.get_field('estimated_delivery_date' , $cart_item['product_id']).'</span>';
        }
    }else{
        return $product_title;
    }

}

add_filter( 'woocommerce_cart_shipping_method_full_label', 'bbloomer_add_0_to_shipping_label', 10, 2 );

function bbloomer_add_0_to_shipping_label( $label, $method ) {

// if shipping rate is 0, concatenate ": $0.00" to the label
    if ( ! ( $method->cost > 0 ) ) {
        $label .= ': ' . wc_price(0);
    }

// return original or edited shipping label
    return $label;

}