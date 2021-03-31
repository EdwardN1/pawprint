<?php

if(!class_exists('WPBakeryShortCode')) { return false; }

class vcPawprintBreadcrumbs extends WPBakeryShortCode
{

    function __construct()
    {
        add_action('vc_before_init', array($this, 'vc_pawprint_breadcrumbs_mapping'));
        add_shortcode('vc_pawprint_breadcrumbs_block', array($this, 'vc_pawprint_breadcrumbs_block_html'));
    }

    public function vc_pawprint_breadcrumbs_mapping(){

        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        vc_map(

            array(
                'name' => __('Pawprint Breadcrumbs', 'text-domain'),
                'base' => 'vc_pawprint_breadcrumbs_block',
                'category' => __('Pawprint Family Elements'),
                'icon' => get_template_directory_uri().'/images/vc-icon.png',

            )

        );

    }

    public function vc_pawprint_breadcrumbs_block_html($atts){

        if ( function_exists('yoast_breadcrumb') ) {
            return yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
        }

    }

}

new vcPawprintBreadcrumbs();