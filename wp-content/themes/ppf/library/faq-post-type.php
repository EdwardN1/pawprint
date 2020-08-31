<?php

add_action( 'init' , 'add_faq_post_type' );

function add_faq_post_type()
{

    register_post_type(
        'faq',
        array(
            'label' => 'Faqs',
            'public' => true,
            'rewrite' => array(
                'slug' => 'faqs',
            )
        )
    );

    register_taxonomy(
        'faq-type',
        'faq',
        array(
            'label' => 'Faq Type',
            'public' => true,
            'hierarchical' => true,
            'show_admin_column' => true
        )
    );

}