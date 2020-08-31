<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$thisMonth = date('n');

$related_args = array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'post__not_in' => array(get_queried_object_id()),
    'orderby' => 'rand',
    'order' => 'ASC',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('badges')
        )
    )
);

$tribe_args = array(
    'post_type' => 'product',
    'posts_per_page' => 1,
    'orderby' => 'rand',
    's' => 'blanket',
    'order' => 'ASC',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('tribe-merchandise')
        )
    )
);

$related = new WP_Query($related_args);
$tribe = new WP_Query($tribe_args);

if ( $related ) : ?>

    <section class="related products">

        <?php
        $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

        if ( $heading ) :
            ?>
            <h2><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>

        <?php woocommerce_product_loop_start(); ?>

        <?php

            while ($tribe->have_posts()){ $tribe->the_post();

                $post_object = get_post( $tribe->post->ID );

                setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                wc_get_template_part( 'content', 'product' );

            }

            while ($related->have_posts()){ $related->the_post();

                $post_object = get_post( $related->post->ID );

                setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                wc_get_template_part( 'content', 'product' );

            }

        ?>

        <?php woocommerce_product_loop_end(); ?>

    </section>
<?php
endif;

wp_reset_postdata();
