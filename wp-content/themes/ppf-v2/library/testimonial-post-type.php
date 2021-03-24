<?php

add_action( 'init' , 'add_testimonials_post_type' );
//add_action( 'acf/init', 'red_ppb_testimonials_block_init' );

function add_testimonials_post_type()
{

    register_post_type(
        'testimonial',
        array(
            'label' => 'Testimonials',
            'public' => true,
            'rewrite' => array(
                'slug' => 'testimonial',
            ),
            'has_archive' => true,
        )
    );

    register_taxonomy(
        'testimonial-type',
        'testimonial',
        array(
            'label' => 'Testimonial Type',
            'public' => true,
            'hierarchical' => true,
            'show_admin_column' => true
        )
    );

    $acfFields = array(
        'key' => 'group_5d0b95c1df875',
        'title' => 'Testimonials',
        'fields' => array(
            array(
                'key' => 'field_5d0b95d197323',
                'label' => 'Location',
                'name' => 'location',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5d0b9764efc1',
                'label' => 'Trust',
                'name' => 'trust',
                'type' => 'true_false',
                'instructions' => 'Tick this box if the testimonial should appear only on the Pawprint Trust page',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'testimonial',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    );

    $acfFields2 = array(
        'key' => 'group_5c755251e8ac6',
        'title' => 'Badges',
        'fields' => array(
            array(
                'key' => 'field_5c755285830ed',
                'label' => 'Mark as top seller',
                'name' => 'mark_as_top_seller',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_5d318b845c8fe',
                'label' => 'Challenge Pack PDF',
                'name' => 'challenge_pack_pdf',
                'type' => 'file',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'library' => 'all',
                'min_size' => '',
                'max_size' => '',
                'mime_types' => 'pdf',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
                array(
                    'param' => 'post_taxonomy',
                    'operator' => '==',
                    'value' => 'product_cat:badges',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    );

    if (is_array($acfFields) && count($acfFields) && function_exists('acf_add_local_field_group')){
        acf_add_local_field_group($acfFields);
    }

    if (is_array($acfFields2) && count($acfFields2) && function_exists('acf_add_local_field_group')){
        acf_add_local_field_group($acfFields2);
    }

}