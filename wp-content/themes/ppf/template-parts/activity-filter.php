<?php

    $types = get_terms(array('taxonomy' => 'ppb-activity-type' , 'hide_empty' => false));
    $seasons = get_terms(array('taxonomy' => 'ppb-activity-season' , 'hide_empty' => false));
    $environment = get_terms(array('taxonomy' => 'ppb-activity-environment' , 'hide_empty' => false));
    $time = get_terms(array('taxonomy' => 'ppb-activity-time' , 'hide_empty' => false));
    $cost = get_terms(array('taxonomy' => 'ppb-activity-price' , 'hide_empty' => false));

    $badges = new WP_Query(
        array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'orderBy' => 'post_name',
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


    $ages = get_terms(array('taxonomy' => 'ppb-activity-age' , 'hide_empty' => false));
    $skills = get_terms(array('taxonomy' => 'ppb-activity-soft-skills' , 'hide_empty' => false));
    $subjects = get_terms(array('taxonomy' => 'ppb-activity-subject' , 'hide_empty' => false));

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
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="types[]"><span><img src="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="types[]"><span><img src="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
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
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="seasons[]"><span><img src="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="seasons[]"><span><img src="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
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
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="environment[]"><span><img src="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="environment[]"><span><img src="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
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
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="time[]"><span><img src="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="time[]"><span><img src="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
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

                    if(in_array($term->slug , $selected_cost)){
                        echo '<label for="ppf_collection_'.$term->slug.'"><input checked value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="costs[]"><span><img src="'.$checked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }else{
                        echo '<label for="ppf_collection_'.$term->slug.'"><input value="'.$term->slug.'" id="ppf_collection_'.$term->slug.'" type="checkbox" name="costs[]"><span><img src="'.$unchecked_image_url.'" alt=""></span><p>'.$term->name.'</p></label>';
                    }
                }
                ?>
            </div>

        </div>

        <div class="more-filters">

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
                    Slills:
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

            <div class="field">
                <label for="_equipment" id="equipment_field">
                    Equipment:
                    <input type="text" name="_equipment">
                    <div class="clear-results">X</div>
                    <div class="results"></div>
                    <div class="chosen">
                        <?php
                            if(isset($_GET['equipment'])){
                                foreach($_GET['equipment'] as $equipment){
                                    $term = get_term($equipment ,'ppb-activity-equipment' , OBJECT);
                                    echo '<input type="checkbox" checked name="equipment[]" value="'.$equipment.'"> '.$term->name.'<br/>';
                                }
                            }
                        ?>
                    </div>
                </label>
            </div>

        </div>

        <div class="toggles">
            <input type="hidden" name="more_filters" value="hide">
            <?php if(isset($_GET['activity-filter'])){ ?>
                <a href="<?=get_site_url().'/activities'?>" class="pp-btn navy">Clear Filters</a>
            <?php } ?>
            <a href="javascript:void(0);" class="pp-btn pink more-toggle">More Filters</a>
            <button style="display: inline-block !important;" type="submit" class="pp-btn pink">Update Filters</button>
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

    $('body').on('click' , '.clear-results' , function () {
        $('#equipment_field .results').empty();
        $('input[name="_equipment"]').val('');
        $(this).hide();
    });

    $('body').on('click' , '#equipment_field .results a' , function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();

        var id = $(this).data('id');

        $('body #equipment_field .chosen').append('<input type="checkbox" checked name="equipment[]" value="'+id+'"> '+$(this).html()+'<br/>');

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

</script>