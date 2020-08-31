<?php

$badges = get_field('badges' , get_the_ID());

$all_ages = get_terms(array('taxonomy' => 'ppb-activity-age' , 'hide_empty' => 0));
$all_seasons = get_terms(array('taxonomy' => 'ppb-activity-season' , 'hide_empty' => 0));

asort($all_ages);
asort($all_seasons);

$ages = wp_get_post_terms(get_the_ID() , 'ppb-activity-age');
$subject = wp_get_post_terms(get_the_ID() , 'ppb-activity-subject');
$seasons = wp_get_post_terms(get_the_ID() , 'ppb-activity-season');
$time = wp_get_post_terms(get_the_ID() , 'ppb-activity-time');
$environment = wp_get_post_terms(get_the_ID() , 'ppb-activity-environment');
$skills = wp_get_post_terms(get_the_ID() , 'ppb-activity-soft-skills');
$equipment = wp_get_post_terms(get_the_ID() , 'ppb-activity-equipment');
$price = wp_get_post_terms(get_the_ID() , 'ppb-activity-price');

asort($ages);
asort($subject);
asort($seasons);
asort($time);
asort($environment);
asort($skills);
asort($equipment);
asort($price);

?>

<h2 class="main_header">Activity details</h2>
<div class="activity-details">
    <div>
        <h2>This activity counts towards...</h2>
        <div class="badges">
            <?php
                foreach($badges as $badge){
                    ?>
                        <a href="<?=get_the_permalink($badge)?>" class="badge">
                            <?php echo get_the_post_thumbnail($badge) ?>
                            <p><?php echo get_the_title($badge) ?></p>
                        </a>
                    <?php
                }
            ?>
        </div>
    </div>
    <input type="hidden" name="image_1_for_pdf">
    <input type="hidden" name="image_2_for_pdf">
    <input type="hidden" name="image_3_for_pdf">
    <div id="pdf-image-1">
        <section>
            <span><img src="<?=get_site_url().'/wp-content/themes/rareearth/library/images/icons/price.png'?>" alt=""></span>
            <p>
                <?php
                    $i = 0;
                    foreach ($price as $item){
                        $i++;
                        echo $item->name;
                        if($i != count($price)){
                            echo ',';
                        }
                    }
                ?>
            </p>
        </section>
        <section>
            <span>
                <?php
                    $environments = array();
                    foreach ($environment as $item){
                        $environments[] = $item->name;
                    }

                    if(count($environments) == 1 && in_array('Indoors' , $environments)){
                        ?>
                            <img src="<?=get_site_url().'/wp-content/themes/rareearth/library/images/icons/indoors.png'?>" alt="">
                        <?php
                    }elseif(count($environments) == 1 && in_array('Outdoors' , $environments)){
                        ?>
                             <img src="<?=get_site_url().'/wp-content/themes/rareearth/library/images/icons/outdoors.png'?>" alt="">
                        <?php
                    }else{
                        ?>
                            <img src="<?=get_site_url().'/wp-content/themes/rareearth/library/images/icons/indoors-outdoors.png'?>" alt="">
                        <?php
                    }

                ?>
            </span>
            <p>
                <?php
                    $i = 0;
                    foreach ($environment as $item){
                        $i++;
                        echo $item->name;
                        if($i != count($environment)){
                            echo '/';
                        }
                    }
                ?>
            </p>
        </section>
        <section>
            <span>

                <?php
                    $times = array();
                    foreach ($time as $item){
                        $times[] = $item->name;
                    }

                    if(count($times) == 1 && in_array('Day' , $times)){
                        ?>
                        <img src="<?=get_site_url().'/wp-content/themes/rareearth/library/images/icons/day.png'?>" alt="">
                        <?php
                    }elseif(count($times) == 1 && in_array('Night' , $times)){
                        ?>
                        <img src="<?=get_site_url().'/wp-content/themes/rareearth/library/images/icons/night.png'?>" alt="">
                        <?php
                    }else{
                        ?>
                        <img src="<?=get_site_url().'/wp-content/themes/rareearth/library/images/icons/day-night.png'?>" alt="">
                        <?php
                    }

                ?>

            </span>
            <p>
                <?php
                    $i = 0;
                    foreach ($time as $item){
                        $i++;
                        echo $item->name;
                        if($i != count($time)){
                            echo '/';
                        }
                    }
                ?>
            </p>
        </section>
    </div>
    <div id="pdf-image-2">
        <?php
            foreach($all_ages as $age){

                ?>

                    <section>
                        <span <?=(in_array($age , $ages)) ? 'class="checked"' : ''?>></span>
                        <p><?=$age->name?></p>
                    </section>

                <?php

            }
        ?>
    </div>
    <div id="pdf-image-3">
        <?php
        foreach($all_seasons as $season){

            ?>

            <section class="square">
                <span <?=(in_array($season , $seasons)) ? 'class="checked"' : ''?>></span>
                <p><?=$season->name?></p>
            </section>

            <?php

        }
        ?>
    </div>
    <div>

        <div class="activity-sidebar-tabs">
            <div class="tabs">
                <a href="" data-toggle="equipment">Equipment</a>
                <a href="" data-toggle="skills">Skills</a>
            </div>
            <div class="content">
                <div class="tab-content" data-tab="equipment">
                    <ul>
                        <?php foreach($equipment as $item){ ?>
                            <li><?php echo $item->name ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="tab-content" data-tab="skills">
                    <ul>
                        <?php foreach($skills as $item){ ?>
                            <li><?php echo $item->name ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <script>

            $ = jQuery;

            $('.activity-sidebar-tabs .tabs a').click(function (e) {

                e.preventDefault();

                $('.activity-sidebar-tabs .tabs a').removeClass('active');
                $(this).addClass('active');

                var tab = $(this).data('toggle');

                $('.tab-content').hide();
                $('.tab-content[data-tab="'+tab+'"]').show();

            });

            $('.activity-sidebar-tabs .tabs a').first().click();

        </script>

    </div>
    <div>
        <h2>Related Subjects...</h2>
        <ul class="subjects">
            <?php foreach ($subject as $item){ ?>
                <li>
                    <span>
                        <img src='<?=get_template_directory_uri().'/assets/icons/subjects/'?><?=$item->slug?>.png' alt="">
                    </span>
                    <?=$item->name?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

