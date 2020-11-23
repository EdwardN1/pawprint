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
 * Enqueue scripts and styles.
 */
function ppf_scripts() {
	wp_enqueue_style( 'ppf-style', get_stylesheet_uri() );
    wp_enqueue_style('owl-carousel' , 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-carousel-theme' , 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css');
    wp_enqueue_style( 'ppf-style-css', get_template_directory_uri().'/assets/css/ppf.css' );
    wp_enqueue_style( 'ppf-style-updates', get_template_directory_uri().'/assets/css/updates.css' );

	wp_enqueue_script( 'ppf-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
    wp_enqueue_script('owl-carousel' , 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js' , '' , '' , true);
	wp_enqueue_script( 'ppf-js', get_template_directory_uri() . '/js/ppf.js', array(), '20151215', true );

	wp_enqueue_script( 'ppf-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ppf_scripts' );

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

add_filter( 'woocommerce_shortcode_products_query', 'badge_id_pre_posts', 50, 3 );

function badge_id_pre_posts($query_args, $atts, $loop_name){

    global $wp;
    $current_url = home_url( add_query_arg( array(), $wp->request ) );

    if(strpos($current_url , 'free-resources') && isset($_GET['badge_id'])){

        $badge = $_GET['badge_id'];
        $challengePack = get_field('challenge_pack_pdf' , $badge);
        $attachment = $challengePack['filename'];

        $query_args['meta_query'][] = array(
            'key' => '_downloadable_files',
            'value' => $attachment,
            'compare' => 'LIKE'
        );

    }

    return $query_args;

}

add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 40 );

remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop' , 'woocommerce_page_breadcrumbs', 20 );

function woocommerce_page_breadcrumbs(){
    echo do_shortcode('[vc_pawprint_breadcrumbs_block]');
}

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

remove_action('woocommerce_after_single_product_summary' , 'woocommerce_output_product_data_tabs' , 10);

function clean_commerce_child_custom_woo_fix() {

    add_filter( 'woocommerce_show_page_title', '__return_true', 1 );
    add_filter( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 6 );
}

add_action( 'init', 'clean_commerce_child_custom_woo_fix' );

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

add_action( 'wp_enqueue_scripts', 'add_theme_stylesheet' );

function add_theme_stylesheet() {
    wp_enqueue_script( 'wpb_composer_front_js' );
    wp_enqueue_style( 'js_composer_front' );
    wp_enqueue_style( 'js_composer_custom_css' );
}

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

//add_filter( 'woocommerce_order_number', 'change_woocommerce_order_number_ppf' );

function change_woocommerce_order_number_ppf( $order_id ) {
    if(get_post_meta($order_id , '_ekm_order_number' , true) != ''){
        return str_replace('-' , '/' , get_post_meta($order_id , '_ekm_order_number' , true));
    }else{
        return $order_id;
    }
}

add_action('woocommerce_after_cart' , 'ppf_delivery_date');

function ppf_delivery_date(){

    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    $dates = array();

    foreach ($items as $item) {

        $_product =  wc_get_product( $item['data']->get_id());

        if($_product->get_stock_status() == 'onbackorder' && get_field('estimated_delivery_date' , $item['data']->get_id()) != ''){
            $date = str_replace('/' , '-' , get_field('estimated_delivery_date' , $item['data']->get_id()));
            $dates[] = strtotime($date);
        }

    }

    $date = max($dates);
    $dateFormat = date('dS F Y' , $date);

    if(!empty($dates)){
        echo '<p class="cart-delivery-date">Based on the products that are in your basket, the estimated dispatch date for your order is:<br/>'.$dateFormat.'</p>';
    }

}

function iconic_add_engraving_text_to_order_items( $item, $cart_item_key, $values, $order ) {

    $product = $item->get_product();
    $productData = $product->get_data();
    $productID = $productData['id'];

    if(get_field('estimated_delivery_date' , $productID) != '' && $product->get_stock_status() == 'onbackorder'){
        $item->add_meta_data( __( 'Estimated Dispatch Date' ), get_field('estimated_delivery_date' , $productID) );
    }
    
}

add_action( 'woocommerce_checkout_create_order_line_item', 'iconic_add_engraving_text_to_order_items', 10, 4 );

remove_action('wpmc-woocommerce_order_review' , 'woocommerce_order_review' , 20);
add_action('woocommerce_after_checkout_form' , 'ppf_order_summary');

function ppf_order_summary(){

    get_template_part('template-parts/ppf' , 'order-review');

}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );
function woocommerce_custom_single_add_to_cart_text() {

    global $product;

    if(is_product_category('free-resources')){
        return __('Get Resource' , 'woocommerce');
    }else{

        if(get_post_meta($product->get_id() , '_ywpo_preorder' , true) == 'yes') {
            return __( 'Pre Order Now', 'woocommerce' );
        }else {
            return __('Add To Basket', 'woocommerce');
        }

    }
}

add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );
function woocommerce_custom_product_add_to_cart_text() {

    global $product;

    if(is_product_category('free-resources')){
        return __('Get Resource' , 'woocommerce');
    }else{

        if(get_post_meta($product->get_id() , '_ywpo_preorder' , true) == 'yes') {
            return __( 'Pre Order Now', 'woocommerce' );
        }else {
            return __('Add To Basket', 'woocommerce');
        }

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

add_filter( 'woocommerce_account_menu_items', 'misha_remove_my_account_dashboard' );
function misha_remove_my_account_dashboard( $menu_links ){

    unset( $menu_links['dashboard'] );
    return $menu_links;

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

add_filter( 'woocommerce_output_related_products_args', 'bbloomer_change_number_related_products', 9999 );

function bbloomer_change_number_related_products( $args ) {
    $args['posts_per_page'] = 5; // # of related products
    $args['columns'] = 5; // # of columns per row
    return $args;
}

add_action('woocommerce_account_orders_columns' , 'ppf_wc_get_account_orders_columns');

function ppf_wc_get_account_orders_columns($columns){

    unset( $columns['order-total'] );

    $columns['order_qty'] = 'Order Quantity';
    $columns['order_total'] = 'Order Total';
    $columns['payment_method'] = 'Payment Method';

    return $columns;

}

function add_estimated_date($product_title, $cart_item, $cart_item_key){

    if(get_field('estimated_delivery_date' , $cart_item['product_id']) != ''){
        if(get_post_meta($cart_item['product_id'] , '_ywpo_preorder' , true) == 'yes') {
            return $product_title.'<span style="color: red;">Estimated Dispatch Date: '.get_field('estimated_delivery_date' , $cart_item['product_id']).' (Pre-order)</span>';
        }else{
            return $product_title.'<span style="color: red;">Estimated Dispatch Date: '.get_field('estimated_delivery_date' , $cart_item['product_id']).'</span>';
        }
    }else{
        return $product_title;
    }

}

add_filter ('woocommerce_cart_item_name', 'add_estimated_date' , 10, 3 );

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

add_filter ('woocommerce_email_order_items_args', 'send_purchase_note_to_everyone');

function send_purchase_note_to_everyone( $args ) {
    $args['show_purchase_note']  = true;
    return $args;
}

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

if ( ! function_exists( 'wp_password_change_notification' ) ) {
    function wp_password_change_notification( $user ) {
        return;
    }
}

add_filter( 'woocommerce_cart_shipping_method_full_label', 'bbloomer_add_0_to_shipping_label', 10, 2 );

function bbloomer_add_0_to_shipping_label( $label, $method ) {

// if shipping rate is 0, concatenate ": $0.00" to the label
    if ( ! ( $method->cost > 0 ) ) {
        $label .= ': ' . wc_price(0);
    }

// return original or edited shipping label
    return $label;

}

add_action( 'wp', 'remove_image_zoom_support', 100 );

function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}

function my_save_account_details_redirect($user_id){
    wp_safe_redirect( wc_get_endpoint_url( 'edit-account') );
    exit;
}
add_action( 'woocommerce_save_account_details', 'my_save_account_details_redirect', 10, 1 );

add_filter( 'loop_shop_per_page', 'bbloomer_redefine_products_per_page', 9999 );

function bbloomer_redefine_products_per_page( $per_page ) {
    $per_page = 30;
    return $per_page;
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

function cw_change_product_html( $price_html, $product ) {

    global $wp;
    $current_url = home_url( add_query_arg( array(), $wp->request ) );

    if(strpos($current_url , 'free-resources') && !is_singular()){
        $price_html = '';
    }

    return $price_html;
}

add_filter( 'woocommerce_get_price_html', 'cw_change_product_html', 10, 2 );


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

add_filter( 'woocommerce_loop_add_to_cart_link', 'replacing_add_to_cart_button', 10, 2 );
function replacing_add_to_cart_button( $button, $product  ) {

    if(is_product_category('free-resources') || has_term( array('free-resources'), 'product_cat', $product->get_id() )){
        $button = '<a class="button" href="' . $product->get_permalink() . '">Get Resource</a>';
    }

    return $button;

}