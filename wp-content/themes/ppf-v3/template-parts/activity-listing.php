<?php
    $activity_class = '';
    $activity_class .= 'type_'.wp_get_post_terms(get_the_ID() , array('taxonomy' => 'ppb-activity-type'))[0]->name;
    $checked_image_id = get_term_meta(wp_get_post_terms(get_the_ID() , array('taxonomy' => 'ppb-activity-type'))[0]->term_id , 'checked_image' , true);
    $checked_image_url = wp_get_attachment_url($checked_image_id);
?>

<li class="<?=$activity_class?>">
  <div class="inner-container">
      <div class="image-container">
          <h2><a href="<?=the_permalink()?>"><?=mb_strimwidth(get_the_title(), 0, 175, '...');?></a></h2>
          <div class="actions">
              <?php if(!is_user_logged_in()){ ?>
                  <span class="pp-btn navy lrm-login">Save to challenge pack</span>
              <?php }else{ ?>
                  <span class="save-to-challenge-pack-toggle pp-btn navy" data-activity-id="<?=the_ID()?>">Save to challenge pack</span>
              <?php } ?>
          </div>
      </div>
      <div class="actions">
          <div class="icon">
              <img style="width: 64px;" src="<?=$checked_image_url?>" alt="">
          </div>
          <a href="<?=the_permalink()?>">View Activity Card</a>
      </div>
  </div>
</li>