<?php
$tales = new WP_Query(
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
                'terms' => 'tales'
            )
        )
    )
);
?>

<div class="menu-dropdown tales">
    <div class="left">
        <?php dynamic_sidebar('menu-dropdown-2') ?>
    </div>
    <div class="right">
        <h2>Our Latest Tales</h2>
        <div class="latest-carousel owl-carousel">
            <?php
                if($tales->have_posts()){
                    while ($tales->have_posts()){ $tales->the_post();
                        echo '<a href="'.get_the_permalink($tales->post->ID).'"><img src="'.get_the_post_thumbnail_url($tales->post->ID).'" alt=""></a>';
                    }
                }
            ?>
        </div>
    </div>
</div>