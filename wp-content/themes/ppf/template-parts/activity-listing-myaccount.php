<?php

$activity_class = '';
$activity_class .= 'type_'.wp_get_post_terms(get_the_ID() , array('taxonomy' => 'ppb-activity-type'))[0]->name;
$checked_image_id = get_term_meta(wp_get_post_terms(get_the_ID() , array('taxonomy' => 'ppb-activity-type'))[0]->term_id , 'checked_image' , true);
$checked_image_url = wp_get_attachment_url($checked_image_id);

?>

<li class="<?=$activity_class?>" id="activity_<?=get_the_ID()?>">
    <div class="inner-container">
        <div class="image-container">
            <h2><?=the_title()?></h2>
            <div class="activity-order-actions">
                <a href="" class="activity-order-actions-btn left"> < </a>
                <p>Change Order</p>
                <a href="" class="activity-order-actions-btn right"> > </a>
            </div>
        </div>
        <div class="actions">
            <div class="icon">
                <img style="width: 64px;" src="<?=$checked_image_url?>" alt="">
            </div>
            <a href="<?=the_permalink()?>">View Activity Card</a>
            <input type="hidden" name="activities[]" value="<?=the_ID()?>">
        </div>
    </div>
</li>