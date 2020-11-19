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
    <div class="badges-block">
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

    <div class="subjects-block">
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

    <br clear="all">

    <div class="second-row">

        <div class="cost-block">
            <h2>Cost</h2>
            <ul>
                <li <?=(array_search('FREE', array_column($price, 'name')) !== false) ? 'class="active"' : ''?>>FREE</li>
                <li <?=(array_search('£', array_column($price, 'name')) !== false) ? 'class="active"' : ''?>>£</li>
                <li <?=(array_search('££', array_column($price, 'name')) !== false) ? 'class="active"' : ''?>>££</li>
                <li <?=(array_search('£££', array_column($price, 'name')) !== false) ? 'class="active"' : ''?>>£££</li>
            </ul>
        </div>
        <div class="indoors-block">
            <h2>Indoors/Outdoors</h2>
            <ul>
                <li <?=(array_search('Indoors', array_column($environment, 'name')) !== false) ? 'class="active"' : ''?>>Indoors</li>
                <li <?=(array_search('Outdoors', array_column($environment, 'name')) !== false) ? 'class="active"' : ''?>>Outdoors</li>
            </ul>
        </div>
        <div class="time-block">
            <h2>Day/Night</h2>
            <ul>
                <li <?=(array_search('Day', array_column($time, 'name')) !== false) ? 'class="active"' : ''?>>Day</li>
                <li <?=(array_search('Night', array_column($time, 'name')) !== false) ? 'class="active"' : ''?>>Night</li>
            </ul>
        </div>
        <div class="ages-block">
            <h2>Ages</h2>
            <ul>
                <li <?=(array_search('3 - 5', array_column($ages, 'name')) !== false) ? 'class="active"' : ''?>>3-5</li>
                <li <?=(array_search('5 - 7', array_column($ages, 'name')) !== false) ? 'class="active"' : ''?>>5-7</li>
                <li <?=(array_search('7 - 11', array_column($ages, 'name')) !== false) ? 'class="active"' : ''?>>7-11</li>
                <li <?=(array_search('11 - 14', array_column($ages, 'name')) !== false) ? 'class="active"' : ''?>>11-14</li>
                <li <?=(array_search('14 - 18', array_column($ages, 'name')) !== false) ? 'class="active"' : ''?>>14-18</li>
            </ul>
        </div>
        <div class="season-block">
            <h2>Seasons</h2>
            <ul>
                <li <?=(array_search('Spring', array_column($seasons, 'name')) !== false) ? 'class="active"' : ''?>>Spring</li>
                <li <?=(array_search('Summer', array_column($seasons, 'name')) !== false) ? 'class="active"' : ''?>>Summer</li>
                <li <?=(array_search('Autumn', array_column($seasons, 'name')) !== false) ? 'class="active"' : ''?>>Autumn</li>
                <li <?=(array_search('Winter', array_column($seasons, 'name')) !== false) ? 'class="active"' : ''?>>Winter</li>
            </ul>
        </div>

    </div>

    <div class="third-row">

        <div class="equipment-block">
            <h2>Equipment</h2>
            <ul>
                <?php foreach($equipment as $item){ ?>
                    <li><?php echo $item->name ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="skills-block">
            <h2>Skills</h2>
            <ul>
                <?php foreach($skills as $item){ ?>
                    <li><?php echo $item->name ?></li>
                <?php } ?>
            </ul>
        </div>

    </div>

</div>

