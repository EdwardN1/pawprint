<?php
// Before content
//add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
//add_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
//add_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

add_action('woocommerce_before_single_product_summary' , 'badges_actions' , 30);

function badges_actions(){

    if(has_term('badges' , 'product_cat' , get_queried_object_id())){

        $pdfId = get_field('challenge_pack_pdf' , get_queried_object_id());

        ?>

        <div class="badge-actions">
            <?php if($pdfId){ ?><a href="<?=$pdfId['url']?>" class="pink">Download challenge pack</a><?php } ?>
            <a target="_self" href="<?=get_site_url()?>/activities/?activity-filter=on&_badge=<?=get_queried_object_id()?>&more_filters=show" class="blue">Find related activities</a>
            <a target="_self" href="<?=get_site_url()?>/product-category/free-resources/?orderby=date&badge_id=<?=get_queried_object_id()?>" class="yellow">Show related resources</a>
        </div>

        <?php

    }

    if(has_term('free-resources' , 'product_cat' , get_queried_object_id())){

        $badge = get_field('badge' , get_queried_object_id());

        ?>

        <div class="badge-actions">
            <a href="<?=get_permalink($badge->ID)?>" class="pink">Purchase the badge</a>
            <a target="_self" href="<?=get_site_url()?>/activities/?activity-filter=on&_badge=<?=$badge->ID?>&more_filters=show" class="blue">Find related activities</a>
            <a target="_self" href="<?=get_site_url()?>/product-category/free-resources/?orderby=date&badge_id=<?=$badge->ID?>" class="yellow">Show related resources</a>
        </div>

        <?php

    }

}

// Left column
//add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
//add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
//add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

// Right column
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action('woocommerce_single_product_summary' , 'woocommerce_template_single_excerpt' , 20);

add_action('woocommerce_single_product_summary' , 'woocommerce_template_single_excerpt' , 40);
add_action('woocommerce_single_product_summary' , 'product_description' , 40);

function product_description(){

    ?>

    <div class="description" style="display: none">
        <p><?=the_content()?></p>
    </div>
    <?php if(get_the_content(get_queried_object_id()) != ''){ ?>
        <p><a href="javsscript:void(0);" style="margin-top: 10px; display: block" class="product_read_more">Read More</a></p>
    <?php } ?>
    <?php

}

add_action('woocommerce_single_product_summary' , 'ppf_badge_charity_information' , 50);

function ppf_badge_charity_information(){

    $charity_info = get_field('charity_information' , get_queried_object_id());

    if($charity_info){

        echo '<div class="charity_information">';

        foreach ($charity_info as $item){
            echo '<div class="item">';
            echo '<img src="'.$item['charity_icon']['url'].'">';
            echo '<p>'.$item['description'].'</p>';
            echo '</div>';
        }

        echo '</div>';

    }

}

add_action('custom_woocommerce_single_product_summary' , 'custom_woocommerce_single_product_summary');
add_action('custom_woocommerce_single_product_summary' , 'woocommerce_template_single_title' , 10);
add_action('custom_woocommerce_single_product_summary' , 'custom_woocommerce_single_product_summary_free' , 20);
add_action('custom_woocommerce_single_product_summary' , 'custom_woocommerce_single_product_summary_purchase' , 30);
add_action('custom_woocommerce_single_product_summary' , 'woocommerce_template_single_add_to_cart' , 40);
add_action('custom_woocommerce_single_product_summary' , 'woocommerce_template_single_excerpt' , 50);

function custom_woocommerce_single_product_summary(){
}

function custom_woocommerce_single_product_summary_free(){
    global $product;
    $downloads = $product->get_files();
    $files = array();

    foreach ($downloads as $download){
        $files[] = $download["file"];
    }

    echo '<p><strong>Download a free copy of this resource</strong></p>';

    echo '<div class="challenge_pack_download_actions">';

    if(count($files) == 2){

        if(has_term( array('challenge-packs'), 'product_cat', $product->get_id() )){

            echo '<a href="'.$files[0].'">Download Challenge Pack</a>';
            echo '<a href="'.$files[1].'">Printer Friendly Version</a>';

        }else{

            echo '<a href="'.$files[0].'">Download Free Resource</a>';
            echo '<a href="'.$files[1].'">Printer Friendly Version</a>';

        }


    }else{

        if(has_term( array('challenge-packs'), 'product_cat', $product->get_id() )){

            echo '<a href="'.$files[0].'">Download Challenge Pack</a>';

        }else{

            echo '<a href="'.$files[0].'">Download Free Resource</a>';

        }

    }

    echo '</div>';

}

function custom_woocommerce_single_product_summary_purchase(){
    global $product;
    if(has_term( array('challenge-packs'), 'product_cat', $product->get_id() ) && $product->get_regular_price() != '') {
        echo '<div class="or_line"><p>or</p></div>';
        echo '<p><strong>Purchase an A4 printed copy of this Challenge Pack for £' . $product->get_regular_price() . '</strong></p>';
    }

}

// Right column - add to cart
//do_action( 'woocommerce_before_add_to_cart_form' );
//do_action( 'woocommerce_before_add_to_cart_button' );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

//add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
//add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
//add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
//add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
//add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
//add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
//do_action( 'woocommerce_before_quantity_input_field' );
//do_action( 'woocommerce_after_quantity_input_field' );
//do_action( 'woocommerce_after_add_to_cart_button' );
//do_action( 'woocommerce_after_add_to_cart_form' );

// Right column - meta
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//do_action( 'woocommerce_product_meta_start' );
//do_action( 'woocommerce_product_meta_end' );

// Right column - sharing
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
//do_action( 'woocommerce_share' );

// Tabs, upsells and related products
remove_action('woocommerce_after_single_product_summary' , 'woocommerce_output_product_data_tabs' , 10);
//add_action( 'woocommerce_product_additional_information', 'wc_display_product_attributes', 10 );
//do_action( 'woocommerce_product_after_tabs' );
//add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
//add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


// Reviews
//add_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
//add_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );
//add_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
//do_action( 'woocommerce_review_before_comment_text', $comment );
//add_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );
//do_action( 'woocommerce_review_after_comment_text', $comment );

// After content
//do_action( 'woocommerce_after_single_product' );
//do_action( 'woocommerce_after_main_content' );