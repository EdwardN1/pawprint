<div class="myaccount_single_order_details">
    <div class="item">
        <p>
            <strong>Order Number:</strong>
            <?=$order->get_order_number()?>
        </p>
    </div>
    <div class="item">
        <p>
            <strong>Order Date:</strong>
            <?=date('F d, Y' , strtotime($order->get_date_created()))?>
        </p>
    </div>
    <div class="item">
        <p>
            <strong>Order Status:</strong>
            <?php

            switch (wc_get_order_status_name( $order->get_status() )){

                case 'Awaiting Payment':
                case 'Processing':

                    echo '<img src="/wp-content/uploads/2020/03/order-orange-dot.png" style="width: 14px !important; margin-right: 2px !important; display: inline-block !important; vertical-align: middle !important;">';

                    break;

                case 'Refunded':
                case 'Cancelled':

                    echo '<img src="/wp-content/uploads/2020/03/order-red-dot.png" style="width: 14px !important; margin-right: 2px !important; display: inline-block !important; vertical-align: middle !important;">';

                    break;

                case 'Complete':

                    echo '<img src="/wp-content/uploads/2020/03/order-red-dot.png" style="width: 14px !important; margin-right: 2px !important; display: inline-block !important; vertical-align: middle !important;">';

                    break;

            }

            ?>
            <?=wc_get_order_status_name( $order->get_status() )?>
        </p>
    </div>
    <div class="item">
        <p>
            <strong>Order Quantity:</strong>
            <?=$order->get_order_number()?>
        </p>
    </div>
    <div class="item">
        <p>
            <strong>Order Total:</strong>
            £<?=$order->get_total()?>
        </p>
    </div>
    <div class="item">
        <p>
            <strong>Payment Method:</strong>
            <?=$order->get_payment_method_title()?>
        </p>
    </div>
</div>

<div class="myaccount_single_order_addresses">
    <div class="address">
        <h3>Delivery Address</h3>
        <p>
            <?=$order->get_shipping_address_1()."<br/>"?>
            <?=$order->get_shipping_address_2()."<br/>"?>
            <?=$order->get_shipping_city()."<br/>"?>
            <?=$order->get_shipping_country()."<br/>"?>
            <?=$order->get_shipping_state()."<br/>"?>
            <?=$order->get_shipping_postcode()?>
        </p>
    </div>
    <div class="address">
        <h3>Billing Address</h3>
        <p>
            <?=$order->get_billing_address_1()."<br/>"?>
            <?=$order->get_billing_address_2()."<br/>"?>
            <?=$order->get_billing_city()."<br/>"?>
            <?=$order->get_billing_country()."<br/>"?>
            <?=$order->get_billing_state()."<br/>"?>
            <?=$order->get_billing_postcode()?>
        </p>
    </div>
    <div class="address">
        <h3>Email Address</h3>
        <p><?=$order->get_billing_email()?></p>
        <h3>Phone Number</h3>
        <p><?=$order->get_billing_phone()?></p>
    </div>
</div>

<?php

    $items = $order->get_items();
    $totals = array(
        'subtotal' => $order->get_subtotal(),
        'shipping_total' => $order->get_shipping_total(),
        'total' => $order->get_total(),
        'tax' => $order->get_cart_tax(),
    );

    $dates = array();

?>

<div class="myaccount_single_order_items">
    <h3>Order Items</h3>
    <table width="100%" cellspacing="0" cellpadding="15" style="margin-bottom: 0px !important;">
        <thead>
            <tr>
                <th align="left" width="60%">Product</th>
                <th align="left">Price</th>
                <th align="left">Quantity</th>
                <th align="left">Tax</th>
                <th align="left">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item){ $itemdata = $item->get_data(); $product =  wc_get_product( $itemdata['product_id'] ); ?>
                <?php
                    if($item->get_meta('Estimated Dispatch Date')){
                        $date = str_replace('/' , '-' , $item->get_meta('Estimated Dispatch Date'));
                        $dates[] = strtotime($date);
                    }
                ?>
                <tr>
                    <td>
                        <img style="display: inline-block; vertical-align: middle;" src="<?=get_the_post_thumbnail_url($itemdata['product_id'])?>" width="100px" alt="">
                        <div class="title" style="display: inline-block; vertical-align: middle; margin: 0 0 0 20px;">
                            <p style="margin: 0px;"><?=$product->get_title()?></p>
                            <?php if($item->get_meta('Estimated Dispatch Date')){ ?>
                                <p class="estimated-date" style="margin: 0px; color: red;">
                                    Estimated Dispatch Date:
                                    <?=$item->get_meta('Estimated Dispatch Date')?>
                                </p>
                            <?php } ?>
                            <?php if($item->get_meta('Unique Trail Answers ID')){ ?>
                                <?php foreach($item->get_meta('Unique Trail Answers ID' , false) as $value){ $data = $value->get_data(); ?>
                                    <p><b>Unique Trail Answers ID:</b> <?=$data['value']?></p>
                                <?php } ?>
                            <?php } ?>
                            <?=$product->get_purchase_note()?>
                        </div>
                    </td>
                    <td>£<?=number_format(round($itemdata['subtotal'], 2) , 2)?></td>
                    <td><?=$itemdata['quantity']?></td>
                    <td>£<?=number_format(round($itemdata['total_tax'], 2) , 2)?></td>
                    <td>£<?=number_format(round($itemdata['subtotal']+$itemdata['total_tax'], 2) , 2)?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <table id="orderTotals" style="float: right" cellpadding="15" cellspacing="0">
        <tbody>
            <tr>
                <th align="right"><p><strong>Sub Total</strong></p></th>
                <td><p>£<?=number_format($totals['subtotal'] , 2)?></p></td>
            </tr>
            <tr>
                <th align="right"><p><strong>Delivery</strong></p></th>
                <td><p>£<?=number_format($totals['shipping_total'] , 2)?></p></td>
            </tr>
            <tr>
                <th align="right"><p><strong>Tax</strong></p></th>
                <td><p>£<?=number_format($totals['tax'] , 2)?></p></td>
            <tr>
            </tr>
                <th align="right"><p><strong>Total</strong></p></th>
                <td><p>£<?=number_format($totals['total'] , 2)?></p></td>
            </tr>
        </tbody>
    </table>
    <br clear="all">
    <?php
        if(!empty($dates)){
            $date = max($dates);
            $dateFormat = date('jS F Y' , $date);
            echo '<p class="cart-delivery-date">Based on the products that are in your basket, the estimated dispatch date for your order is:<br/>'.$dateFormat.'</p>';
        }
    ?>
</div>