<?php

/**
 *
 * Plugin Name: Pawprint Challengepacks
 * Plugin URI: https://www.inlife.co.uk/
 * Version: 1.0
 *
 */

register_activation_hook( __FILE__, 'pp_challenge_packs_create_db' );

function pp_challenge_packs_create_db() {

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'challenge_packs';

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		uid varchar(255) NULL,
		user_id mediumint(9) NOT NULL,
		name varchar(255) NOT NULL,
		badge mediumint(9) NULL,
		activities varchar(255) NULL,
		ages varchar(255) NULL,
		date_created DATETIME NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

}

add_action( 'wp_ajax_pp_create_challenge_pack', 'pp_create_challenge_pack' );
add_action( 'wp_ajax_nopriv_pp_create_challenge_pack', 'pp_create_challenge_pack' );

function pp_create_challenge_pack(){

    global $wpdb;
    $table_name = $wpdb->prefix . 'challenge_packs';

    $data = array(
        'user_id' => $_POST['user_id'],
        'uid' => uniqid('ppf_'),
        'name' => $_POST['name'],
        'badge' => $_POST['badge'],
        'activities' => $_POST['activities'],
        'ages' => $_POST['ages'],
        'date_created' => date('c')
    );

    $insert_id = $wpdb->insert($table_name , $data);

    echo json_encode(array('pack_id' => $insert_id));

    die();

}

function pp_get_challenge_packs($userid){

    global $wpdb;
    $table_name = $wpdb->prefix . 'challenge_packs';

    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = $userid");

    return $results;

}

function pp_get_challenge_pack($user_id , $pack_id){

    global $wpdb;
    $table_name = $wpdb->prefix . 'challenge_packs';

    $sql = 'SELECT * FROM '.$table_name.' WHERE user_id = '.$user_id.' AND uid = "'.$pack_id.'"';

    $results = $wpdb->get_row($sql , OBJECT);
    $results->ages = unserialize($results->ages);

    if($results->activities != ''){
        $results->activities = unserialize($results->activities);
    }else{
        $results->activities = array();
    }

    return $results;

}

add_action( 'wp_ajax_get_badges_ajax', 'get_badges_ajax' );
add_action( 'wp_ajax_nopriv_get_badges_ajax', 'get_badges_ajax' );

function get_badges_ajax(){

    $currentBadge = $_POST['currentBadge'];

    $badges = new WP_Query(
        array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => array(16)
                )
            )
        )
    );

    if($badges->have_posts()){

        while ($badges->have_posts()){ $badges->the_post();

            if($badges->post->ID == $currentBadge){
                echo '<option selected value="'.$badges->post->ID.'">'.get_the_title($badges->post->ID).'</option>';
            }else{
                echo '<option value="'.$badges->post->ID.'">'.get_the_title($badges->post->ID).'</option>';
            }

        }

    }

    die();

}

add_action( 'wp_ajax_pp_update_challenge_pack', 'pp_update_challenge_pack' );
add_action( 'wp_ajax_nopriv_pp_update_challenge_pack', 'pp_update_challenge_pack' );

function pp_update_challenge_pack(){

    global $wpdb;
    $table_name = $wpdb->prefix . 'challenge_packs';

    $data = array(
        'name' => $_POST['name'],
        'badge' => $_POST['badge'],
        'activities' => serialize($_POST['activities']),
        'ages' => serialize($_POST['ages'])
    );

    $update = $wpdb->update($table_name , $data , array('uid' => $_POST['uid']));

    echo json_encode(array('code' => 200));

    die();


}

add_action( 'wp_ajax_pp_add_activity_popup', 'pp_add_activity_popup' );
add_action( 'wp_ajax_nopriv_pp_add_activity_popup', 'pp_add_activity_popup' );

function pp_add_activity_popup(){

    ob_start();
    include 'add-activity-popup.php';
    echo ob_get_clean();

}

add_action( 'wp_ajax_pp_add_activity_challenge_pack', 'pp_add_activity_challenge_pack' );
add_action( 'wp_ajax_nopriv_pp_add_activity_challenge_pack', 'pp_add_activity_challenge_pack' );

function pp_add_activity_challenge_pack(){

    global $wpdb;
    $table_name = $wpdb->prefix . 'challenge_packs';

    $pack = pp_get_challenge_pack(get_current_user_id() , $_POST['pack']);

    if(!empty($pack->activities)){
        $activities = $pack->activities;
    }else{
        $activities = array();
    }

    array_push($activities , $_POST['activity_id']);

    $data = array(
        'activities' => serialize($activities),
    );

    $update = $wpdb->update($table_name , $data , array('uid' => $_POST['pack']));

    if($update){
        echo json_encode(array('code' => 200));
    }

    die();

}

function my_account_new_endpoints() {
    add_rewrite_endpoint( 'packs', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'groups', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'my_orders', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'my_account_new_endpoints' );

function ppb_packs_query_vars( $vars )
{
    $vars[] = 'packs';
    $vars[] = 'groups';
    return $vars;
}
add_filter( 'query_vars', 'ppb_packs_query_vars', 0 );

function ppb_woo_my_account_order($menu_links) {

    $menu_links = array(
        'edit-account' => __( 'Profile', 'woocommerce' ),
        'orders' => __( 'Orders', 'woocommerce' ),
        'packs' => __( 'Challenge Packs', 'woocommerce' ),
        'edit-address' => __( 'Addresses', 'woocommerce' ),
    );

    return $menu_links;

}
add_filter( 'woocommerce_account_menu_items', 'ppb_woo_my_account_order' );

function packs_endpoint_content() {
    ob_start();
    if(isset($_GET['action']) && $_GET['action'] == 'edit'){
        include get_template_directory().'/woocommerce/myaccount/packs/edit.php';
    }else{
        include get_template_directory().'/woocommerce/myaccount/packs/list.php';
    }
    echo ob_get_clean();
}
add_action( 'woocommerce_account_packs_endpoint', 'packs_endpoint_content' );


add_action( 'wp_ajax_getBadgeImageUrl', 'getBadgeImageUrl' );
add_action( 'wp_ajax_nopriv_getBadgeImageUrl', 'getBadgeImageUrl' );

function getBadgeImageUrl(){

    echo get_the_post_thumbnail_url($_POST['badge']);
    die();

}


add_action( 'wp_ajax_deleteChallengePack', 'deleteChallengePack' );
add_action( 'wp_ajax_nopriv_deleteChallengePack', 'deleteChallengePack' );

function deleteChallengePack(){

    global $wpdb;
    $table_name = $wpdb->prefix . 'challenge_packs';

    $wpdb->delete($table_name , array('uid' => $_POST['challenge_pack_id']));

    echo json_encode(array('code' => 200));

}