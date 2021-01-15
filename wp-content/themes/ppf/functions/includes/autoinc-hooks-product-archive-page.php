<?php
//add_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
//add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

//add_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
//add_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );


add_action('woocommerce_before_shop_loop' , 'pawprint_category_content' , 5);

function pawprint_category_content(){

    $cat = '';

    if(is_product_category()){
        global $wp_query;
        $cat = $wp_query->get_queried_object()->slug;
    }

    $page = new WP_Query(
        array(
            'post_type' => 'page',
            'name' => $cat,
            'posts_per_page' => 1
        )
    );

    $content = $page->posts[0]->post_content;

    echo '<div class="product_category_banner">';
    WPBMap::addAllMappedShortcodes();
    echo apply_filters('the_content', $content);
    echo '</div>';

    $content_css = visual_composer()->parseShortcodesCustomCss( $content );

    ?>
    <style type="text/css" data-type="vc_shortcodes-custom-css">
        <?php echo strip_tags( $content_css ); ?>
    </style>
    <?php

}

//add_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop' , 'woocommerce_page_breadcrumbs', 20 );
//add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 40 );


function woocommerce_page_breadcrumbs(){
    echo do_shortcode('[vc_pawprint_breadcrumbs_block]');
}



//add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

//add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
//add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

//add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

//add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
//add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

//add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

//add_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );