<?php

if(!class_exists('WPBakeryShortCode')) { return false; }

class vcPawprintFaqs extends WPBakeryShortCode
{

    function __construct()
    {
        add_action('vc_before_init', array($this, 'vc_pawprint_faqs_mapping'));
        add_shortcode('vc_pawprint_faqs_block', array($this, 'vc_pawprint_faqs_html'));
    }

    public function get_all_faqs_types(){

        $types = get_terms(array('taxonomy' => 'faq-type' , 'hide_empty' => false));

        $return = array(
            'Select a type' => '0'
        );

        foreach ($types as $type){
            $return[$type->name] = $type->slug;
        }

        return $return;

    }

    public function vc_pawprint_faqs_mapping(){

        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        vc_map(

            array(
                'name' => __('Pawprint Faqs', 'text-domain'),
                'base' => 'vc_pawprint_faqs_block',
                'category' => __('Pawprint Family Elements'),
                'icon' => get_template_directory_uri().'/images/vc-icon.png',
                'params' => array(

                    array(
                        'type'        => 'dropdown',
                        'heading'     => __('Type'),
                        'param_name'  => '_type',
                        'group' => 'Query',
                        'value' => $this->get_all_faqs_types(),
                        'admin_label' => true
                    )

                )
            )

        );

    }

    public function vc_pawprint_faqs_html($atts){

        $faqs = new WP_Query(
            array(
                'post_type' => 'faq',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'faq-type',
                        'field' => 'slug',
                        'terms' => $atts['_type']
                    )
                )
            )
        );

        if($faqs->have_posts()){

            $html = '<div class="faq-accordian">';

            while ($faqs->have_posts()){ $faqs->the_post();
                $html .= '<div class="question" style="background: '.get_field('background_colour' , $faqs->post->ID).'">';
                    $html .= '<h2>'.get_the_title($faqs->post->ID).'</h2>';
                    $html .= '<div class="answer">';
                        $html .= '<p>'.get_the_content($faqs->post->ID).'</p>';
                    $html .= '</div>';
                    $html .= '<div class="chevron"></div>';
                $html .= '</div>';
            }

            $html .= '</div>';

        }

        return $html;

    }

}

new vcPawprintFaqs();