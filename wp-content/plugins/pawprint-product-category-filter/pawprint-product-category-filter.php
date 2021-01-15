<?php

/**
 *
 * Plugin Name: Pawprint Product Category Filter
 * Author: inLIFE Design
 * Author URI: https://www.inlife.co.uk/
 * Version: 1.0
 *
 */

add_action('woocommerce_before_shop_loop' , 'pawprint_category_filter' , 50);

function pawprint_category_filter(){

    $cate = get_queried_object();
    $cateID = $cate->term_id;

    $sub_categories = get_terms(array('taxonomy' => 'product_cat' , 'parent' => $cateID));

    if(isset($_GET['product_category'])){
        $categories = explode(' ' , $_GET['product_category']);
    }

    if(!empty($sub_categories)){

        echo '<br clear="all">';
        echo '<a href="" class="filter_mobile_toggle">Show Filters</a>';
        echo '<div class="pawprint_category_filter_container">';

        foreach ($sub_categories as $category){

            $unchecked_image_id = get_term_meta($category->term_id , 'unchecked_image' , true);
            $checked_image_id = get_term_meta($category->term_id , 'checked_image' , true);

            $unchecked_image_url = wp_get_attachment_url($unchecked_image_id);
            $checked_image_url = wp_get_attachment_url($checked_image_id);

            if(isset($_GET['product_category'])){

                if(in_array($category->slug , $categories)){
                    echo '<label for="ppf_cat_'.$category->slug.'"><input value="'.$category->slug.'" id="ppf_cat_'.$category->slug.'" checked type="checkbox" name="product_category[]"><span><img src="'.$checked_image_url.'" alt=""></span><p>'.$category->name.'</p></label>';
                }else{
                    echo '<label for="ppf_cat_'.$category->slug.'"><input value="'.$category->slug.'" id="ppf_cat_'.$category->slug.'" type="checkbox" name="product_category[]"><span><img src="'.$unchecked_image_url.'" alt=""></span><p>'.$category->name.'</p></label>';
                }

            }else{
                echo '<label for="ppf_cat_'.$category->slug.'"><input value="'.$category->slug.'" id="ppf_cat_'.$category->slug.'" type="checkbox" name="product_category[]"><span><img src="'.$unchecked_image_url.'" alt=""></span><p>'.$category->name.'</p></label>';
            }

        }

        echo '</div>';

        ?>

        <script>

            $ = jQuery;

            $('input[name="product_category[]"]').click(function(){

                var categories = [];

                $.each($('input[name="product_category[]"]') , function(index,element){

                    if($(element).is(':checked')){
                        categories.push($(element).val());
                    }

                });

                var url_params = '';

                for(var i = 0; i < categories.length; i++){

                    if(i == 0){
                        url_params += '?product_category='+categories[i];
                    }else{
                        url_params += '+'+categories[i];
                    }

                }

                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + url_params;
                window.history.pushState({ path: newurl }, '', newurl);

                window.location.reload();

            });

        </script>

        <?php

    }

}

add_filter( 'woocommerce_shortcode_products_query', 'custom_shortcode_exclude_products', 50, 3 );
function custom_shortcode_exclude_products( $query_args, $atts, $loop_name ){

    if( is_product_category() && isset($_GET['product_category']) ){

        $query_args['tax_query'] = array( array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => explode(' ' , $_GET['product_category']),
        ));

    }

    return $query_args;

}
