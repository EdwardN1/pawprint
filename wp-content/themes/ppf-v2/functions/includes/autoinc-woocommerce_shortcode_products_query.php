<?php
add_filter( 'woocommerce_shortcode_products_query', 'badge_id_pre_posts', 50, 3 );

function badge_id_pre_posts($query_args, $atts, $loop_name){

    global $wp;
    $current_url = home_url( add_query_arg( array(), $wp->request ) );

    if(strpos($current_url , 'free-resources') && isset($_GET['badge_id'])){

        $badge = $_GET['badge_id'];
        $challengePack = get_field('challenge_pack_pdf' , $badge);
        $attachment = $challengePack['filename'];

        $query_args['meta_query'][] = array(
            'key' => '_downloadable_files',
            'value' => $attachment,
            'compare' => 'LIKE'
        );

    }

    return $query_args;

}