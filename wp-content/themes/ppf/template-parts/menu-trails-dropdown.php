<?php
$trails = new WP_Query(
    array(
        'post_type' => 'product',
        'posts_per_page' => 6,
        'orderBy' => 'ID',
        'post_status' => 'publish',
        'order' => DESC,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => 'trails'
            )
        )
    )
);
?>
<div class="menu-dropdown trails">
    <div class="left">
        <?php dynamic_sidebar('menu-dropdown-3') ?>
    </div>
    <div class="right">
        <h2>Our Latest Trails</h2>
        <div class="latest-carousel owl-carousel">
            <?php
            if($trails->have_posts()){
                while ($trails->have_posts()){ $trails->the_post();
                    echo '<a href="'.get_the_permalink($trails->post->ID).'"><img src="'.get_the_post_thumbnail_url($trails->post->ID).'" alt=""></a>';
                }
            }
            ?>
        </div>
    </div>
</div>