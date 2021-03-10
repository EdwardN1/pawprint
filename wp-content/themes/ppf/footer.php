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
<div class="footer-top-part" style="display: none;">
    <div class="left">
        <div class="block <?= (get_queried_object_id() == 7441 || get_queried_object_id() == 13175) ? 'badges-block' : '' ?>">
            <div class="content">
                <?php
                if (get_queried_object_id() != 7441 && get_queried_object_id() != 13175) {
                    dynamic_sidebar('footer-trust-block');
                    ?>
                    <a href="/pawprint-trust/" class="pp-btn navy">Find out more</a>
                    <?php
                } else {
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
                <h2>What our<br/><?= (get_queried_object_id() != 7441) ? 'customers' : 'recipients' ?> say...</h2>
                <img src="<?= get_site_url() ?>/wp-content/uploads/2020/02/pawprint-icon.png" alt="">
            </div>
            <div class="right">
                <?php
                if (get_queried_object_id() != 7441) {
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
                } else {
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

                if ($testimonials->have_posts()) {
                    while ($testimonials->have_posts()) {
                        $testimonials->the_post();
                        ?>
                        <div class="testimonials">
                            <p class="content"><?= strip_tags(get_the_content($testimonials->post->ID)) ?></p>
                            <hr>
                            <p><?= get_the_title($testimonials->post->ID) ?></p>
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
<div class="grid-container-ppf">
    <div class="<?php if ((get_queried_object_id() == 7441 || get_queried_object_id() == 13175)) {
        echo 'primary-background';
    } else {
        echo 'trust-background';
    } ?>">
        <div class="content">
            <?php
            if (get_queried_object_id() != 7441 && get_queried_object_id() != 13175) {
                //dynamic_sidebar('footer-trust-block');
                ?>
                <div class="grid-x">
                    <div class="cell shrink pad-all-10">
                        <img class="wp-image-5396 aligncenter" src="https://pawprintfamily.com/wp-content/uploads/2020/02/Pawprint-Trust-300x129.png" alt="" width="300" height="129"/>
                    </div>
                    <div class="cell auto pad-all-10">
                        <p>
                            Do you have a project that needs some extra funds? A young person planning an international trip but stuck with their fundraising? Then we have the help that you need!
                        </p>
                        <p>
                            Do you have a project that needs some extra funds? A young person planning an international trip but stuck with their fundraising? Then we have the help that you need!
                        </p>
                    </div>
                    <div class="cell auto pad-all-10">
                        <p>
                            Do you have a project that needs some extra funds? A young person planning an international trip but stuck with their fundraising? Then we have the help that you need!
                        </p>

                        <p>
                            Click on the button below to find out how the Pawprint Trust can help you.
                            <a href="/pawprint-trust/" class="pp-btn navy">Find out more</a>
                        </p>

                    </div>
                </div>
                <!--<a href="/pawprint-trust/" class="pp-btn navy">Find out more</a>-->
                <?php
            } else {
                //dynamic_sidebar('footer-badges-block');
                ?>
                <div class="grid-x">
                    <div class="cell shrink pad-all-10">
                        <img class="wp-image-5396 aligncenter" src="https://pawprintfamily.com/wp-content/uploads/2020/03/Family-Brands-Image-1.png" alt="" width="506" height="170"/>
                    </div>
                    <div class="cell auto pad-all-10" style="padding-top: 20px; line-height:1.5;">
                        <p>
                            A percentage of profits from each sale goes into the Pawprint Trust. Find out more about the brands by clicking below.
                            <a href="/product-category/badges/" class="pp-btn pink">Find out more</a>
                        </p>
                    </div>

                </div>
<!--                <a href="/product-category/badges/" class="pp-btn pink">Find out more</a>-->
                <?php
            }
            ?>
        </div>
        <!--<div class="map-block"></div>-->
    </div>

</div>

<div class="ruler"></div>
<div class="grid-container-ppf">
    <div class="grid-x">
        <div class="cell large-6 medium-12 small-12 pad-all-10">
            <?php echo do_shortcode('[contact-form-7 id="19445" title="Subscribe Form"]') ?>
        </div>
        <div class="cell large-6 medium-12 small-12 pad-all-10 testimonials">
            <div class="grid-x">
                <div class="cell shrink" style="max-width: 200px;">
                    <h2 style="background-image: url(/wp-content/uploads/2020/02/pawprint-icon.png);">
                        What our<br/><?= (get_queried_object_id() != 7441) ? 'customers' : 'recipients' ?> say...
                    </h2>
                </div>
                <div class="cell auto pad-all-10">
                    <?php
                    if (get_queried_object_id() != 7441) {
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
                    } else {
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

                    if ($testimonials->have_posts()) {
                        while ($testimonials->have_posts()) {
                            $testimonials->the_post();
                            ?>
                            <div class="testimonials">
                                <p class="content"><?= strip_tags(get_the_content($testimonials->post->ID)) ?></p>
                                <hr>
                                <p><?= get_the_title($testimonials->post->ID) ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="grid-x nav-menus">
        <div class="cell auto">
            <?php
            echo '<h4>' . wp_get_nav_menu_name('footer-1') . '</h4>';
            pawp_footer_nav('footer-1');
            ?>
        </div>
        <div class="cell auto">
            <?php
            echo '<h4>' . wp_get_nav_menu_name('footer-2') . '</h4>';
            pawp_footer_nav('footer-2');
            ?>
        </div>
        <div class="cell auto">
            <?php
            echo '<h4>' . wp_get_nav_menu_name('footer-3') . '</h4>';
            pawp_footer_nav('footer-3');
            ?>
        </div>
        <div class="cell auto">
            <?php
            echo '<h4>' . wp_get_nav_menu_name('footer-4') . '</h4>';
            pawp_footer_nav('footer-4');
            ?>
        </div>
    </div>
    <div class="copyright">
        <hr>
        <div class="grid-x">
            <div class="cell auto payment">
                <div class="grid-x">
                    <div class="cell shrink" style="line-height: 50px;">Payment methods:&nbsp;&nbsp;</div>
                    <div class="cell auto"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cardpayments.png"></div>
                </div>
            </div>
            <div class="cell text-right shrink notice" style="line-height: 50px;">
                &copy; Pawprint Family <?php echo date('Y'); ?>
            </div>
        </div>
    </div>

</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
