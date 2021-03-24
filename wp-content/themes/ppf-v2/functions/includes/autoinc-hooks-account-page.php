<?php
add_action('woocommerce_account_orders_columns' , 'ppf_wc_get_account_orders_columns');

function ppf_wc_get_account_orders_columns($columns){

    unset( $columns['order-total'] );

    $columns['order_qty'] = 'Order Quantity';
    $columns['order_total'] = 'Order Total';
    $columns['payment_method'] = 'Payment Method';

    return $columns;

}

add_filter( 'woocommerce_account_menu_items', 'misha_remove_my_account_dashboard' );
function misha_remove_my_account_dashboard( $menu_links ){

    unset( $menu_links['dashboard'] );
    return $menu_links;

}

add_action( 'woocommerce_save_account_details', 'my_save_account_details_redirect', 10, 1 );

function my_save_account_details_redirect($user_id){
    wp_safe_redirect( wc_get_endpoint_url( 'edit-account') );
    exit;
}