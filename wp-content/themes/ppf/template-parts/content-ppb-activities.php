<?php

    $activity_class = '';
    $activity_class .= 'type_'.wp_get_post_terms(get_the_ID() , array('taxonomy' => 'ppb-activity-type'))[0]->name;
    $checked_image_id = get_term_meta(wp_get_post_terms(get_the_ID() , array('taxonomy' => 'ppb-activity-type'))[0]->term_id , 'checked_image' , true);
    $checked_image_url = wp_get_attachment_url($checked_image_id);

    $blocks = parse_blocks( get_the_content() );

    $ageBlocks = array();
    $ageIds = array();
    foreach ($blocks as $block) {

        if ($block['blockName'] == "acf/red-ppb-age-group") {
            $key = $block['attrs']['data']['title'];
            $ageIds[] = $key;
            $ageBlocks[$key] = $block['attrs']['data']['content'];
        }

    }

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="activity_banner <?=$activity_class?>">
        <h2><?=the_title()?></h2>
        <img src="<?=$checked_image_url?>" alt="">
    </div>

    <?php echo do_shortcode('[vc_pawprint_breadcrumbs_block]'); ?>

    <div class="left-section">
        <div class="activity_actions">

            <?php if(!is_user_logged_in()){ ?>
                <span class="pp-btn pink lrm-login">Save to Challenge Pack</span>
            <?php }else{ ?>
                <span class="save-to-challenge-pack-toggle pp-btn pink" data-activity-id="<?=the_ID()?>">Save to Challenge Pack</span>
            <?php } ?>

            <a href="<?=get_site_url().'/print-pack?activity_id='.get_queried_object_id()?>" class="pp-btn teal">Download Activity Card</a>

            <a href="https://pawprintfamily.com/product-category/free-resources/?product_category=activity-resources" class="pp-btn yellow">View Activity Resources</a>

        </div>
    </div>

    <div class="sidebar activity-detail">
        <?php get_template_part('template-parts/sidebar' , 'activity'); ?>
    </div>

    <div class="left-section">

        <?php if(!empty($blocks)){ ?>

            <?php the_content(); ?>

            <?php if(!empty($ageBlocks)){ ?>

                <br clear="all">

                <div style="padding: 0 15px;">

                    <h2>Adapt It</h2>

                    <div class="age_tabs">
                        <?php
                        $ages = wp_get_post_terms(get_the_ID() , 'ppb-activity-age');
                        asort($ages);
                        ?>
                        <div class="tab_toggles">
                            <?php

                            foreach($ages as $age){
                                if(in_array($age->term_id , $ageIds)) {
                                    echo '<a href="" data-toggle="' . $age->name . '">Age ' . $age->name . '</a>';
                                }
                            }

                            ?>
                        </div>
                        <div class="tabs">
                            <?php

                            foreach($ages as $age){
                                echo '<div class="tab" data-tab="'.$age->name.'">';
                                echo '<p style="color: #FFF;">'.$ageBlocks[$age->term_id].'</p>';
                                echo '</div>';
                            }

                            ?>
                        </div>
                    </div>

                </div>

                <script>

                    $ = jQuery;

                    /* AGE TABS */

                    $(document).ready(function () {

                        $('.age_tabs .tab_toggles a').first().click();

                    });

                    $('.age_tabs .tab_toggles a').click(function(e){

                        e.preventDefault();
                        var ele = $(this);
                        var tab = ele.data('toggle');

                        ele.siblings().removeClass('current');
                        ele.addClass('current');

                        $('.age_tabs .tabs .tab').stop().hide();
                        setTimeout(function () {
                            $('.age_tabs .tabs .tab[data-tab="'+tab+'"]').stop().show();
                        } , 500);

                    });

                </script>

            <?php } ?>

        <?php }else{ ?>

            <div class="text-center">

                <div class="activity-information-missing">

                    <img style="max-width:400px;" src="<?=get_site_url()?>/wp-content/uploads/2020/03/Rik-Bear-Hard-Hat-01.png" alt="">

                    <div class="">
                        <h2>Additional Information under construction!</h2>
                        <p>We’re working hard in the background to make it even easier to access adventure and will be adding more information to this activity card soon. Please keep checking back as we update the website regularly. Don’t forget you can still save this activity to your own challenge pack or download the activity card using the buttons above.</p>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</article>