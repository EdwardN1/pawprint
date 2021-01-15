<?php

    add_action('save_post' , 'pic_save_product');

    function pic_save_product(){

        global $post;

        if($post->post_type == "product"){

            update_post_meta($post->ID , '_months' , serialize($_POST['_months']));

        }

    }

?>