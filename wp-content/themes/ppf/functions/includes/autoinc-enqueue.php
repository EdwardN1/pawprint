<?php
/**
 * Enqueue scripts and styles.
 */
function ppf_scripts() {
    wp_enqueue_style( 'ppf-style', get_stylesheet_uri() );
    wp_enqueue_style('owl-carousel' , 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-carousel-theme' , 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css');
    wp_enqueue_style( 'ppf-style-css', get_template_directory_uri().'/assets/css/ppf.css', 'ppf-style', filemtime(get_template_directory_uri().'/assets/css/ppf.css'), 'all' );
    wp_enqueue_style( 'foundation-style-css', get_template_directory_uri().'/assets/styles/style.css', 'ppf-style-css', filemtime(get_template_directory_uri().'/assets/styles/style.css'), 'all' );
    wp_enqueue_style( 'jamie-style-css', get_template_directory_uri().'/assets/css/jamie.css', 'ppf-style-css', filemtime(get_template_directory_uri().'/assets/css/jamie.css'), 'all' );
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