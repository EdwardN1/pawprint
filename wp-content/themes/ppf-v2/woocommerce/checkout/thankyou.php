<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$currency = $order->get_order_currency();
$total = $order->get_subtotal();
$date = $order->order_date;
//error_log('Thank Page Hook Fired');
?>
<!-- Paste Tracking Code Under Here -->
<script type="text/javascript">
    //window.console.log('FB Pixel Event');
    fbq('track', 'Purchase', {currency: "<?php echo $currency;?>", value: <?php echo $total; ?>});
</script>

<!-- End Tracking Code -->

<div class="woocommerce-order">

    <div class="woocommerce_thank_you">

        <div class="left">

            <?php if ( $order->has_status( 'failed' ) ){ ?>

                <div class="woocommerce_order_complete_status failed"></div>

            <?php }else{ ?>

                <div class="woocommerce_order_complete_status success">
                    <img src="<?=get_site_url()?>/wp-content/uploads/2020/03/tick.png" alt="">
                    <strong>Congratulations! Your order has been placed.</strong>
                    <p>We will send you an email to confirm your order details.</p>
                </div>

            <?php } ?>

            <?php if(!is_user_logged_in()){ ?>

            <div class="woocommerce_thank_you_block">
                <div class="header">
                    <h3>Create Account</h3>
                    <?php
                        if(isset($_POST['_create_account'])){

                            $user_id = wp_create_user(
                                $_POST['f_name'].$_POST['l_name'],
                                $_POST['password'],
                                $_POST['email']
                            );

                            if($user_id->has_errors()){
                                foreach ($user_id->errors as $error){
                                    echo '<p>'.$error[0].'</p>';
                                }
                            }else{
                                $order->set_customer_id($user_id);
                                echo '<p>Account has been create please login to view your order history.</p>';
                            }

                        }
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?=$order->get_id()?>">
                        <div class="form-row">
                            <div class="form-half">
                                <label for="">First Name</label>
                                <input type="text" name="f_name">
                            </div>
                            <div class="form-half">
                                <label for="">Last Name</label>
                                <input type="text" name="l_name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-full">
                                <label for="">Email</label>
                                <input type="email" name="email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-full">
                                <label for="">Password</label>
                                <input type="password" name="password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-full text-right">
                                <button class="pp-btn navy" type="submit" name="_create_account">Create Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php } ?>

            <div class="woocommerce_thank_you_block">
                <div class="header">
                    <h3>Order Details</h3>
                    <div class="info">
                        <strong>Order Number:</strong><p><?=$order->get_order_number()?></p>
                    </div>
                </div>
                <div class="payment_info">
                    <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                </div>
                <div class="delivery_block">
                    <h3>Delivery Address</h3>
                    <p>
                        <strong><?=$order->get_shipping_first_name().' '.$order->get_shipping_last_name()?></strong>
                        <?=
                            $order->get_shipping_address_1().', '.
                            $order->get_shipping_address_2().', '.
                            $order->get_shipping_city().', '.
                            $order->get_shipping_country().', '.
                            $order->get_shipping_state().', '.
                            $order->get_shipping_postcode()
                        ?>
                    </p>
                </div>
                <div class="delivery_block">
                    <h3>Billing Address</h3>
                    <p>
                        <strong><?=$order->get_billing_first_name().' '.$order->get_billing_last_name()?></strong>
                        <?=
                            $order->get_billing_address_1().', '.
                            $order->get_billing_address_2().', '.
                            $order->get_billing_city().', '.
                            $order->get_billing_country().', '.
                            $order->get_billing_state().', '.
                            $order->get_billing_postcode()
                        ?>
                    </p>
                </div>
            </div>

        </div>
        <div class="right">
            <div class="ppf_side_order_review">
                <div class="header">
                    <h3>Order Summary</h3>
                </div>
                <?php
                    $items = $order->get_items();
                    $totals = array(
                        'subtotal' => $order->get_subtotal(),
                        'shipping_total' => $order->get_shipping_total(),
                        'total' => $order->get_total(),
                        'fees' => $order->get_fees(),
                        'subtotal_tax' => $order->get_total_tax()
                    );
                    $dates = array();
                ?>
                <div class="items">
                    <?php foreach($items as $item){ $itemdata = $item->get_data(); $product =  wc_get_product( $itemdata['product_id'] ); ?>
                        <?php
                            if($product->get_stock_status() == 'onbackorder' && get_field('estimated_delivery_date' , $itemdata['product_id'])){
                                $date = str_replace('/' , '-' , get_field('estimated_delivery_date' , $itemdata['product_id']));
                                $dates[] = strtotime($date);                            }
                        ?>
                        <div class="item">
                            <img src="<?=get_the_post_thumbnail_url($itemdata['product_id'])?>" alt="">
                            <div class="title">
                                <p><?=$product->get_title()?> x<?=$itemdata['quantity']?></p>
                                <?php if($product->get_stock_status() == 'onbackorder' && get_field('estimated_delivery_date' , $itemdata['product_id']) != ''){ ?>
                                    <p class="estimated-date">
                                        Estimated Dispatch Date:
                                        <?=get_field('estimated_delivery_date' , $itemdata['product_id'])?>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="totals">
                    <div class="total">
                        <div class="title"><p>Sub Total</p></div>
                        <div class="price"><p>£<?=number_format($totals['subtotal'] , 2)?></p></div>
                    </div>
                    <div class="total">
                        <div class="title"><p>Delivery</p></div>
                        <div class="price"><p>£<?=number_format($totals['shipping_total'] , 2)?></p></div>
                    </div>
                    <div class="total">
                        <div class="title"><p>Tax</p></div>
                        <div class="price"><p>£<?=number_format($totals['subtotal_tax'] , 2)?></p></div>
                    </div>
                    <?php if($totals['fees'] != 0){ ?>
                        <?php
                            foreach($totals['fees'] as $fee){ $data =  $fee->get_data();
                                ?>

                                <div class="total">
                                    <div class="title"><p><?=$data['name']?></M></p></div>
                                    <div class="price"><p>£<?=number_format($data['amount']+$data['total_tax'] , 2)?></p></div>
                                </div>

                                <?php
                            }
                        ?>
                    <?php } ?>
                    <div class="total">
                        <div class="title"><p>Total</p></div>
                        <div class="price"><p>£<?=number_format($totals['total'] , 2)?></p></div>
                    </div>
                </div>
                <?php
                if(!empty($dates)){
                $date = max($dates);
                $dateFormat = date('F d, Y' , $date);
                echo '<p class="cart-delivery-date">Based on the products that are in your basket, the estimated dispatch date for your order is:<br/>'.$dateFormat.'</p>';
                }
                ?>
            </div>
        </div>

    </div>

</div>