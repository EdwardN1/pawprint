<?php

    add_action( 'init', 'vc_before_init_actions' );

    function vc_before_init_actions() {
        require_once( 'pawprint-button.php' );
        require_once( 'pawprint-breadcrumbs.php' );
        require_once( 'pawprint-faqs-block.php' );
    }