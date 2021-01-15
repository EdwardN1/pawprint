<?php

/**
 *
 * Plugin Name: Pawprint Order Import
 * Author: inLIFE Design LTD
 * Author URI: https://www.inlife.co.uk/
 * Version: 1.0
 *
 */

add_action('admin_menu' , 'pp_order_import_page');

function pp_order_import_page(){

    add_submenu_page(
        'woocommerce',
        'Order Import',
        'Order Import',
        'manage_options',
        'order-import',
        'pp_order_import_page_html'
    );

}

function pp_order_import_page_html(){

    if(isset($_POST['_import_orders'])){

        $orders = array();
        $ordersSorted = array();

        $csv = array_map('str_getcsv', file($_FILES['csv']['tmp_name']));
        $csvheaders = $csv[0];

        $csvMapped = array();

        $i = 0;
        foreach ($csv as $key1 => $item) {
            $i++;
            $csv[$key1] = array();
            foreach ($item as $key => $value){
                $csv[$key1][$csvheaders[$key]] = $value;
            }
            array_push($csvMapped , $csv[$key1]);
        }

        $i = 0;
        foreach($csv as $row){
            $i++;
            if($i > 1){
                $orders[$row['OrderNumber']][] = $row;
            }
        }


        foreach ($orders as $key => $orders){

            $ordersSorted[$key] = array();

            $o = 0;
            foreach ($orders as $order){

                $o++;
                if($o == 1){

                    $ordersSorted[$key]['details'] = array(
                        'OrderNumber' => $key,
                        'OrderDate' => $row['OrderDate'],
                        'SubTotal' => $order['SubTotal'],
                        'TotalCost' => $order['TotalCost'],
                        'BillingEmailAddress' => $order['BillingEmailAddress'],
                        'BillingFirstName' => $order['BillingFirstName'],
                        'BillingLastName' => $order['BillingLastName'],
                        'BillingCompanyName' => $order['BillingCompanyName'],
                        'BillingAddress1' => $order['BillingAddress1'],
                        'BillingAddress2' => $order['BillingAddress2'],
                        'BillingTown' => $order['BillingTown'],
                        'BillingCounty' => $order['BillingCounty'],
                        'BillingCountry' => $order['BillingCountry'],
                        'BillingPostCode' => $order['BillingPostCode'],
                        'BillingTelephone' => $order['BillingTelephone'],
                        'ShippingEmailAddress' => $order['ShippingEmailAddress'],
                        'ShippingFirstName' => $order['ShippingFirstName'],
                        'ShippingLastName' => $order['ShippingLastName'],
                        'ShippingCompanyName' => $order['ShippingCompanyName'],
                        'ShippingAddress1' => $order['ShippingAddress1'],
                        'ShippingAddress2' => $order['ShippingAddress2'],
                        'ShippingTown' => $order['ShippingTown'],
                        'ShippingCounty' => $order['ShippingCounty'],
                        'ShippingCountry' => $order['ShippingCountry'],
                        'ShippingPostCode' => $order['ShippingPostCode'],
                        'ShippingTelephone' => $order['ShippingTelephone']
                    );
                }

                if($order['ProductName'] != ''){

                    $product = get_page_by_path(sanitize_title($order['ProductName']) , OBJECT , 'product');

                    $ordersSorted[$key]['items'][] = array(
                        'ProductId' => $product->ID,
                        'ProductName' => $order['ProductName'],
                        'ProductPrice' => $order['ProductPrice'],
                        'ProductDiscount' => $order['ProductDiscount'],
                        'ProductDelivery' => $order['ProductDelivery'],
                        'ProductQuantity' => $order['ProductQuantity']
                    );

                }

            }

        }


        foreach($ordersSorted as $value){

            $bAddress = array(
                'first_name' => $value['details']['BillingFirstName'],
                'last_name'  => $value['details']['BillingLastName'],
                'company'    => $value['details']['BillingCompanyName'],
                'email'      => $value['details']['BillingEmailAddress'],
                'phone'      => $value['details']['BillingTelephone'],
                'address_1'  => $value['details']['BillingAddress2'],
                'address_2'  => $value['details']['BillingAddress1'],
                'city'       => $value['details']['BillingTown'],
                'state'      => $value['details']['BillingCounty'],
                'postcode'   => $value['details']['BillingCountry'],
                'country'    => $value['details']['BillingPostCode'],
            );

            $sAddress = array(
                'first_name' => $value['details']['ShippingFirstName'],
                'last_name'  => $value['details']['ShippingLastName'],
                'company'    => $value['details']['ShippingCompanyName'],
                'email'      => $value['details']['ShippingEmailAddress'],
                'phone'      => $value['details']['ShippingTelephone'],
                'address_1'  => $value['details']['ShippingAddress2'],
                'address_2'  => $value['details']['ShippingAddress1'],
                'city'       => $value['details']['ShippingTown'],
                'state'      => $value['details']['ShippingCounty'],
                'postcode'   => $value['details']['ShippingCountry'],
                'country'    => $value['details']['ShippingPostCode'],
            );

            $order = wc_create_order();

            foreach($value['items'] as $item){
                $order->add_product( wc_get_product( $item['ProductId'] ), $item['ProductQuantity'] );
            }

            $order->set_address( $sAddress, 'shipping' );
            $order->set_address( $bAddress, 'billing' );

            $order->set_status('completed' , 'Imported order' , true);

            $order->calculate_totals();

            if($order){

                $current_order_number = get_post_meta($order->get_id() , '_order_number' , true);
                $new_order_number = $current_order_number.' ('.$value['details']['OrderNumber'].')';

                update_post_meta($order->get_id() , '_order_number' , $new_order_number);

            }

        }

    }

    ?>

    <div class="wrap">

        <h1 class="wp-heading-inline">Order Import</h1>

        <div class="card">
            <h2>Select your order csv to import</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="csv" class="form-field">
                <br>
                <button type="submit" name="_import_orders" class="button button-primary">Import</button>
            </form>
        </div>

    </div>

    <?php

}