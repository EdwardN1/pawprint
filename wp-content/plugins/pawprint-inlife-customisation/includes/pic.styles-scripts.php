<?php

    add_action('admin_enqueue_scripts' , 'pic_styles_scripts');

    function pic_styles_scripts(){

        wp_enqueue_script('MOMENT' , 'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js' , '' , '' , true);
        wp_enqueue_script('DATE RANGE' , 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js' , '' , '' , true);
        wp_enqueue_script('PIC' , PIC_ASSETS_URL.'js/pic.js' , '' , '' , true);

        wp_enqueue_style('DATE RANGE' , 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css');

    }

?>