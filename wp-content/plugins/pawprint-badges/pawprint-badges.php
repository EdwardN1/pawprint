<?php
/*
Plugin Name: Pawprint Badges
Description: Pawprint Badges Content.
Version: 1.0.0
Author: Rare Earth Digital Ltd.
Author URI: https://www.rareearthdigital.com/
License: Proprietary
Text Domain: pawprint-badges
*/

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Defines
define( 'RED_PPB__NAME', 'Pawprint Badges' );
define( 'RED_PPB__TEXTDOMAIN', strtolower( str_replace( " ", "-", RED_PPB__NAME ) ) );
define( 'RED_PPB__VERSION', '1.0.4' );
define( 'RED_PPB__MINIMUM_WP_VERSION', '5.0.3' );
define( 'RED_PPB__PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'RED_PPB__PLUGIN_INC', trailingslashit( RED_PPB__PLUGIN_DIR . 'includes' ) );
define( 'RED_PPB__PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'RED_PPB__PLUGIN_TEMPLATES', trailingslashit( RED_PPB__PLUGIN_DIR . 'templates' ) );
define( 'RED_PPB__PLUGIN_ASSETS_DIR', trailingslashit( RED_PPB__PLUGIN_URL . 'assets' ) );
define( 'RED_PPB__PLUGIN_ADMIN_IMG_DIR', trailingslashit( RED_PPB__PLUGIN_ASSETS_DIR . 'admin/images' ) );
define( 'RED_PPB__PLUGIN_ADMIN_CSS_DIR', trailingslashit( RED_PPB__PLUGIN_ASSETS_DIR . 'admin/css' ) );
define( 'RED_PPB__PLUGIN_ADMIN_JS_DIR', trailingslashit( RED_PPB__PLUGIN_ASSETS_DIR . 'admin/js' ) );
define( 'RED_PPB__PLUGIN_FRONTEND_CSS_DIR', trailingslashit( RED_PPB__PLUGIN_ASSETS_DIR . 'frontend/css' ) );
define( 'RED_PPB__PLUGIN_FRONTEND_JS_DIR', trailingslashit( RED_PPB__PLUGIN_ASSETS_DIR . 'frontend/js' ) );
define( 'RED_PPB__PLUGIN_FRONTEND_IMG_DIR', trailingslashit( RED_PPB__PLUGIN_ASSETS_DIR . 'frontend/images' ) );
define( 'RED_PPB__PLUGIN_CSS_DIR', trailingslashit( RED_PPB__PLUGIN_ASSETS_DIR . 'css' ) );
$upload = wp_upload_dir();
define( 'RED_PPB__PLUGIN_EXPORT_FOLDER_NAME', 'ppb-csv-exports' );
define( 'RED_PPB__PLUGIN_EXPORT_DIR', trailingslashit( $upload['basedir'] ) . RED_PPB__PLUGIN_EXPORT_FOLDER_NAME );

if( version_compare( get_bloginfo( 'version' ), RED_PPB__MINIMUM_WP_VERSION, '<' ) ) {
	deactivate_plugins( plugin_basename( __FILE__ ) );
	wp_die( 'This plugin requires WordPress Version ' . RED_PPB__MINIMUM_WP_VERSION . ' or Greater. Sorry about that. Please update and try again.' );
}

class RED_PPB_INIT {

	public function __construct()
	{
		add_action( 'init', array( $this, 'red_ppb_init' ) );
		add_filter( 'block_categories', array( $this, 'red_ppb_block_category' ), 10, 2);
		add_filter( 'allowed_block_types', array( $this, 'red_ppb_allowed_block_types' ), 10, 2 );
		$csv = new activityExport();
	}

	public function red_ppb_init()
	{

	}

	public function red_ppb_block_render_callback( $block )
	{

		// convert name ("acf/testimonial") into path friendly slug ("testimonial")
		$slug = str_replace( 'acf/', '', $block['name'] );

		// include a template part from within the "template-parts/block" folder
        if( file_exists( get_stylesheet_directory() . "/block_templates/content-{$slug}.php" ) ) {
            include( get_stylesheet_directory() . "/block_templates/content-{$slug}.php" );
        }
        else if( file_exists( RED_PPB__PLUGIN_TEMPLATES . "block/content-{$slug}.php" ) ) {
			include( RED_PPB__PLUGIN_TEMPLATES . "block/content-{$slug}.php" );
		}
	}

	public function red_ppb_block_category( $categories, $post ) {
		return array_merge(
			array(
				array(
					'slug' => 'ppb-blocks',
					'title' => __( 'Pawprint Badges Blocks', 'ppb-blocks' ),
				),
			),
			$categories
		);
	}

	public function red_ppb_allowed_block_types( $allowed_block_types, $post ) {

		switch($post->post_type) {

			case 'ppb-activities':
				return array(
					'acf/red-ppb-idea',
					'acf/red-ppb-why',
					'acf/red-ppb-for-leaders',
					'acf/red-ppb-did-you-know',
					'acf/red-ppb-age-group',
				);
				break;

			default:
				return $allowed_block_types;
				break;

		}

	}

}

include( RED_PPB__PLUGIN_INC . 'activities.php' );
include( RED_PPB__PLUGIN_INC . 'activityExport.php' );

$red_ppb_init = new RED_PPB_INIT();

?>
