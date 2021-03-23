<?php

    ini_set('memory_limit' , -1);
    ini_set('max_input_time' , 10000000);
    ini_set('max_execution_time' , 10000000);

    $types = get_terms(array('taxonomy' => 'ppb-activity-type' , 'hide_empty' => false , 'order' => 'ASC' , 'orderBy' => 'slug'));
    $seasons = get_terms(array('taxonomy' => 'ppb-activity-season' , 'hide_empty' => false , 'order' => 'ASC' , 'orderBy' => 'slug'));
    $environment = get_terms(array('taxonomy' => 'ppb-activity-environment' , 'hide_empty' => false , 'order' => 'ASC' , 'orderBy' => 'slug'));
    $time = get_terms(array('taxonomy' => 'ppb-activity-time' , 'hide_empty' => false , 'order' => 'ASC' , 'orderBy' => 'slug'));
    $cost = get_terms(array('taxonomy' => 'ppb-activity-price' , 'hide_empty' => false , 'order' => 'ASC' , 'orderBy' => 'slug'));

    $badges = new WP_Query(
        array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'orderBy' => 'post_title',
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array('badges')
                )
            )
        )
    );


    $ages = get_terms(array('taxonomy' => 'ppb-activity-age' , 'hide_empty' => false , 'order' => 'ASC' , 'orderBy' => 'slug'));
    $skills = get_terms(array('taxonomy' => 'ppb-activity-soft-skills' , 'hide_empty' => false , 'order' => 'ASC' , 'orderBy' => 'slug'));
    $subjects = get_terms(array('taxonomy' => 'ppb-activity-subject' , 'hide_empty' => false , 'order' => 'ASC' , 'orderBy' => 'slug'));

    $selected_types = $_GET['types'];
    $selected_seasons = $_GET['seasons'];
    $selected_environment = $_GET['environment'];
    $selected_time = $_GET['time'];
    $selected_cost = $_GET['costs'];
    $selected_age = $_GET['_age'];
    $selected_badge = $_GET['_badge'];
    $selected_skills = $_GET['_skills'];
    $selected_subject = $_GET['_subject'];

?>

