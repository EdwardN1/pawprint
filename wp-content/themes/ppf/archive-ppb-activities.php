<?php get_header(); ?>

<?php
    $page = get_page_by_path('activities' , OBJECT , 'page');
    $content = $page->post_content;
    WPBMap::addAllMappedShortcodes();
    echo apply_filters('the_content', $content);
    $content_css = visual_composer()->parseShortcodesCustomCss( $content );
if ( ! empty( $content_css ) ) { ?>
    <style type="text/css" data-type="vc_shortcodes-custom-css">
        <?php echo strip_tags( $content_css ); ?>
    </style>
<?php } ?>

<?php if (have_posts()){ ?>

    <?php if(isset($_GET['activity-filter'])){ ?>

        <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>

        <div class="results-are-in">
            <h2>The results are in!</h2>
            <p><?=$GLOBALS['wp_query']->found_posts?> results found (showing <?=($paged == 1) ? $paged : $GLOBALS['wp_query']->post_count*($paged-1)?> - <?=($paged == 1) ? $GLOBALS['wp_query']->post_count : $GLOBALS['wp_query']->post_count*$paged?>)</p>
        </div>

    <?php } ?>

    <?php
        echo do_shortcode('[vc_pawprint_breadcrumbs_block]');
    ?>

    <div class="top-pagination">
        <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '<',
                'next_text' => '>',
            ));
        ?>
    </div>

    <?php get_template_part('template-parts/activity' , 'filter'); ?>

    <ul class="activities_listings">
        <?php
            while(have_posts()){ the_post();
                get_template_part('template-parts/activity' , 'listing');
            }
        ?>
    </ul>

    <?php
        the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => '<',
            'next_text' => '>',
        ));
    ?>

<?php } ?>

<?php get_footer(); ?>
