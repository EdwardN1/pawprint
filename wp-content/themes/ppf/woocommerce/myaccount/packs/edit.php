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

        <label for="badge_select">
            Badge
            <select name="_badge" id="badge_select">
            </select>
        </label>

        <?php $ages = get_terms(array('taxonomy' => 'ppb-activity-age' , 'hide_empty' => false)); asort($ages); ?>

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
                activities: []
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

    </script>

</form>