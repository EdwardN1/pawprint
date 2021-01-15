<?php
/**
 * Pawprint Family functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pawprint_Family
 */

if ( ! function_exists( 'ppf_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ppf_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Pawprint Family, use a find and replace
		 * to change 'ppf' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ppf', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ppf' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ppf_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ppf_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ppf_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ppf_content_width', 640 );
}
add_action( 'after_setup_theme', 'ppf_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ppf_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ppf' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ppf' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

    register_sidebar( array(
        'name'          => esc_html__( 'Menu Dropdown Badges', 'ppf' ),
        'id'            => 'menu-dropdown-1',
        'description'   => esc_html__( 'Add widgets here.', 'ppf' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar( array(
        'name'          => esc_html__( 'Menu Dropdown Tales', 'ppf' ),
        'id'            => 'menu-dropdown-2',
        'description'   => esc_html__( 'Add widgets here.', 'ppf' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar( array(
        'name'          => esc_html__( 'Menu Dropdown Trails', 'ppf' ),
        'id'            => 'menu-dropdown-3',
        'description'   => esc_html__( 'Add widgets here.', 'ppf' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Trust Block', 'ppf' ),
        'id'            => 'footer-trust-block',
        'description'   => esc_html__( 'Add widgets here.', 'ppf' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Badges Block', 'ppf' ),
        'id'            => 'footer-badges-block',
        'description'   => esc_html__( 'Add widgets here.', 'ppf' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Data', 'ppf' ),
        'id'            => 'footer-data',
        'description'   => esc_html__( 'Add widgets here.', 'ppf' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Menu', 'ppf' ),
        'id'            => 'footer-menu',
        'description'   => esc_html__( 'Add widgets here.', 'ppf' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));


}
add_action( 'widgets_init', 'ppf_widgets_init' );



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Activity additions.
 */
//include_once get_template_directory() . '/library/activities-post-type.php';
include_once get_template_directory() . '/library/faq-post-type.php';
include_once get_template_directory() . '/library/testimonial-post-type.php';

/**
 * WP Backery additions.
 */
include_once get_template_directory() . '/vc-elements/vc-elements.php';

add_filter('loop_shop_columns', 'loop_columns', 999);

if (!function_exists('loop_columns')) {
    function loop_columns() {
        return 5; // 3 products per row
    }
}

add_filter( 'pre_get_posts', 'activity_filter_query_per_page' );

function activity_filter_query_per_page( $query ) {

    if ( is_post_type_archive( 'ppb-activities' ) ) {

        if(isset($_GET['activity-filter']) && $_GET['activity-filter'] == 'on' && $query->is_main_query()){

            $selected_types = (isset($_GET['types'])) ? $_GET['types'] : '';
            $selected_seasons = (isset($_GET['seasons'])) ? $_GET['seasons'] : '';
            $selected_environment = (isset($_GET['environment'])) ? $_GET['environment'] : '';
            $selected_time = (isset($_GET['time'])) ? $_GET['time'] : '';
            $selected_cost = (isset($_GET['costs'])) ? $_GET['costs'] : '';
            $selected_ages = (isset($_GET['_age'])) ? $_GET['_age'] : '';
            $selected_badge = (isset($_GET['_badge'])) ? $_GET['_badge'] : '';
            $selected_skills = (isset($_GET['_skills'])) ? $_GET['_skills'] : '';
            $selected_subject = (isset($_GET['_subject'])) ? $_GET['_subject'] : '';
            $selected_equipment = (isset($_GET['equipment'])) ? $_GET['equipment'] : '';

            $tax_query = $query->get( 'tax_query' ) ?: array();
            $meta_query = $query->get( 'meta_query' ) ?: array();

            if($selected_types != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-type',
                    'field' => 'slug',
                    'terms' => $selected_types
                );
            }

            if($selected_seasons != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-season',
                    'field' => 'slug',
                    'terms' => $selected_seasons
                );
            }

            if($selected_environment != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-environment',
                    'field' => 'slug',
                    'terms' => $selected_environment
                );
            }

            if($selected_time != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-time',
                    'field' => 'slug',
                    'terms' => $selected_time
                );
            }

            if($selected_cost != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-price',
                    'field' => 'slug',
                    'terms' => $selected_cost
                );
            }

            if($selected_ages != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-age',
                    'field' => 'slug',
                    'terms' => $selected_ages
                );
            }

            if($selected_skills != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-soft-skills',
                    'field' => 'slug',
                    'terms' => $selected_skills
                );
            }

            if($selected_subject != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-subject',
                    'field' => 'slug',
                    'terms' => $selected_subject
                );
            }

            if($selected_badge != ''){
                $meta_query[] = array(
                    'key' => 'badges',
                    'value' => $selected_badge,
                    'compare' => 'LIKE'
                );
            }

            if($selected_equipment != ''){
                $tax_query[] = array(
                    'taxonomy' => 'ppb-activity-equipment',
                    'terms' => $selected_equipment,
                    'field' => 'term_id'
                );
            }

            $query->set('tax_query' , $tax_query);
            $query->set('meta_query' , $meta_query);
            $query->set('orderby' , 'rand');

        }

    }


}















add_action( 'wp_enqueue_scripts', 'add_theme_stylesheet' );

function add_theme_stylesheet() {
    wp_enqueue_script( 'wpb_composer_front_js' );
    wp_enqueue_style( 'js_composer_front' );
    wp_enqueue_style( 'js_composer_custom_css' );
}



//add_filter( 'woocommerce_order_number', 'change_woocommerce_order_number_ppf' );

function change_woocommerce_order_number_ppf( $order_id ) {
    if(get_post_meta($order_id , '_ekm_order_number' , true) != ''){
        return str_replace('-' , '/' , get_post_meta($order_id , '_ekm_order_number' , true));
    }else{
        return $order_id;
    }
}







add_action('wp_footer' , 'ppf_breadcrumbs_product_categories');

function ppf_breadcrumbs_product_categories(){

    if(is_product()){
        ?>

        <script type="text/javascript">

            $ = jQuery;

            $('#breadcrumbs a').each(function (index , element) {

                var href = $(element).attr('href');
                var hrefSegs = href.split('/');

                if(hrefSegs.length == 7){
                    var category = hrefSegs[5];
                    var newhref = hrefSegs[0]+'//'+hrefSegs[2]+'/'+hrefSegs[3]+'/'+hrefSegs[4]+'?product_category='+category;
                    $(element).attr('href' , newhref);
                }

            });

            $('.single_add_to_cart_button').each(function (index,element) {
                var ele = $(element);
                if(ele.html() == 'Pre-Order Now'){
                    ele.html('Pre Order Now');
                }
            });

        </script>

        <?php
    }else{

        ?>

        <script>

            jQuery('body .woofc-item').each(function (index , element) {
                var ele = jQuery(element);
                ele.height(ele.height());
            });

            var orderStaus = jQuery('body .woocommerce-orders-table__cell-order-status').html().split('<br>');
            jQuery('body .woocommerce-orders-table__cell-order-status').html(orderStaus[0]);

        </script>

        <?php

    }

}



//add_action('template_redirect', 'misha_redirect_to_orders_from_dashboard' );

function misha_redirect_to_orders_from_dashboard(){

    if( is_account_page() && empty( WC()->query->get_current_endpoint() ) ){
        wp_safe_redirect( wc_get_account_endpoint_url( 'edit-account' ) );
        exit;
    }

}

add_filter('gettext', 'change_rp_text', 10, 3);
add_filter('ngettext', 'change_rp_text', 10, 3);

function change_rp_text($translated, $text, $domain)
{
    if ($text === 'Related products' && $domain === 'woocommerce') {
        $translated = esc_html__('Other products you might like', $domain);
    }
    return $translated;
}

add_shortcode('ppf_number_of_activities'  , 'ppf_number_of_activities');

function ppf_number_of_activities(){

    $activities = get_posts(array('post_type' => 'ppb-activities' , 'posts_per_page' => -1));

    return count($activities);

}

add_shortcode('ppf_random_activity'  , 'ppf_random_activity');

function ppf_random_activity(){

    $query = new WP_Query(array('post_type' => 'ppb-activities' , 'orderby' => 'rand' , 'posts_per_page' => '1'));;

    return '<a href="'.get_post_permalink($query->posts[0]->ID).'" class="pp-btn navy">Surprise me!</a>';

}

add_shortcode('ppf_random_badge'  , 'ppf_random_badge');

function ppf_random_badge(){

    $query = new WP_Query(
        array(
            'post_type' => 'product' ,
            'orderby' => 'rand' ,
            'posts_per_page' => '1' ,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms' => array('badges'),
                    'field' => 'slug'
                )
            )
        )
    );

    return '<a href="'.get_post_permalink($query->posts[0]->ID).'" class="pp-btn navy">Recommend me a badge</a>';

}









add_action("wp_ajax_get_equipment", "get_equipment");
add_action("wp_ajax_nopriv_get_equipment", "get_equipment");

function get_equipment(){

    $args = array(
        'name__like' => $_POST['query'],
        'hide_empty' => true
    );
    echo json_encode(get_terms('ppb-activity-equipment' , $args ));
    die();
}

add_action('template_redirect' , 'add_date_ordering_to_categories');
function add_date_ordering_to_categories(){

    if(is_product_category() && !isset($_GET['orderby']) && !isset($_GET['product_category'])){
        ob_start();
        wp_redirect('?orderby=date');
        exit();
    }

}

add_action("wp_ajax_get_order_review", "get_order_review");
add_action("wp_ajax_nopriv_get_order_review", "get_order_review");

function get_order_review(){

    ob_start();
    include "template-parts/ppf-order-review-content.php";
    echo ob_get_clean();

    die();

}

function custom_wc_add_fee() {

    $reduce = 0;
    $reuse = 0;
    $recycle = 0;

    foreach(WC()->cart->get_cart() as $cart_item){

        $data = $cart_item['data'];
        $item_name = $cart_item['data']->get_title();
        $quantity = $cart_item['quantity'];

        if($item_name == 'Reuse'){
            $reuse += $quantity;
        }elseif($item_name == 'Reduce'){
            $reduce += $quantity;
        }elseif($item_name == 'Recycle'){
            $recycle += $quantity;
        }

    }

    $discountAmount = 0;

    if($reduce != 0 && $reuse != 0 && $recycle != 0){

        $amountsArray = array($reduce , $recycle , $reuse);
        $discountAmount -= 0.29166666667 * min($amountsArray);

    }

    if($discountAmount < 0){
        WC()->cart->add_fee( 'Reduce/Reuse/Recycle Discount' , $discountAmount , false );
    }

}
//add_action( 'woocommerce_cart_calculate_fees','custom_wc_add_fee' );



remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

if ( ! function_exists( 'wp_password_change_notification' ) ) {
    function wp_password_change_notification( $user ) {
        return;
    }
}



add_action( 'wp', 'remove_image_zoom_support', 100 );

function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}



add_filter( 'loop_shop_per_page', 'bbloomer_redefine_products_per_page', 9999 );

function bbloomer_redefine_products_per_page( $per_page ) {
    $per_page = 30;
    return $per_page;
}






function wc_cart_totals_shipping_method_label_custom( $method ) {
    $label = '';
    $has_cost  = 0 < $method->cost;
    $hide_cost = ! $has_cost && in_array( $method->get_method_id(), array( 'free_shipping', 'local_pickup' ), true );

    if ( $has_cost && ! $hide_cost ) {
        if ( WC()->cart->display_prices_including_tax() ) {
            $label .= wc_price( $method->cost + $method->get_shipping_tax() ) . ' ';
            if ( $method->get_shipping_tax() > 0 && ! wc_prices_include_tax() ) {
                $label .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
            }
        } else {
            $label .= wc_price( $method->cost ). ' ';
            if ( $method->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
                $label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
            }
        }
    }

    $label .= $method->get_label();

    return apply_filters( 'woocommerce_cart_shipping_method_full_label', $label, $method );
}

add_action( 'init', 'update_extra_profile_fields');

function update_extra_profile_fields() {

    $user_id = get_current_user_id();

    if(isset($_POST['hear'])){
        update_user_meta($user_id , '_hear' ,  $_POST['hear']);
    }

    if(isset($_POST['groups'])){
        update_user_meta($user_id , '_groups' ,  json_encode($_POST['groups']));
    }

    if(isset($_POST['ages'])) {
        update_user_meta($user_id, '_ages', json_encode($_POST['ages']));
    }

}



define('FUNCTIONSPATH', get_template_directory() . '/functions/includes/');
foreach (glob(FUNCTIONSPATH.'autoinc-*.php') as $filename)
{
    require_once ($filename);
}