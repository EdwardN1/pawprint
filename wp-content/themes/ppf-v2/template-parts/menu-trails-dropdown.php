<?php
$trails = new WP_Query(
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
                    //echo '<a href="'.get_the_permalink($trails->post->ID).'"><img src="'.get_the_post_thumbnail_url($trails->post->ID).'" alt=""></a>';
                    //echo '<a href="'.get_the_permalink($trails->post->ID).'"><img src="'.get_the_post_thumbnail($trails->post->ID,'thumbnail').'</a>';
                    $img_attribs = wp_get_attachment_image_src(get_post_thumbnail_id($trails->post->ID), 'thumbnail'); // returns an array
                    if ($img_attribs) {
                        ?>
                        <a href="<?php echo get_the_permalink($trails->post->ID);?>"><img src="<?php echo $img_attribs[0]; ?>" width="<?php echo $img_attribs[1]; ?>" height="<?php echo $img_attribs[2]; ?>"></a>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</div>