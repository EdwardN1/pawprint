<?php

    add_action( 'init' , 'add_activities_post_type' );
    add_filter( 'block_categories' , 'red_ppb_block_category' , 10, 2);
    add_filter( 'allowed_block_types',  'red_ppb_allowed_block_types' , 10, 2 );
    add_action( 'acf/init', 'red_ppb_activities_block_init' );

    function add_activities_post_type(){

        register_post_type(
            'ppb-activities',
            array(
                'label' => 'Activities',
                'public' => true,
                'rewrite' => array(
                    'slug' => 'activities',
                ),
                'has_archive' => true,
                'show_in_rest' => true
            )
        );

        register_taxonomy(
            'ppb-activity-type',
            'ppb-activities',
            array(
                'label' => 'Activity Type',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

        register_taxonomy(
            'ppb-activity-age',
            'ppb-activities',
            array(
                'label' => 'Activity Age',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

        register_taxonomy(
            'ppb-activity-equipment',
            'ppb-activities',
            array(
                'label' => 'Activity Equipment',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

        register_taxonomy(
            'ppb-activity-subject',
            'ppb-activities',
            array(
                'label' => 'Activity Subjects',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

        register_taxonomy(
            'ppb-activity-season',
            'ppb-activities',
            array(
                'label' => 'Activity Season',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

        register_taxonomy(
            'ppb-activity-time',
            'ppb-activities',
            array(
                'label' => 'Activity Time',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

        register_taxonomy(
            'ppb-activity-environment',
            'ppb-activities',
            array(
                'label' => 'Activity Environment',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

        register_taxonomy(
            'ppb-activity-price',
            'ppb-activities',
            array(
                'label' => 'Activity Price',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

        register_taxonomy(
            'ppb-activity-soft-skills',
            'ppb-activities',
            array(
                'label' => 'Activity Soft Skills',
                'public' => true,
                'hierarchical' => true,
                'show_admin_column' => true
            )
        );

    }

    function red_ppb_activities_block_init() {

        global $red_ppb_init;

        // check function exists
        if( function_exists('acf_register_block_type') ) {
            /*
             * register a Here's an idea block
             */
            acf_register_block_type( array(
                'name'            => 'red_ppb_idea',
                'title'           => __( 'Here\'s an idea' ),
                'description'     => __( 'Here\'s an idea.' ),
                'render_callback' => array( $red_ppb_init, 'red_ppb_block_render_callback' ),
                'category'        => 'ppb-blocks',
                'icon'            => '<svg width="100%" height="100%" viewBox="0 0 14 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><path d="M4.174,17.748c0.001,0.245 0.067,0.486 0.19,0.691l0.605,1.003c0.21,0.348 0.565,0.558 0.944,0.558l2.185,0c0.379,0 0.733,-0.21 0.943,-0.558l0.605,-1.003c0.124,-0.205 0.19,-0.445 0.19,-0.691l0.001,-1.498l-5.664,0l0.001,1.498Zm-3.401,-10.873c0,1.733 0.582,3.314 1.542,4.522c0.585,0.737 1.5,2.275 1.849,3.573c0.002,0.01 0.003,0.02 0.004,0.03l5.674,0c0.001,-0.01 0.002,-0.02 0.004,-0.03c0.349,-1.298 1.264,-2.836 1.849,-3.573c0.96,-1.208 1.542,-2.789 1.542,-4.522c0,-3.804 -2.8,-6.887 -6.251,-6.875c-3.613,0.012 -6.213,3.241 -6.213,6.875Zm6.232,-3.125c-1.562,0 -2.833,1.402 -2.833,3.125c0,0.345 -0.253,0.625 -0.566,0.625c-0.313,0 -0.567,-0.28 -0.567,-0.625c0,-2.413 1.779,-4.375 3.966,-4.375c0.313,0 0.567,0.28 0.567,0.625c0,0.345 -0.254,0.625 -0.567,0.625Z" style="fill:#000000;fill-rule:nonzero;"/></svg>',
                'keywords'        => array( 'content' ),
                'mode'            => 'edit'
            ) );

            if( function_exists( 'acf_add_local_field_group' ) ) {

                acf_add_local_field_group( array(
                    'key'                   => 'group_5c64241a4ee41',
                    'title'                 => 'Here\'s an idea Block',
                    'fields'                => array(
                        array(
                            'key'               => 'field_5c64243e2460c',
                            'label'             => 'Here\'s an Idea Content',
                            'name'              => 'content',
                            'type'              => 'wysiwyg',
                            'instructions'      => '',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'default_value'     => '',
                            'tabs'              => 'all',
                            'toolbar'           => 'full',
                            'media_upload'      => 1,
                            'delay'             => 0,
                        ),
                    ),
                    'location'              => array(
                        array(
                            array(
                                'param'    => 'block',
                                'operator' => '==',
                                'value'    => 'acf/red-ppb-idea',
                            ),
                        ),
                    ),
                    'menu_order'            => 0,
                    'position'              => 'normal',
                    'style'                 => 'seamless',
                    'label_placement'       => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen'        => '',
                    'active'                => 1,
                    'description'           => '',
                ) );

            }

            /*
             * register a Why block
             */
            acf_register_block_type( array(
                'name'            => 'red_ppb_why',
                'title'           => __( 'Why' ),
                'description'     => __( 'Why.' ),
                'render_callback' => array( $red_ppb_init, 'red_ppb_block_render_callback' ),
                'category'        => 'ppb-blocks',
                'icon'            => '<svg width="100%" height="100%" viewBox="0 0 21 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><path d="M10.01,0.25c-5.523,0 -10,3.637 -10,8.125c0,1.938 0.836,3.711 2.227,5.105c-0.489,1.969 -2.122,3.723 -2.141,3.743c-0.086,0.09 -0.109,0.222 -0.059,0.34c0.051,0.117 0.161,0.187 0.286,0.187c2.589,0 4.531,-1.242 5.492,-2.008c1.277,0.481 2.695,0.758 4.195,0.758c5.523,0 10,-3.637 10,-8.125c0,-4.488 -4.477,-8.125 -10,-8.125Zm0,13.125c-0.691,0 -1.25,-0.559 -1.25,-1.25c0,-0.691 0.559,-1.25 1.25,-1.25c0.691,0 1.25,0.559 1.25,1.25c0,0.691 -0.559,1.25 -1.25,1.25Zm0.992,-4.313c-0.031,0.321 -0.301,0.563 -0.621,0.563l-0.742,0c-0.32,0 -0.59,-0.242 -0.621,-0.563l-0.5,-5c-0.035,-0.367 0.254,-0.687 0.621,-0.687l1.742,0c0.371,0 0.66,0.32 0.621,0.688l-0.5,4.999Z" style="fill:#000000;fill-rule:nonzero;"/></svg>',
                'keywords'        => array( 'content' ),
                'mode'            => 'edit'
            ) );

            if( function_exists( 'acf_add_local_field_group' ) ) {

                acf_add_local_field_group( array(
                    'key'                   => 'group_5c643c17672f7',
                    'title'                 => 'Why Block',
                    'fields'                => array(
                        array(
                            'key'               => 'field_5c643c176d7cb',
                            'label'             => 'Why Content',
                            'name'              => 'content',
                            'type'              => 'wysiwyg',
                            'instructions'      => '',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'default_value'     => '',
                            'tabs'              => 'all',
                            'toolbar'           => 'full',
                            'media_upload'      => 1,
                            'delay'             => 0,
                        ),
                    ),
                    'location'              => array(
                        array(
                            array(
                                'param'    => 'block',
                                'operator' => '==',
                                'value'    => 'acf/red-ppb-why',
                            ),
                        ),
                    ),
                    'menu_order'            => 0,
                    'position'              => 'normal',
                    'style'                 => 'seamless',
                    'label_placement'       => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen'        => '',
                    'active'                => 1,
                    'description'           => '',
                ) );

            }

            /*
             * register a For Leaders block
             */
            acf_register_block_type( array(
                'name'            => 'red_ppb_for_leaders',
                'title'           => __( 'For Leaders' ),
                'description'     => __( 'For Leaders.' ),
                'render_callback' => array( $red_ppb_init, 'red_ppb_block_render_callback' ),
                'category'        => 'ppb-blocks',
                'icon'            => '<svg width="100%" height="100%" viewBox="0 0 18 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><path d="M8.972,10c2.761,0 5,-2.238 5,-5c0,-2.762 -2.239,-5 -5,-5c-2.762,0 -5,2.238 -5,5c0,2.762 2.238,5 5,5Zm3.742,1.273l-1.867,7.477l-1.25,-5.313l1.25,-2.187l-3.75,0l1.25,2.187l-1.25,5.313l-1.868,-7.477c-2.785,0.133 -5.007,2.411 -5.007,5.227l0,1.625c0,1.035 0.839,1.875 1.875,1.875l13.75,0c1.035,0 1.875,-0.84 1.875,-1.875l0,-1.625c0,-2.816 -2.223,-5.094 -5.008,-5.227Z" style="fill:#000000;fill-rule:nonzero;"/></svg>',
                'keywords'        => array( 'content' ),
                'mode'            => 'edit',
                'post_types' => array('ppb-activities'),
            ) );

            if( function_exists( 'acf_add_local_field_group' ) ) {

                acf_add_local_field_group( array(
                    'key'                   => 'group_5c643c3703d7e',
                    'title'                 => 'For Leaders Block',
                    'fields'                => array(
                        array(
                            'key'               => 'field_5c643c370a66b',
                            'label'             => 'For Leaders Content',
                            'name'              => 'content',
                            'type'              => 'wysiwyg',
                            'instructions'      => '',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'default_value'     => '',
                            'tabs'              => 'all',
                            'toolbar'           => 'full',
                            'media_upload'      => 1,
                            'delay'             => 0,
                        ),
                    ),
                    'location'              => array(
                        array(
                            array(
                                'param'    => 'block',
                                'operator' => '==',
                                'value'    => 'acf/red-ppb-for-leaders',
                            ),
                        ),
                    ),
                    'menu_order'            => 0,
                    'position'              => 'normal',
                    'style'                 => 'seamless',
                    'label_placement'       => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen'        => '',
                    'active'                => 1,
                    'description'           => '',
                ) );

            }

            /*
             * register a Did You Know block
             */
            acf_register_block_type( array(
                'name'            => 'red_ppb_did_you_know',
                'title'           => __( 'Did You Know' ),
                'description'     => __( 'Did You Know.' ),
                'render_callback' => array( $red_ppb_init, 'red_ppb_block_render_callback' ),
                'category'        => 'ppb-blocks',
                'icon'            => '<svg width="100%" height="100%" viewBox="0 0 21 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><path d="M10.962,0.25c-5.524,0 -10,3.637 -10,8.125c0,1.938 0.836,3.711 2.226,5.105c-0.488,1.969 -2.121,3.723 -2.14,3.743c-0.086,0.09 -0.11,0.222 -0.059,0.34c0.051,0.117 0.16,0.187 0.285,0.187c2.59,0 4.532,-1.242 5.493,-2.008c1.277,0.481 2.695,0.758 4.195,0.758c5.523,0 10,-3.637 10,-8.125c0,-4.488 -4.477,-8.125 -10,-8.125Zm1.25,10.313c0,0.171 -0.141,0.312 -0.313,0.312l-5.625,0c-0.171,0 -0.312,-0.141 -0.312,-0.313l0,-0.624c0,-0.172 0.141,-0.313 0.312,-0.313l5.625,0c0.172,0 0.313,0.141 0.313,0.313l0,0.625Zm3.75,-3.75c0,0.171 -0.141,0.312 -0.313,0.312l-9.375,0c-0.171,0 -0.312,-0.141 -0.312,-0.312l0,-0.625c0,-0.172 0.141,-0.313 0.312,-0.313l9.375,0c0.172,0 0.313,0.141 0.313,0.313l0,0.625Z" style="fill:#000000;fill-rule:nonzero;"/></svg>',
                'keywords'        => array( 'content' ),
                'mode'            => 'edit'
            ) );

            if( function_exists( 'acf_add_local_field_group' ) ) {

                acf_add_local_field_group( array(
                    'key'                   => 'group_5c643c512450e',
                    'title'                 => 'Did You Know Block',
                    'fields'                => array(
                        array(
                            'key'               => 'field_5c643c5129b5f',
                            'label'             => 'Did you know Content',
                            'name'              => 'content',
                            'type'              => 'wysiwyg',
                            'instructions'      => '',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'default_value'     => '',
                            'tabs'              => 'all',
                            'toolbar'           => 'full',
                            'media_upload'      => 1,
                            'delay'             => 0,
                        ),
                    ),
                    'location'              => array(
                        array(
                            array(
                                'param'    => 'block',
                                'operator' => '==',
                                'value'    => 'acf/red-ppb-did-you-know',
                            ),
                        ),
                    ),
                    'menu_order'            => 0,
                    'position'              => 'normal',
                    'style'                 => 'seamless',
                    'label_placement'       => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen'        => '',
                    'active'                => 1,
                    'description'           => '',
                ) );

            }

            /*
             * register a Age Group block
             */
            acf_register_block_type( array(
                'name'            => 'red_ppb_age_group',
                'title'           => __( 'Age Group' ),
                'description'     => __( 'Age Group.' ),
                'render_callback' => array( $red_ppb_init, 'red_ppb_block_render_callback' ),
                'category'        => 'ppb-blocks',
                'icon'            => '<svg width="100%" height="100%" viewBox="0 0 20 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><path d="M3,5.999c1.103,0 2,-0.897 2,-2c0,-1.103 -0.897,-2 -2,-2c-1.103,0 -2,0.897 -2,2c0,1.103 0.897,2 2,2Zm14,0c1.103,0 2,-0.897 2,-2c0,-1.103 -0.897,-2 -2,-2c-1.103,0 -2,0.897 -2,2c0,1.103 0.897,2 2,2Zm1,1l-2,0c-0.55,0 -1.047,0.222 -1.409,0.581c1.259,0.691 2.153,1.938 2.347,3.419l2.062,0c0.553,0 1,-0.447 1,-1l0,-1c0,-1.103 -0.897,-2 -2,-2Zm-8,0c1.934,0 3.5,-1.566 3.5,-3.5c0,-1.935 -1.566,-3.5 -3.5,-3.5c-1.934,0 -3.5,1.565 -3.5,3.5c0,1.934 1.566,3.5 3.5,3.5Zm2.4,1l-0.259,0c-0.65,0.312 -1.372,0.5 -2.141,0.5c-0.769,0 -1.488,-0.188 -2.141,-0.5l-0.259,0c-1.987,0 -3.6,1.612 -3.6,3.6l0,0.9c0,0.828 0.672,1.5 1.5,1.5l9,0c0.828,0 1.5,-0.672 1.5,-1.5l0,-0.9c0,-1.988 -1.613,-3.6 -3.6,-3.6Zm-6.991,-0.419c-0.362,-0.359 -0.859,-0.581 -1.409,-0.581l-2,0c-1.103,0 -2,0.897 -2,2l0,1c0,0.553 0.447,1 1,1l2.059,0c0.197,-1.481 1.091,-2.728 2.35,-3.419Z" style="fill:#000000;fill-rule:nonzero;"/></svg>',
                'keywords'        => array( 'content' ),
                'mode'            => 'edit'
            ) );

            if( function_exists( 'acf_add_local_field_group' ) ) {

                acf_add_local_field_group( array(
                    'key'                   => 'group_5c643c8649e4c',
                    'title'                 => 'Age Group Block',
                    'fields'                => array(
                        array(
                            'key'               => 'field_5c64497317332',
                            'label'             => 'Age Group',
                            'name'              => 'title',
                            'type'              => 'taxonomy',
                            'instructions'      => '',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'taxonomy'          => 'ppb-activity-age',
                            'field_type'        => 'select',
                            'allow_null'        => 0,
                            'add_term'          => 0,
                            'save_terms'        => 0,
                            'load_terms'        => 0,
                            'return_format'     => 'object',
                            'multiple'          => 0,
                        ),
                        array(
                            'key'               => 'field_5c643c864ee91',
                            'label'             => 'Age Group Content',
                            'name'              => 'content',
                            'type'              => 'wysiwyg',
                            'instructions'      => '',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'default_value'     => '',
                            'tabs'              => 'all',
                            'toolbar'           => 'full',
                            'media_upload'      => 1,
                            'delay'             => 0,
                        ),
                    ),
                    'location'              => array(
                        array(
                            array(
                                'param'    => 'block',
                                'operator' => '==',
                                'value'    => 'acf/red-ppb-age-group',
                            ),
                        ),
                    ),
                    'menu_order'            => 0,
                    'position'              => 'normal',
                    'style'                 => 'seamless',
                    'label_placement'       => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen'        => '',
                    'active'                => 1,
                    'description'           => '',
                ) );

            }

            /*
             *
             * Activity Badges
             *
             */
            if( function_exists('acf_add_local_field_group') ) {
                acf_add_local_field_group( array(
                    'key'                   => 'group_5c66caa7ac6c4',
                    'title'                 => 'Badges',
                    'fields'                => array(
                        array(
                            'key'               => 'field_5c66cac35941f',
                            'label'             => 'Badges',
                            'name'              => 'badges',
                            'type'              => 'relationship',
                            'instructions'      => '',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'post_type'         => array(
                                0 => 'product',
                            ),
                            'taxonomy'          => array(
                                0 => 'product_cat:badges'
                            ),
                            'filters'           => array(
                                0 => 'search',
                            ),
                            'elements'          => '',
                            'min'               => '',
                            'max'               => '',
                            'return_format'     => 'id',
                        ),
                    ),
                    'location'              => array(
                        array(
                            array(
                                'param'    => 'post_type',
                                'operator' => '==',
                                'value'    => 'ppb-activities',
                            ),
                        ),
                    ),
                    'menu_order'            => 1,
                    'position'              => 'side',
                    'style'                 => 'default',
                    'label_placement'       => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen'        => '',
                    'active'                => 1,
                    'description'           => '',
                ) );

            }
        }
    }

    function red_ppb_block_category( $categories, $post ) {
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

    function red_ppb_allowed_block_types( $allowed_block_types, $post ) {

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
