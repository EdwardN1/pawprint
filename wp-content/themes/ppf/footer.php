<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pawprint_Family
 */

?>

	</div><!-- #content -->

    <div class="page-banner banner_part_2"></div>
    <div class="footer-top-part">
        <div class="left">
            <div class="block <?=(get_queried_object_id() == 7441 || get_queried_object_id() == 13175) ? 'badges-block' : ''?>">
                <div class="content">
                    <?php
                        if(get_queried_object_id() != 7441 && get_queried_object_id() != 13175){
                            dynamic_sidebar('footer-trust-block');
                            ?>
                            <a href="/pawprint-trust/" class="pp-btn navy">Find out more</a>
                            <?php
                        }else{
                            dynamic_sidebar('footer-badges-block');
                            ?>
                            <a href="/product-category/badges/" class="pp-btn pink">Find out more</a>
                            <?php
                        }
                    ?>
                </div>
                <div class="map-block"></div>
            </div>
            <div class="block">
                <div class="left">
                    <h2>What our<br/><?=(get_queried_object_id() != 7441) ? 'customers' : 'recipients'?> say...</h2>
                    <img src="<?=get_site_url()?>/wp-content/uploads/2020/02/pawprint-icon.png" alt="">
                </div>
                <div class="right">
                    <?php
                        if(get_queried_object_id() != 7441) {
                            $testimonials = new WP_Query(
                                array(
                                    'post_type' => 'testimonial',
                                    'posts_per_page' => 1,
                                    'orderby' => 'rand',
                                    'order' => 'desc',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'trust',
                                            'compare' => '!=',
                                            'value' => 1
                                        )
                                    )
                                )
                            );
                        }else{
                            $testimonials = new WP_Query(
                                array(
                                    'post_type' => 'testimonial',
                                    'posts_per_page' => 1,
                                    'orderby' => 'rand',
                                    'order' => 'desc',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'trust',
                                            'compare' => '=',
                                            'value' => 1
                                        )
                                    )
                                )
                            );
                        }

                        if($testimonials->have_posts()){
                            while ($testimonials->have_posts()){ $testimonials->the_post();
                                ?>
                                    <div class="testimonials">
                                        <p class="content"><?=strip_tags(get_the_content($testimonials->post->ID))?></p>
                                        <hr>
                                        <p><?=get_the_title($testimonials->post->ID)?></p>
                                    </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="block">
                <?php echo do_shortcode('[contact-form-7 id="7495" title="Subscribe Form"]') ?>
            </div>
        </div>
    </div>

	<footer>
        <div class="flex-grid nav-menus">
            <div class="col">
                <?php
                echo '<h4>'.wp_get_nav_menu_name('footer-1').'</h4>';
                pawp_footer_nav('footer-1');
                ?>
            </div>
            <div class="col">
                <?php
                echo '<h4>'.wp_get_nav_menu_name('footer-2').'</h4>';
                pawp_footer_nav('footer-2');
                ?>
            </div>
            <div class="col">
                <?php
                echo '<h4>'.wp_get_nav_menu_name('footer-3').'</h4>';
                pawp_footer_nav('footer-3');
                ?>
            </div>
            <div class="col">
                <?php
                echo '<h4>'.wp_get_nav_menu_name('footer-4').'</h4>';
                pawp_footer_nav('footer-4');
                ?>
            </div>
        </div>
        <div class="copyright">
            <hr>
            <div class="flex-grid">
                <div class="col payment">
                    Payment methods:
                </div>
                <div class="col notice">
                    &copy; Pawprint Family <?php echo date( 'Y' ); ?>
                </div>
            </div>
        </div>

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
