<?php
/**
 * Add Tracking Code to the Thank You Page - http://danielsantoro.com/add-facebook-tracking-pixel-woocommerce-checkout/
 */
function paw_checkout_analytics( $order_id ) {
    $order = new WC_Order( $order_id );
    $currency = $order->get_order_currency();
    $total = $order->get_total();
    $date = $order->order_date;
    error_log('Thank Page Hook Fired');
    ?>
    <!-- Paste Tracking Code Under Here -->
    <script type="text/javascript">
        window.console.log('FB Pixel Event');
        fbq('track', 'Purchase', {currency: "<?php echo $currency;?>", value: <?php echo $total; ?>});
    </script>

    <!-- End Tracking Code -->
    <?php
}
add_action( 'woocommerce_thankyou', 'paw_checkout_analytics' );