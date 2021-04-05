<?php

/**
 *
 * Plugin Name: PPF Invoice PDF
 * Author: inLIFE Design LTD
 * Author URI: https://www.inlife.co.uk/
 * Version: 1.0
 *
 */

include 'library/vendor/autoload.php';

use Mpdf\Mpdf;

add_action('add_meta_boxes' , 'add_order_pdf_button');
add_action('init' , 'order_pdf_export_function');

function add_order_pdf_button(){

    add_meta_box(
        'invoice-pdf',
        'Invoice PDF',
        'add_order_pdf_button_html',
        'shop_order',
        'side',
        'default'
    );

}

function add_order_pdf_button_html(){
    ?>
    <a href="<?=get_admin_url()?>?action=order-pdf&order_id=<?=$_GET['post']?>" target="_blank" class="button button-primary">Download Invoice PDF</a>
    <?php
}

function order_pdf_export_function(){

    if(isset($_GET['action']) && $_GET['action'] == 'order-pdf'){

        $order = wc_get_order($_GET['order_id']);
        $billing = array(
            'name' => $order->get_formatted_billing_full_name(),
            'company' => $order->get_billing_company(),
            'line_1' => $order->get_billing_address_1(),
            'line_2' => $order->get_billing_address_2(),
            'postcode' => $order->get_billing_postcode(),
            'city' => $order->get_billing_city(),
            'county' => $order->get_billing_state(),
            'country' => $order->get_billing_country(),
            'phone' => $order->get_billing_phone(),
        );
        $shipping = array(
            'name' => $order->get_formatted_shipping_full_name(),
            'company' => $order->get_shipping_company(),
            'line_1' => $order->get_shipping_address_1(),
            'line_2' => $order->get_shipping_address_2(),
            'postcode' => $order->get_shipping_postcode(),
            'city' => $order->get_shipping_city(),
            'county' => $order->get_shipping_state(),
            'country' => $order->get_shipping_country(),
        );

        $orderItems = $order->get_items();

        $pdf = new Mpdf(
            [
                'mode' => 'utf-8',
                'format' => 'A4-P',
                'margin_header' => 0,
                'margin_footer' => 5,
                'margin_right' => 5,
                'margin_left' => 5,
                'setAutoTopMargin' => 'stretch',
                'setAutoBottomMargin' => 'stretch',
                'collapseBlockMargins' => false
            ]
        );

        $headerImage = plugin_dir_url(__FILE__).'/assets/images/header.jpg';
        $footerImage = plugin_dir_url(__FILE__).'/assets/images/footer.jpg';

        $orderStatus = $order->get_status();

        switch($orderStatus){
            case 'complete':
                $status_icon = plugin_dir_url(__FILE__).'/assets/images/complete.png';
                break;
            case 'processing':
                $status_icon = plugin_dir_url(__FILE__).'/assets/images/processing.png';
                break;
            case 'cancelled':
                $status_icon = plugin_dir_url(__FILE__).'/assets/images/cancelled.png';
                break;
            default:
                $status_icon = plugin_dir_url(__FILE__).'/assets/images/processing.png';
                break;
        }

        $topSection = '
            <table width="100%" style="border-top: 2px solid #172A53; border-bottom: 2px solid #172A53;" cellpadding="10" cellspacing="0">
                <tbody>
                    <tr>
                        <td valign="top">
                            <h5>Order Number:</h5>
                            <p>'.$order->get_order_number().'</p><br/>
                            <h5>Order Date:</h5>
                            <p>'.date('jS F Y' , strtotime($order->get_date_created(''))).'</p><br/>
                            <h5>Order Type:</h5>
                            <p><img src="'.base64encode_image_2($status_icon).'" width="10px"> '.$order->get_payment_method_title().'</p><br/>
                            <h5>Email Address:</h5>
                            <p>'.$order->get_billing_email().'</p>
                        </td>
                        <td valign="top">
                            <h5>Shipping Details</h5>
                            <p>'.$shipping['name'].'</p>
                            <p>'.$shipping['company'].'</p>
                            <p>'.$shipping['line_1'].'</p>
                            <p>'.$shipping['line_2'].'</p>
                            <p>'.$shipping['city'].'</p>
                            <p>'.$shipping['county'].'</p>
                            <p>'.$shipping['country'].'</p>
                            <p>'.$shipping['postcode'].'</p><br/>
                            <p>'.$billing['phone'].'</p>
                        </td>
                        <td valign="top">
                            <h5>Billing Details</h5>
                            <p>'.$billing['name'].'</p>
                            <p>'.$billing['company'].'</p>
                            <p>'.$billing['line_1'].'</p>
                            <p>'.$billing['line_2'].'</p>
                            <p>'.$billing['city'].'</p>
                            <p>'.$billing['county'].'</p>
                            <p>'.$billing['country'].'</p>
                            <p>'.$billing['postcode'].'</p><br/>
                            <p>'.$billing['phone'].'</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';

        $orderItemsTable = '
            <table cellpadding="10" cellspacing="0" width="100%" class="orderItems">
                <thead>
                    <tr>
                        <th align="left" colspan="2" width="140mm"><strong>Product</strong></th>
                        <th align="center"><strong>Price</strong></th>
                        <th align="center"><strong>QTY</strong></th>
                        <th align="center"><strong>Total</strong></th>
                        <th align="center"><strong>VAT</strong></th>
                    </tr>
                </thead>
                <tbody>';


        $dates = array();

        foreach($orderItems as $item){

            $itemData = $item->get_data();

            $orderItemsTable .= '<tr>
                                    <td width="6mm">
                                        <img src="'.get_the_post_thumbnail_url($itemData['product_id'] , 'thumbnail').'" width="6mm" height="auto" style="display: inline-block" alt="">
                                    </td>
                                    <td width="128mm">
                                        <p style="display: inline-block; font-size: 12px;">'.get_the_title($itemData['product_id']).'</p>';

            $_product =  wc_get_product( $itemData['product_id'] );
            if($item->get_meta('Estimated Dispatch Date')){
                $orderItemsTable .= '<p style="color: red; font-size: 12px;">Estimated Dispatch Date: '.$item->get_meta('Estimated Dispatch Date').'</p>';
                $date = str_replace('/' , '-' , $item->get_meta('Estimated Dispatch Date'));
                $dates[] = strtotime($date);
            }

            $orderItemsTable .= '</td>
                                    <td align="center"><p>£'.number_format($itemData['subtotal']/$itemData['quantity'] , 2).'</p></td>
                                    <td align="center"><p>'.$itemData['quantity'].'</p></td>
                                    <td align="center"><p>£'.number_format(($itemData['subtotal']) , 2).'</p></td>
                                    <td align="center"><p>£'.round($itemData['subtotal_tax'] , 2).'</p></td>
                                </tr>';

        }

        $orderItemsTable .= '</tbody></table>';

        $discounttable = '';

        if($order->get_fees()){
            foreach($order->get_fees() as $fee){

                $data =  $fee->get_data();
                $discounttable .= '<tr>
                                    <th align="right"><strong>'.$data['name'].'</strong></th>
                                    <td align="right"><p>£'.number_format($data['amount']+$data['total_tax'] , 2).'</p></td>
                                </tr>';
            }
        }

        $totalstable = '
            <table>
                <tbody>
                    <tr>
                        <td width="140mm"></td>
                        <td width="80mm">
                            <table width="100%" class="totalsTable" cellspacing="0" cellpadding="10">
                                <tbody>
                                    <tr>
                                        <th align="right"><strong>Sub Total (inc. VAT)</strong></th>
                                        <td align="right"><p>'.$order->get_subtotal_to_display().'</p></td>
                                    </tr>
                                    <tr>
                                        <th align="right"><strong>Delivery (inc. VAT)</strong></th>
                                        <td align="right"><p>£'.number_format(($order->get_shipping_total()+ $order->get_shipping_tax()), 2).'</p></td>
                                    </tr>
                                    <!--<tr>
                                        <th align="right"><strong>Total VAT</strong></th>
                                        <td align="right"><p>£'.number_format(($order->get_shipping_tax() + $order->get_cart_tax()) , 2).'</p></td>
                                    </tr>
                                    <tr>
                                        <th align="right"><strong>Cart VAT</strong></th>
                                        <td align="right"><p>£'.number_format(($order->get_cart_tax()) , 2).'</p></td>
                                    </tr>
                                    <tr>
                                        <th align="right"><strong>Shipping VAT</strong></th>
                                        <td align="right"><p>£'.number_format(($order->get_shipping_tax()) , 2).'</p></td>
                                    </tr>-->
                                    '.$discounttable.'
                                    <tr>
                                        <th align="right"><strong>Total (VAT)</strong></th>
                                        <td align="right"><p>£'.$order->get_total().' (£'.number_format(($order->get_shipping_tax() + $order->get_cart_tax()) , 2).')</p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';

        $head_css = "
            <style>
                h5{ font-family: 'Helvetica'; color: #172A53; margin-bottom: 10px; }
                p{ font-family: 'Helvetica'; font-size: 12px; color: #172A53; }
                strong{ font-family: 'Helvetica'; font-size: 12px; color: #172A53; }
                table.orderItems tbody tr:nth-child(1) td{ border-top: 2px solid #172A53 !important; }
                table.orderItems tbody tr td{ border-bottom: 1px solid #172A53 !important; }
                table.totalsTable tbody tr td,
                table.totalsTable tbody tr th{ border-bottom: 1px solid #172A53 !important; }
                table,
                td,
                th{
                    font-family: 'Helvetica';
                }
            </style>
        ";

        $pdf->SetCompression(true);

        $pdf->SetHTMLHeader('<img src="'.$headerImage.'">'); // Set the header image for the pdf
        $pdf->SetHTMLFooter('<img src="'.$footerImage.'">'); // Set the footer image for the pdf
        $pdf->WriteHTML($head_css);
        $pdf->WriteHTML($topSection);
        $pdf->WriteHTML($orderItemsTable);
        $pdf->WriteHTML($totalstable);
        $pdf->Output('order-'.$order->get_order_number().'-invoice.pdf', 'I');

        exit();

    }

}

function base64encode_image_2($img){

    $img_file = $img;
    $imgData = base64_encode(file_get_contents($img_file));

    $file_info = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $file_info->buffer(file_get_contents($img_file));

    $src = 'data: '.$mime_type.';base64,'.$imgData;

    return $src;

}

add_filter( 'bulk_actions-edit-shop_order', 'invoice_bulk_actions_edit_product', 20, 1 );

function invoice_bulk_actions_edit_product( $actions ) {
    $actions['export_invoices'] = __( 'Bulk Export Invoices', 'woocommerce' );
    return $actions;
}

add_filter( 'handle_bulk_actions-edit-shop_order', 'invoice_handle_bulk_action_edit_shop_order', 10, 3 );

function invoice_handle_bulk_action_edit_shop_order($redirect_to, $action, $post_ids){

    if ( $action !== 'export_invoices' )
        return $redirect_to; // Exit

    // Loop through order ids

    $pdf = new Mpdf(
        [
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'margin_header' => 0,
            'margin_footer' => 5,
            'margin_right' => 5,
            'margin_left' => 5,
            'setAutoTopMargin' => 'stretch',
            'setAutoBottomMargin' => 'stretch',
            'collapseBlockMargins' => false
        ]
    );

    $headerImage = plugin_dir_url(__FILE__).'/assets/images/header.jpg'; // Header image
    $footerImage = plugin_dir_url(__FILE__).'/assets/images/footer.jpg'; // Footer image

    $head_css = "
        <style>
            h5{ font-family: 'Helvetica'; color: #172A53; margin-bottom: 10px; }
            p{ font-family: 'Helvetica'; font-size: 12px; color: #172A53; }
            strong{ font-family: 'Helvetica'; font-size: 12px; color: #172A53; }
            table.orderItems tbody tr:nth-child(1) td{ border-top: 2px solid #172A53 !important; }
            table.orderItems tbody tr td{ border-bottom: 1px solid #172A53 !important; }
            table.totalsTable tbody tr td,
            table.totalsTable tbody tr th{ border-bottom: 1px solid #172A53 !important; }
            table,
            td,
            th{
                font-family: 'Helvetica';
            }
        </style>
    "; // Head css

    $pdf->SetCompression(true);

    $pdf->SetHTMLHeader('<img src="'.$headerImage.'">'); // Set the header image for the pdf
    $pdf->SetHTMLFooter('<img src="'.$footerImage.'">'); // Set the footer image for the pdf
    $pdf->WriteHTML($head_css);

    $i = 0;

    foreach ($post_ids as $post_id){

        $i++;

        $order = wc_get_order($post_id); // Get the order details

        $orderStatus = $order->get_status(); // Get the order status

        $orderItems = $order->get_items(); // Get order items

        $billing = array(
            'name' => $order->get_formatted_billing_full_name(),
            'line_1' => $order->get_billing_address_1(),
            'line_2' => $order->get_billing_address_2(),
            'postcode' => $order->get_billing_postcode(),
            'city' => $order->get_billing_city(),
            'county' => $order->get_billing_state(),
            'country' => $order->get_billing_country(),
            'phone' => $order->get_billing_phone(),
        ); // Set the billing address information

        $shipping = array(
            'name' => $order->get_formatted_shipping_full_name(),
            'line_1' => $order->get_shipping_address_1(),
            'line_2' => $order->get_shipping_address_2(),
            'postcode' => $order->get_shipping_postcode(),
            'city' => $order->get_shipping_city(),
            'county' => $order->get_shipping_state(),
            'country' => $order->get_shipping_country(),
        ); // Set the shipping address information

        // Create the orders top section

        switch($orderStatus){
            case 'complete':
                $status_icon = plugin_dir_url(__FILE__).'/assets/images/complete.png';
                break;
            case 'processing':
                $status_icon = plugin_dir_url(__FILE__).'/assets/images/processing.png';
                break;
            case 'cancelled':
                $status_icon = plugin_dir_url(__FILE__).'/assets/images/cancelled.png';
                break;
            default:
                $status_icon = plugin_dir_url(__FILE__).'/assets/images/processing.png';
                break;
        }

        $topSection = '
            <table width="100%" style="border-top: 2px solid #172A53; border-bottom: 2px solid #172A53;" cellpadding="10" cellspacing="0">
                <tbody>
                    <tr>
                        <td valign="top">
                            <h5>Order Number:</h5>
                            <p>'.$order->get_order_number().'</p><br/>
                            <h5>Order Date:</h5>
                            <p>'.date('jS F Y' , strtotime($order->get_date_created(''))).'</p><br/>
                            <h5>Order Type:</h5>
                            <p><img src="'.base64encode_image_2($status_icon).'" width="10px"> '.$order->get_payment_method_title().'</p><br/>
                            <h5>Email Address:</h5>
                            <p>'.$order->get_billing_email().'</p>
                        </td>
                        <td valign="top">
                            <h5>Shipping Details</h5>
                            <p>'.$shipping['name'].'</p>
                            <p>'.$shipping['line_1'].'</p>
                            <p>'.$shipping['line_2'].'</p>
                            <p>'.$shipping['city'].'</p>
                            <p>'.$shipping['county'].'</p>
                            <p>'.$shipping['country'].'</p>
                            <p>'.$shipping['postcode'].'</p><br/>
                            <p>'.$billing['phone'].'</p>
                        </td>
                        <td valign="top">
                            <h5>Billing Details</h5>
                            <p>'.$billing['name'].'</p>
                            <p>'.$billing['line_1'].'</p>
                            <p>'.$billing['line_2'].'</p>
                            <p>'.$billing['city'].'</p>
                            <p>'.$billing['county'].'</p>
                            <p>'.$billing['country'].'</p>
                            <p>'.$billing['postcode'].'</p><br/>
                            <p>'.$billing['phone'].'</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';

        // Create order items table

        $orderItemsTable = '
            <table cellpadding="10" cellspacing="0" width="100%" class="orderItems">
                <thead>
                    <tr>
                        <th align="left" colspan="2" width="140mm"><strong>Product</strong></th>
                        <th align="center"><strong>Price</strong></th>
                        <th align="center"><strong>QTY</strong></th>
                        <th align="center"><strong>Total</strong></th>
                        <th align="center"><strong>VAT</strong></th>
                    </tr>
                </thead>
                <tbody>';


        $dates = array();

        foreach($orderItems as $item){

            $itemData = $item->get_data();

            $orderItemsTable .= '<tr>
                                    <td width="6mm">
                                        <img src="'.get_the_post_thumbnail_url($itemData['product_id'] , 'thumbnail').'" width="6mm" height="auto" style="display: inline-block" alt="">
                                    </td>
                                    <td width="128mm">
                                        <p style="display: inline-block; font-size: 12px;">'.get_the_title($itemData['product_id']).'</p>';

            $_product =  wc_get_product( $itemData['product_id'] );
            if($item->get_meta('Estimated Dispatch Date')){
                $orderItemsTable .= '<p style="color: red; font-size: 12px;">Estimated Dispatch Date: '.$item->get_meta('Estimated Dispatch Date').'</p>';
                $date = str_replace('/' , '-' , $item->get_meta('Estimated Dispatch Date'));
                $dates[] = strtotime($date);
            }

            $orderItemsTable .= '</td>
                                    <td align="center"><p>£'.number_format($itemData['subtotal']/$itemData['quantity'] , 2).'</p></td>
                                    <td align="center"><p>'.$itemData['quantity'].'</p></td>
                                    <td align="center"><p>£'.number_format(($itemData['subtotal']) , 2).'</p></td>
                                    <td align="center"><p>£'.round($itemData['subtotal_tax'] , 2).'</p></td>
                                </tr>';

        }

        $orderItemsTable .= '</tbody></table>';

        $discounttable = '';

        if($order->get_fees()){
            foreach($order->get_fees() as $fee){

                $data =  $fee->get_data();
                $discounttable .= '<tr>
                                    <th align="right"><strong>'.$data['name'].'</strong></th>
                                    <td align="right"><p>£'.number_format($data['amount']+$data['total_tax'] , 2).'</p></td>
                                </tr>';
            }
        }

        // Totals table

        $totalstable = '
            <table>
                <tbody>
                    <tr>
                        <td width="140mm"></td>
                        <td width="80mm">
                            <table width="100%" class="totalsTable" cellspacing="0" cellpadding="10">
                                <tbody>
                                    <tr>
                                        <th align="right"><strong>Sub Total</strong></th>
                                        <td align="right"><p>'.$order->get_subtotal_to_display().'</p></td>
                                    </tr>
                                    <tr>
                                        <th align="right"><strong>Delivery</strong></th>
                                        <td align="right"><p>£'.$order->get_shipping_total().'</p></td>
                                    </tr>
                                    <tr>
                                        <th align="right"><strong>VAT</strong></th>
                                        <td align="right"><p>£'.number_format(($order->get_shipping_tax() + $order->get_cart_tax()) , 2).'</p></td>
                                    </tr>
                                    '.$discounttable.'
                                    <tr>
                                        <th align="right"><strong>Total</strong></th>
                                        <td align="right"><p>£'.$order->get_total().'</p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';

        $pdf->WriteHTML($topSection);
        $pdf->WriteHTML($orderItemsTable);
        $pdf->WriteHTML($totalstable);
        if($i != count($post_ids)){
            $pdf->AddPage();
        }

    }

    $pdf->Output('order-bulk-export-invoice-'.date('dmy').'.pdf', 'D');

}