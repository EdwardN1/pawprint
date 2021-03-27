<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pawprint_Family
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

    <!-- Facebook Pixel Code -->

    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '601908767269148');
        fbq('track', 'PageView');
    </script>

    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=601908767269148&ev=PageView&noscript=1"/>
    </noscript>

    <!-- End Facebook Pixel Code -->

    <script>

        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-74819851-1', 'auto', {allowLinker: true});
        ga('require', 'linker');
        ga('linker:autoLink', ['www.pawprintbadges.co.uk']);

        ga('send', 'pageview');

    </script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'ppf'); ?></a>

    <header id="masthead" class="site-header">

        <div class="new-wrap">

            <div class="header-top-section">

                <div class="site-branding desktop">
                    <?php
                    the_custom_logo();
                    ?>
                </div>

                <div class="search-container">
                    <div class="search-wrapper">
                        <?php echo get_search_form() ?>
                    </div>
                </div>

                <div class="shop-actions desktop">
                    <ul>

                        <li>

                            <?php if (is_user_logged_in()) {
                                $userdata = get_userdata(get_current_user_id()); ?>

                                <p style="text-align: center;">
                                    <a href="<?= get_site_url() ?>/my-account/edit-account/"
                                       class="lrm-show-if-logged-in">
                                        <img src="<?= get_template_directory_uri() ?>/assets/img/SVG/Account.svg"
                                             alt="">

                                    </a>
                                    <span style="color: #ffffff; padding-top: 4px; display: block;"> Hello, <?= $userdata->first_name ?> </br>
                                        <!--(not you? <a href="<? /*= wc_logout_url() */ ?>">Log Out</a>)--></span></p>
                            <?php } else {
                                ?>
                                <p style="text-align: center;">
                                    <a href="" class="lrm-login lrm-hide-if-logged-in">
                                        <img src="<?= get_template_directory_uri() ?>/assets/img/SVG/Account.svg"
                                             alt="">
                                    </a>
                                    <span class="login-text">Login</span></p>
                                <?php
                            } ?>
                        </li>


                        <li>
                            <a href="<?php echo wc_get_cart_url(); ?>" class="cart-customlocation">
                                <img src="<?= get_template_directory_uri() ?>/assets/img/SVG/Basket.svg" alt=""
                                     class="basket-icon"> <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                <?php echo WC()->cart->get_cart_total(); ?></a>
                            </a>
                        </li>

                    </ul>

                </div>
                <div class="shop-actions mobile">
                    <div class="grid-x mobile-burger-menu">
                        <div class="cell shrink mobile-burger-menu">
                            <a href="javascript:void(0);" class="mobile_menu_toggle">
                                <span></span>
                            </a>
                        </div>
                        <div class="cell shrink mobile-logo">
                            <div class="logo-container" style="max-width: 70px;">
                                <?php
                                the_custom_logo();
                                ?>
                            </div>
                        </div>
                        <div class="cell auto">
                            <div class="search-container mobile">
                                <div class="search-wrapper">
                                    <?php echo get_search_form() ?>
                                </div>
                            </div>
                        </div>
                        <div class="cell shrink">
                            <a href="<?php echo wc_get_cart_url(); ?>" style="max-width: 40px;">
                                <img src="<?= get_template_directory_uri() ?>/assets/img/SVG/Basket.svg" alt=""
                                     class="basket-icon" style="width: 30px"> </a>
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <nav id="site-navigation" class="main-navigation">
                <ul>
                    <li class="has-dropdown">
                        <a href="/product-category/badges/">Pawprint Badges</a>
                        <?php echo get_template_part('template-parts/menu-badges', 'dropdown'); ?>
                    </li>
                    <li class="has-dropdown">
                        <a href="/product-category/trails/">Pawprint Trails</a>
                        <?php echo get_template_part('template-parts/menu-trails', 'dropdown'); ?>
                    </li>
                    <li class="has-dropdown">
                        <a href="/product-category/tales/">Pawprint Tales</a>
                        <?php echo get_template_part('template-parts/menu-tales', 'dropdown'); ?>
                    </li>
                    <li>
                        <a href="<?= get_site_url() ?>/pawprint-trust/">Pawprint Trust</a>
                    </li>
                    <li><a href="<?= get_site_url() ?>/product-category/merchandise/">Tribe Merchandise</a></li>
                    <li><a href="<?= get_site_url() ?>/about-us/">About Us</a></li>
                    <li><a href="<?= get_site_url() ?>/faqs/">FAQS</a></li>
                </ul>
                <?php //echo get_search_form() ?>
                <div class="mobile-account">
                    <a href="" class="lrm-login lrm-hide-if-logged-in">
                        <img src="<?= get_template_directory_uri() ?>/assets/img/SVG/Account.svg" alt="">
                        <span class="login-text">Login</span>
                    </a>
                    <a href="<?= get_site_url() ?>/my-account/edit-account/" class="lrm-show-if-logged-in">
                        <img src="<?= get_template_directory_uri() ?>/assets/img/SVG/Account.svg" alt="">
                        My Account
                    </a>
                    <?php if (is_user_logged_in()) {
                        $userdata = get_userdata(get_current_user_id()); ?>
                        <a href="<?= wp_logout_url() ?>">Hello <?= $userdata->first_name ?> (not you? Log Out)</a>
                    <?php } ?>
                </div>
            </nav><!-- #site-navigation -->
        </div>
    </header><!-- #masthead -->

    <div class="menu-black-block"></div>

    <div id="content" class="site-content">
