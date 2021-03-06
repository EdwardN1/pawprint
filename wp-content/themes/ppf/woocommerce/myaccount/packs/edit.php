<?php $challengePack = pp_get_challenge_pack(get_current_user_id() , $_GET['id']) ?>

<form action="" id="save_challenge_pack" method="post">

    <div class="breadcrumbs">
        <a href="/my-account/edit-account/">My Account</a>
        &nbsp; > &nbsp;
        <a href="/my-account/packs/">Challenge Packs</a>
        &nbsp; > &nbsp; <?=$challengePack->name?>
    </div>

    <div class="actions">
        <a target="_blank" href="<?php echo esc_url(add_query_arg(array('challenge_id' => $_GET['id']) , site_url('print-pack'))) ?>" class="download">Download</a>
        <button type="submit" name="_save_challenge_pack">Save</button>
    </div>

    <br clear="all">
    <br clear="all">

    <div class="edit-form">

        <label for="name">
            Name
            <input type="text" name="_name" id="name" value="<?=$challengePack->name?>">
        </label>

        <label for="name">
            Date
            <input type="date" name="_download_date" id="date" value="<?=$challengePack->download_date?>">
        </label>

        <label for="badge_select">
            Badge
            <select name="_badge" id="badge_select" required>
            </select>
        </label>

        <?php $ages = get_terms(array('taxonomy' => 'ppb-activity-age' , 'hide_empty' => false)); ?>

        <label for="age_select">
            Age Group <br clear="all">
            <?php foreach ($ages as $age){ ?>
                <p class="age-checkbox">
                    <input type="checkbox" <?=(in_array($age->term_id , $challengePack->ages)) ? 'checked' : ''?> name="ages[]" value="<?=$age->term_id?>"> <?=$age->name?>
                </p>
            <?php } ?>
        </label>

    </div>

    <div class="badge-block-challenge-pack">

        <img src="<?php echo get_the_post_thumbnail_url($challengePack->badge) ?>" alt="">

    </div>

    <br clear="all">

    <strong>Remember: Pawprint Badges is flexible and fun programme designed to help you deliver adventure for all. Please feel free to add, adapt or change activities as you see fit to meet the needs/abilities of your young people.</strong>

    <br>
    <div class="ages-text">
        <p id="3-5" style="margin: 0px; <?=(in_array('63' , $challengePack->ages)) ? 'display:block;' : 'display:none;'?>"> 3 – 5 = For age 3 - 5 we recommend completing a minimum of 3 activities from 3 different sections: craft, food, games, other.</p>
        <p id="5-7" style="margin: 0px; <?=(in_array('40' , $challengePack->ages)) ? 'display:block;' : 'display:none;'?>">5 – 7 = For age 5 - 7 we recommend completing 1 activity from each of the 4 sections: craft, food, games, other.</p>
        <p id="7-11" style="margin: 0px; <?=(in_array('41' , $challengePack->ages)) ? 'display:block;' : 'display:none;'?>">7 – 11 = For age 7 - 11 we recommend completing 1 activity from each of the 4 sections: craft, food, games, other + 1 more of your choice.</p>
        <p id="11-14" style="margin: 0px; <?=(in_array('38' , $challengePack->ages)) ? 'display:block;' : 'display:none;'?>">11 – 14 = For age 11 - 14 we recommend completing 1 activity from each of the 4 sections: craft, food, games, other + 2 more of your choice.</p>
        <p id="14-18" style="margin: 0px; <?=(in_array('39' , $challengePack->ages)) ? 'display:block;' : 'display:none;'?>">14 – 18 = For age 14 - 18 we recommend completing 1 activity from each of the 4 sections: craft, food, games, other + 3 more of your choice.</p>
    </div>

    <hr>

    <?php

    if(!empty($challengePack->activities)){

        $activities = new WP_Query(
            array(
                'post_type' => 'ppb-activities',
                'post__in' => $challengePack->activities,
                'orderby' => 'post__in'
            )
        );

    }

    ?>

    <ul class="activities_listings columns-4" style="padding-left: 0px;">

        <li>
            <a href="<?php echo get_site_url().'/activities/' ?>" class="add_activity_myaccount">
            </a>
        </li>

        <?php

        if(!empty($challengePack->activities)) {

            if ($activities->have_posts()) {

                while ($activities->have_posts()) {
                    $activities->the_post();

                    include get_template_directory().'/template-parts/activity-listing-myaccount.php';

                }

            }

        }

        ?>

        <br clear="all">

    </ul>

    <script>

        $ = jQuery;

        var data = {
            action : 'get_badges_ajax'
            <?=($challengePack->badge != '') ? ',currentBadge: '.$challengePack->badge : ''?>
        };

        $('body').on('submit' , '#save_challenge_pack' , function () {

            var data = {
                action: 'pp_update_challenge_pack',
                uid: '<?=$_GET['id']?>',
                name: $('input[name="_name"]').val(),
                badge: $('select[name="_badge"]').val(),
                ages: [],
                activities: [],
                download_date: $('input[name="_download_date"]').val()
            };

            $('input[name="ages[]"]').each(function (index,element) {

                var ele = $(element);

                if(ele.is(':checked')){
                    data.ages.push(ele.val());
                }

            });

            $('input[name="activities[]"]').each(function (index,element) {

                var ele = $(element);
                data.activities.push(ele.val());

            });

            $.post('<?=admin_url()?>admin-ajax.php' , data , function (res) {
                var json = JSON.parse(res);
                if(json.code == 200){
                    window.location.reload();
                }
            });

            return false;

        });

        $.post('<?=admin_url()?>admin-ajax.php' , data , function (res) {
            $('select[name="_badge"]').html(res);
        });

        $('body').on('click' , '.activity-order-actions-btn' , function(e){

            e.preventDefault();

            var parent = $(this).parents('li');
            var next_ele = parent.next();
            var prev_ele = parent.prev();

            var next_ele_id = next_ele.attr('id');
            var prev_ele_id = prev_ele.attr('id');

            if($(this).hasClass('right')){

                parent.insertAfter('#'+next_ele_id);

            }else if($(this).hasClass('left')){

                parent.insertBefore('#'+prev_ele_id);

            }

        });

        $('body').on('change' , '#badge_select' , function () {

            var badgeSelectData = {
                action : 'getBadgeImageUrl',
                badge: $(this).val()
            };

            $.post('<?=admin_url()?>admin-ajax.php' , badgeSelectData , function (res) {
                $('.badge-block-challenge-pack img').attr('src' , res);
            });

        });


        $('.age-checkbox input').change(function () {

            var val = $(this).val();

            if($(this).is(':checked')){

                switch (val) {

                    case '63':

                        $('p#3-5').show();
                        break;

                    case '40':

                        $('p#5-7').show();
                        break;

                    case '41':

                        $('p#7-11').show();
                        break;

                    case '38':

                        $('p#11-14').show();
                        break;

                    case '39':

                        $('p#14-18').show();
                        break;

                }

            }else{

                switch (val) {

                    case '63':

                        $('p#3-5').hide();
                        break;

                    case '40':

                        $('p#5-7').hide();
                        break;

                    case '41':

                        $('p#7-11').hide();
                        break;

                    case '38':

                        $('p#11-14').hide();
                        break;

                    case '39':

                        $('p#14-18').hide();
                        break;

                }

            }

        });

    </script>

</form>