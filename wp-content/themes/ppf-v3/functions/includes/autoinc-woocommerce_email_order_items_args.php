<?php
add_filter ('woocommerce_email_order_items_args', 'send_purchase_note_to_everyone');

function send_purchase_note_to_everyone( $args ) {
    $args['show_purchase_note']  = true;
    return $args;
}