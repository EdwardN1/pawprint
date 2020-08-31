<?php get_header(); ?>

<?php

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if(isset($_GET['filter'])){

    switch ($_GET['filter']){

        case 'badges' :

            $posts = new WP_Query(
                array(
                    'post_type' => 'product' ,
                    'posts_per_page' => -1,
                    's' => $_GET['s'] ,
                    'paged' => $paged,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'terms' => array('badges'),
                            'field' => 'slug'
                        )
                    )
                )
            );

            break;

        case 'free' :

            $posts = new WP_Query(
                array(
                    'post_type' => 'product' ,
                    'posts_per_page' => -1,
                    's' => $_GET['s'] ,
                    'paged' => $paged,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'terms' => array('free-resources'),
                            'field' => 'slug'
                        )
                    )
                )
            );

            break;

        case 'activities' :

            $posts = new WP_Query(array('post_type' => 'ppb-activities' , 'posts_per_page' => -1 , 's' => $_GET['s'] , 'paged' => $paged));

            break;

    }

}else{

    $posts = new WP_Query(array('s' => $_GET['s'] , 'posts_per_page' => -1));

}

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <div class="search-top">

            <?php do_shortcode('[vc_pawprint_breadcrumbs_block]') ?>

            <div class="woocommerce-pagination">

            </div>

        </div>
        <br clear="all">
        <br clear="all">

        <a href="" class="filter_mobile_toggle">Show Filters</a>
        <div class="pawprint_category_filter_container">

            <?php global $wp; ?>

            <label for="">
                <a href="<?=(isset($_GET['filter'])) ? add_query_arg( array('s' => $_GET['s'] , 'filter' => 'badges')) : add_query_arg( array('s' => $_GET['s'] , 'filter' => 'badges'), home_url( $wp->request ) ) ?>" class="<?=(isset($_GET['filter']) && $_GET['filter'] == "badges") ? 'is-active' : ''?>">
                    <span><img src="<?=(isset($_GET['filter']) && $_GET['filter'] == "badges") ? get_site_url().'/wp-content/uploads/2020/03/collection-search-badges.png' : get_site_url().'/wp-content/uploads/2020/03/collection-search-badges.png'?>" alt=""></span>
                    <p>Badges</p>
                </a>
            </label>

            <label for="">
                <a href="<?=(isset($_GET['filter'])) ? add_query_arg( array('s' => $_GET['s'] , 'filter' => 'free')) : add_query_arg( array('s' => $_GET['s'] , 'filter' => 'free'), home_url( $wp->request ) ) ?>" class="<?=(isset($_GET['filter']) && $_GET['filter'] == "free") ? 'is-active' : ''?>">
                    <span><img src="<?=(isset($_GET['filter']) && $_GET['filter'] == "free") ? get_site_url().'/wp-content/uploads/2020/03/collection-activity-resources-1.png' : get_site_url().'/wp-content/uploads/2020/03/collection-activity-resources.png'?>" alt=""></span>
                    <p>Free Resources</p>
                </a>
            </label>
            <label for="">
                <a href="<?=(isset($_GET['filter'])) ? add_query_arg( array('s' => $_GET['s'] , 'filter' => 'activities')) : add_query_arg( array('s' => $_GET['s'] , 'filter' => 'activities'), home_url( $wp->request ) ) ?>" class="<?=(isset($_GET['filter']) && $_GET['filter'] == "activities") ? 'is-active' : ''?>">
                    <span><img src="<?=(isset($_GET['filter']) && $_GET['filter'] == "activities") ? get_site_url().'/wp-content/uploads/2020/03/collection-search-activities.png' : get_site_url().'/wp-content/uploads/2020/03/collection-search-activities.png'?>" alt=""></span>
                    <p>Activities</p>
                </a>
            </label>

        </div>

        <main id="main" class="search-results m-all t-all d-all cf" role="main">

            <?php if ($posts->have_posts()) :
                ?>
                <div class="wrap-inner">
                    <h1 class="archive-title"><span><?php _e( 'Search Results for:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
                </div>

                <div class="woocommerce">
                    <ul class="activities_listings search-results products columns-5">

                        <?php
                        while ($posts->have_posts()) : $posts->the_post();

                            switch (get_post_type($posts->post->ID)){

                                case 'product':

                                    do_action( 'woocommerce_shop_loop' );
                                    wc_get_template_part( 'content', 'product' );
                                    break;

                                case 'ppb-activities':

                                    get_template_part('template-parts/activity' , 'listing');
                                    break;

                            }

                        endwhile;
                        ?>

                    </ul>
                </div>

            <?php else :

                get_template_part('partial/no_results');

            endif; ?>

        </main>

</div>

<?php get_footer(); ?>
