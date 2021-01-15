<?php

    /**
     *
     * Plugin Name: PawPrintBadges Inlife Customisation
     * Version: 1.0
     *
     */

    define('PIC_INC_DIR' , plugin_dir_path(__FILE__).'/includes/');
    define('PIC_INC_URL' , plugin_dir_url(__FILE__).'/includes/');

    define('PIC_ASSETS_DIR' , plugin_dir_path(__FILE__).'/assets/');
    define('PIC_ASSETS_URL' , plugin_dir_url(__FILE__).'/assets/');

    include PIC_INC_DIR.'/pic.product-metabox.php';
    include PIC_INC_DIR.'/pic.styles-scripts.php';
    include PIC_INC_DIR.'/pic.save-product.php';

    add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);

    function wcs_custom_get_availability( $availability, $_product ) {

        global $wp;
        $currentUrl = home_url( $wp->request );

        $stock_quantity = $_product->get_stock_quantity();
        $backorder = $_product->backorders_allowed();

        if(get_field('estimated_delivery_date' , $_product->get_id())){
            //$delivery_date = date('d/m/Y' , strtotime(get_field('estimated_delivery_date' , $_product->get_id())));
            $delivery_date = get_field('estimated_delivery_date' , $_product->get_id());
        }else{
            $delivery_date = 'Unknown';
        }

        if($backorder){

            if($stock_quantity < 1){

                if(get_post_meta($_product->get_id() , '_ywpo_preorder' , true) == 'yes'){
                    $availability['class'] = 'out-of-stock';
                    $availability['availability'] = 'Pre Order';
                }else{
                    $availability['class'] = 'out-of-stock';
                    $availability['availability'] = 'Out of stock';
                }

                if( !strpos($currentUrl , 'product-category') && !isset($_GET['s']) && get_queried_object_id() == $_product->get_id()){
                    $availability['availability'] .= '<br/>Next Delivery: '.$delivery_date;
                    $availability['availability'] .= '<br/>Order with this product may not be shipped until the date shown.<br/><br/>';
                }

            }elseif($stock_quantity < 99 && $stock_quantity > 0){

                $availability['class'] = 'low-stock';
                $availability['availability'] = 'Low stock: '.$stock_quantity;

                if( !strpos($currentUrl , 'product-category') && !isset($_GET['s']) && get_queried_object_id() == $_product->get_id()){
                    $availability['availability'] .= '<br/>Next Delivery: '.$delivery_date;
                    $availability['availability'] .= '<br/>Order with this product may not be shipped until the date shown.<br/><br/>';
                }

            }elseif($stock_quantity > 99){

                $availability['class'] = 'in-stock';
                $availability['availability'] = 'In stock';

            }

        }else{

            if($stock_quantity < 1){

                if(get_post_meta($_product->get_id() , '_ywpo_preorder' , true) == 'yes'){
                    $availability['class'] = 'out-of-stock';
                    $availability['availability'] = 'Pre Order';
                }else{
                    $availability['class'] = 'out-of-stock';
                    $availability['availability'] = 'Out of stock';
                }

            }elseif($stock_quantity < 99 && $stock_quantity > 0){

                $availability['class'] = 'low-stock';
                $availability['availability'] = 'Low stock: '.$stock_quantity;

            }elseif($stock_quantity > 99){
                $availability['class'] = 'in-stock';
                $availability['availability'] = 'In stock';
            }else{
                $availability['class'] = 'out-of-stock';
                $availability['availability'] = 'Pre order';
            }

        }

        global $product;

        if(!$product->is_downloadable('yes') && $product->get_regular_price() != ''){
            return $availability;
        }

    }

    add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_show_stock_shop', 10 );

    function bbloomer_show_stock_shop() {
        global $product;
        echo wc_get_stock_html( $product );
    }

?>