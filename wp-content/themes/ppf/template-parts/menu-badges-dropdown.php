<?php
    $badges = new WP_Query(
        array(
            'post_type' => 'product',
            'posts_per_page' => 6,
            'orderBy' => 'ID',
            'post_status' => 'publish',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => 'badges'
                )
            )
        )
    );
?>

<div class="menu-dropdown badges">
    <div class="left">
        <?php dynamic_sidebar('menu-dropdown-1') ?>
    </div>
    <div class="right">
        <h2>Our Latest Badges</h2>
        <div class="latest-carousel owl-carousel">
            <?php
                if($badges->have_posts()){
                    while ($badges->have_posts()){ $badges->the_post();
                        echo '<a href="'.get_the_permalink($badges->post->ID).'"><img src="'.get_the_post_thumbnail_url($badges->post->ID).'" alt=""></a>';
                    }
                }
            ?>
        </div>
    </div>
</div>