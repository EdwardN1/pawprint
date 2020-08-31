<?php

if(!class_exists('WPBakeryShortCode')) { return false; }

class vcPawprintButton extends WPBakeryShortCode
{

    function __construct()
    {
        add_action('vc_before_init', array($this, 'vc_pawprint_button_mapping'));
        add_shortcode('vc_pawprint_button_block', array($this, 'vc_pawprint_button_html'));
    }

    public function vc_pawprint_button_mapping(){

        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        vc_map(

            array(
                'name' => __('Pawprint Button', 'text-domain'),
                'base' => 'vc_pawprint_button_block',
                'category' => __('Pawprint Family Elements'),
                'icon' => get_template_directory_uri().'/images/vc-icon.png',
                'params' => array(

                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Button Text'),
                        'param_name'  => '_button_text',
                        'group' => 'Design',
                    ),

                    array(
                        'type'        => 'vc_link',
                        'heading'     => __('Button Link'),
                        'param_name'  => '_button_link',
                        'group' => 'Design',
                    ),

                    array(
                        'type'        => 'dropdown',
                        'heading'     => __('Button Colour Options'),
                        'param_name'  => '_button_colour',
                        'value' => array(
                            'Navy' => 'navy',
                            'Pink' => 'pink',
                            'Teal' => 'teal',
                            'Yellow' => 'yellow',
                            'Orange' => 'orange',
                        ),
                        'std' => 'navy',
                        'admin_label' => true,
                        'group' => 'Design'
                    ),

                )
            )

        );

    }

    public function vc_pawprint_button_html($atts){

        $href = vc_build_link( $atts['_button_link'] );

        $button_colour = (!isset($atts['_button_colour'])) ? 'navy' : $atts['_button_colour'];

        $html = '<a href="'.$href['url'].'" class="pp-btn '.$button_colour.'">'.$atts['_button_text'].'</a>';
        return $html;

    }

}

new vcPawprintButton();