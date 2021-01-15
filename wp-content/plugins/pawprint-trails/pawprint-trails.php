<?php

    /**
     *
     * Plugin Name: Pawprint Trails
     * Plugin URI: https://www.inlife.co.uk/
     * Version: 1.0
     *
     */

include 'pawprint-trails-questions.php';
include 'shortcodes/trails-validate-forms.php';
include 'shortcodes/trails-map-search.php';

add_action('woocommerce_add_cart_item_data', 'pp_trails_add_to_cart', 10, 3);

function pp_trails_add_to_cart($cart_item_data, $product_id, $variation_id){

    if(has_term('trails' , 'product_cat' , $product_id)) {

        $quantity = intval($_POST['quantity']);

        if($quantity > 1){

            for($i = 0; $i < $quantity; $i++){
                $cart_item_data['unique_id'][$i] = randString('10');
            }

        }else{
            $cart_item_data['unique_id'][1] = randString('10');
        }

        return $cart_item_data;

    }

}

function randString($length) {
    $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $char = str_shuffle($char);
    for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
        $rand .= $char{mt_rand(0, $l)};
    }
    return $rand;
}

function pp_trails_add_custom_text_to_order_items( $item, $cart_item_key, $values, $order ) {

    if ( !empty( $values['unique_id'] ) ) {

        if(is_array($values['unique_id'])){
            foreach($values['unique_id'] as $value){
                $item->add_meta_data('Unique Trail Answers ID', $value );
            }
        }else{
            $item->add_meta_data('Unique Trail Answers ID', $values['unique_id'] );
        }

    }

}

add_action( 'woocommerce_checkout_create_order_line_item', 'pp_trails_add_custom_text_to_order_items', 10, 4 );

add_action('woocommerce_checkout_order_processed', 'pp_trails_add_data');

function pp_trails_add_data($order_id){

    global $wpdb;

    $order = wc_get_order( $order_id );
    $items = $order->get_items();

    foreach($items as $item){

        $product = $item->get_product();
        $product_id = $product->get_id();

        if(has_term('trails' ,  'product_cat' , $product_id)){

            $uid = wc_get_order_item_meta($item->get_id() , 'Unique Trail Answers ID' , false );

            foreach($uid as $value){

                $check = $wpdb->get_row('SELECT * FROM wp_order_trail_unique_ids WHERE uid = "'.$value.'"');

                if(!$check){

                    $wpdb->insert(
                        'wp_order_trail_unique_ids' ,
                        array(
                            'user_id' => get_current_user_id(),
                            'order_id' => $order_id,
                            'trail_id' => $product_id,
                            'uid' => $value,
                            'date_created' => date('c')
                        )
                    );

                }

            }

        }

    }

}

