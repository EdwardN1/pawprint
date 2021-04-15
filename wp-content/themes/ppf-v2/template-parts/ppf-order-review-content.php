<div class="header">
    <h3>Order Summary</h3>
</div>
<?php
global $woocommerce;
$items = $woocommerce->cart->get_cart();
$totals = $woocommerce->cart->get_totals();
$dates = array();
?>
<div class="items">
    <?php foreach ($items as $item) {
        $product = wc_get_product($item['data']->get_id()); ?>
        <?php
        if ($product->get_stock_status() == 'onbackorder') {
            if ($product->get_stock_status() == 'onbackorder' && get_field('estimated_delivery_date', $item['data']->get_id()) != '') {
                $date = str_replace('/', '-', get_field('estimated_delivery_date', $item['data']->get_id()));
                $dates[] = strtotime($date);
            }
        }
        ?>
        <div class="item">
            <img width="40px;" src="<?= get_the_post_thumbnail_url($item['data']->get_id()) ?>" alt="">
            <div class="title">
                <p><?= $product->get_title() ?> x<?= $item['quantity'] ?></p>
                <?php if ($product->get_stock_status() == 'onbackorder' && get_field('estimated_delivery_date', $item['data']->get_id()) != '') { ?>
                    <p class="estimated-date">
                        Estimated Dispatch Date:
                        <?= get_field('estimated_delivery_date', $item['data']->get_id()) ?>
                    </p>
                <?php } ?>
            </div>
            <div class="price"><p>&pound;<?= number_format(($item['data']->get_regular_price() * $item['quantity']), 2) ?></p></div>
        </div>
    <?php } ?>
</div>
<div class="totals">
    <div class="total">
        <div class="title"><p>Sub Total</p></div>
        <div class="price"><p>£<?= number_format($totals['subtotal'], 2) ?></p></div>
    </div>
    <div class="total">
        <div class="title"><p>Delivery</p></div>
        <div class="price"><p>£<?= number_format($totals['shipping_total'], 2) ?></p></div>
    </div>
    <div class="total">
        <div class="title"><p>Tax</p></div>
        <div class="price"><p>£<?= number_format($totals['subtotal_tax'] + $totals['shipping_tax'], 2) ?></p></div>
    </div>
    <?php if ($totals['fee_total'] != 0) { ?>
        <div class="total">
            <div class="title"><p>Discount</p></div>
            <div class="price"><p>£<?= number_format($totals['fee_total'] + $totals['fee_tax'], 2) ?></p></div>
        </div>
    <?php } ?>
    <div class="total">
        <div class="title"><p>Total</p></div>
        <div class="price"><p>£<?= number_format($totals['total'], 2) ?></p></div>
    </div>
</div>
<?php
if (!empty($dates)) {
    $date = max($dates);
    $dateFormat = date('F d, Y', $date);
    echo '<p class="cart-delivery-date">Based on the products that are in your basket, the estimated dispatch date for your order is:<br/>' . $dateFormat . '</p>';
}
?>