<br clear="all">
<a href="" class="filter_mobile_toggle">Show Filters</a>
<div class="activity-filter">
    <form action="<?=get_site_url().'/activities/'?>" id="activity_filter_form" method="get">

        <input type="hidden" name="activity-filter" value="on">

        <div class="collections">

            <div class="collection">
                <h4>Type</h4>
                <?php
                foreach($types as $term){

                    $unchecked_image_id = get_term_meta($term->term_id , 'unchecked_image' , true);
                    $checked_image_id = get_term_meta($term->term_id , 'checked_image' , true);

                    $unchecked_image_url = wp_get_attachment_url($unchecked_image_id);
                    $checked_image_url = wp_get_attachment_url($checked_image_id);

                    if(in_array($term->slug , $selected_types)){
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="types[]"><span><img src="'.$checked_image_url.'" data-unchecked="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="types[]"><span><img src="'.$unchecked_image_url.'" data-checked="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }
                }
                ?>
            </div>
            <div class="collection">
                <h4>Season</h4>
                <?php
                foreach($seasons as $term){

                    $unchecked_image_id = get_term_meta($term->term_id , 'unchecked_image' , true);
                    $checked_image_id = get_term_meta($term->term_id , 'checked_image' , true);

                    $unchecked_image_url = wp_get_attachment_url($unchecked_image_id);
                    $checked_image_url = wp_get_attachment_url($checked_image_id);

                    if(in_array($term->slug , $selected_seasons)){
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="seasons[]"><span><img src="'.$checked_image_url.'" data-unchecked="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="seasons[]"><span><img src="'.$unchecked_image_url.'" data-checked="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }
                }
                ?>
            </div>
            <div class="collection">
                <h4>Indoor/Ourdoor</h4>
                <?php
                foreach($environment as $term){

                    $unchecked_image_id = get_term_meta($term->term_id , 'unchecked_image' , true);
                    $checked_image_id = get_term_meta($term->term_id , 'checked_image' , true);

                    $unchecked_image_url = wp_get_attachment_url($unchecked_image_id);
                    $checked_image_url = wp_get_attachment_url($checked_image_id);

                    if(in_array($term->slug , $selected_environment)){
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="environment[]"><span><img src="'.$checked_image_url.'" data-unchecked="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="environment[]"><span><img src="'.$unchecked_image_url.'" data-checked="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }
                }
                ?>
            </div>
            <div class="collection">
                <h4>Day/Night</h4>
                <?php
                foreach($time as $term){

                    $unchecked_image_id = get_term_meta($term->term_id , 'unchecked_image' , true);
                    $checked_image_id = get_term_meta($term->term_id , 'checked_image' , true);

                    $unchecked_image_url = wp_get_attachment_url($unchecked_image_id);
                    $checked_image_url = wp_get_attachment_url($checked_image_id);

                    if(in_array($term->slug , $selected_time)){
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="time[]"><span><img src="'.$checked_image_url.'" data-unchecked="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="time[]"><span><img src="'.$unchecked_image_url.'" data-checked="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }
                }
                ?>
            </div>
            <div class="collection">
                <h4>Cost</h4>
                <?php
                foreach($cost as $term){

                    $unchecked_image_id = get_term_meta($term->term_id , 'unchecked_image' , true);
                    $checked_image_id = get_term_meta($term->term_id , 'checked_image' , true);

                    $unchecked_image_url = wp_get_attachment_url($unchecked_image_id);
                    $checked_image_url = wp_get_attachment_url($checked_image_id);

                    if(is_array($selected_cost)) {
                        if(in_array($term->slug , $selected_cost)){
                            echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="costs[]"><span><img src="'.$checked_image_url.'" data-unchecked="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                        }else{
                            echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="costs[]"><span><img src="'.$unchecked_image_url.'" data-checked="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                        }
                    } else {
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="costs[]"><span><img src="'.$unchecked_image_url.'" data-checked="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }

                }
                ?>
            </div>

        </div>

        <div class="more-filters">

            <div class="field">
                <label for="_equipment" id="equipment_field">
                    Equipment:
                    <input type="text" name="_equipment">
                    <div class="clear-results">X</div>
                    <div class="results"></div>
                </label>
            </div>

            <div class="field">
                <label for="_badge">
                    Badge:
                    <select name="_badge" id="_badge">
                        <?php if($selected_badge == ''){ ?>
                            <option value="" selected disabled>Select a Badge</option>
                        <?php } ?>
                        <?php
                            if($badges->have_posts()){
                                while ($badges->have_posts()){ $badges->the_post();
                                    if($badges->post->ID == $selected_badge){
                                        echo '<option selected value="'.$badges->post->ID.'">'.get_the_title($badges->post->ID).'</option>';
                                    }else{
                                        echo '<option value="'.$badges->post->ID.'">'.get_the_title($badges->post->ID).'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                </label>
            </div>

            <div class="field">
                <label for="_age">
                    Age:
                    <select name="_age" id="_age">
                        <?php if($selected_age == ''){ ?>
                            <option value="" selected disabled>Select an Age</option>
                        <?php } ?>
                        <?php
                            foreach($ages as $term){
                                if($term->name == $selected_age){
                                    echo '<option selected value="'.$term->name.'">'.$term->name.'</option>';
                                }else{
                                    echo '<option value="'.$term->name.'">'.$term->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
            </div>

            <div class="field">
                <label for="_skills">
                    Skills:
                    <select name="_skills" id="_skills">
                        <?php if($selected_skills == ''){ ?>
                            <option value="" selected disabled>Select a Skill</option>
                        <?php } ?>
                        <?php
                            foreach($skills as $term){
                                if($term->name == $selected_skills){
                                    echo '<option selected value="'.$term->name.'">'.$term->name.'</option>';
                                }else{
                                    echo '<option value="'.$term->name.'">'.$term->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
            </div>

            <div class="field">
                <label for="_subject">
                    Subject:
                    <select name="_subject" id="_subject">
                        <?php if($selected_subject == ''){ ?>
                            <option value="" selected disabled>Select a Subject</option>
                        <?php } ?>
                        <?php
                            foreach($subjects as $term){
                                if($term->name == $selected_subject){
                                    echo '<option selected value="'.$term->name.'">'.$term->name.'</option>';
                                }else{
                                    echo '<option value="'.$term->name.'">'.$term->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
            </div>

            <br clear="all"/>

            <div class="equipment-chosen">
                <?php
                if(isset($_GET['equipment'])){
                    foreach($_GET['equipment'] as $equipment){
                        $term = get_term($equipment ,'ppb-activity-equipment' , OBJECT);
                        echo '<div class="chosen"><p><input type="checkbox" checked name="equipment[]" value="'.$equipment.'"> '.$term->name.'<span>X</span></p></div>';
                    }
                }
                ?>
            </div>


        </div>

        <div class="toggles">
            <input type="hidden" name="more_filters" value="hide">
            <input type="hidden" name="scroll_pos">
            <a href="javascript:void(0);" class="pp-btn link-pink more-toggle">More Filters</a>
            <button style="display: inline-block !important;" type="submit" class="pp-btn pink">Update Filters</button>
            <?php if(isset($_GET['activity-filter'])){ ?>
                <a href="<?=get_site_url().'/activities'?>" class="pp-btn navy">Clear Filters</a>
            <?php } ?>
        </div>

    </form>
</div>

<script>

    $ = jQuery;

    $('input[name="_equipment"]').keyup(function () {

        if($(this).val().length > 0){

            var data = {
                action: 'get_equipment',
                query: $(this).val()
            };

            $('.clear-results').show();

            $('#equipment_field .results').empty();

            $.post(wc_add_to_cart_params.ajax_url , data , function (res) {
                var json = JSON.parse(res);
                $('#equipment_field .results').empty();
                for(var i = 0; i < json.length; i++){
                    $('#equipment_field .results').append('<a href="" data-id="'+json[i].term_id+'">'+json[i].name+'</a>');
                }
            });

        }else{

        }

    });

    $('.activity-filter select , .activity-filter input').change(function () {

        $('.activity-filter button').prop('disabled' , false);

    });

    $('.activity-filter .collections .collection label span').click(function (e) {

        e.preventDefault();

        if($(this).parent().find('input').is(':checked')){
            $(this).parent().find('input').prop('checked' , false);
        }else{
            $(this).parent().find('input').prop('checked' , true);
        }

        var img = $(this).find('img');

        if(img.data('checked')){

            img.attr('src' , img.data('checked'));

        }else{

            img.attr('src' , img.data('unchecked'));

        }

    });

    $('body').on('click' , '.clear-results' , function () {
        $('#equipment_field .results').empty();
        $('input[name="_equipment"]').val('');
        $(this).hide();
    });

    $('body').on('click' , '#equipment_field .results a' , function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();

        var id = $(this).data('id');

        $('.equipment-chosen').append('<div class="chosen"><p><input type="checkbox" checked name="equipment[]" value="'+id+'"> '+$(this).html()+'<span>X</span></p></div>');

    });

    $('body').on('click' , '.equipment-chosen .chosen span' , function () {
        $(this).parents('.chosen').remove();
    });

    $('body .toggles').click(function () {

        $('#equipment_field .results').empty();

    });

    $('.toggles .more-toggle').toggle(function () {
        $(this).html('Less Filters');
        $('.more-filters').slideDown();
        $('input[name="more_filters"]').val('show');
    }, function () {
        $(this).html('More Filters');
        $('.more-filters').slideUp();
        $('input[name="more_filters"]').val('hide');
    });

    <?php if(isset($_GET['more_filters']) && $_GET['more_filters'] == 'show'){ ?>
        $('.toggles .more-toggle').click();
    <?php } ?>

    $(window).scroll(function () {
        $('input[name="scroll_pos"]').val($(window).scrollTop());
    });

    <?php if(isset($_GET['scroll_pos'])){ ?>

        $('html, body').animate({
            scrollTop: <?=$_GET['scroll_pos']?>
        }, 2000);

    <?php } ?>

</script>