<?php

add_shortcode('trails-answer-form' , 'trails_answer_form');

function trails_answer_form(){

    ?>

        <form action="" method="post" id="trails-search-form">
            <label for="">
                Trail
                <select name="_trail">
                </select>
            </label>
            <label for="">
                Unique Reference Code
                <input type="text" name="_uid">
            </label>
            <br clear="all">
            <button class="pp-btn navy" type="submit">Submit</button>
            <div class="trails-search-form-errors">

            </div>
        </form>

        <div class="trails-search-form-response"></div>

        <div class="extend-adventure">
            <h2>Extend your adventure...</h2>
            <div class="extend-products">
                <div class="woocommerce">
                    <?php woocommerce_product_loop_start(); ?>
                    <?php woocommerce_product_loop_end(); ?>
                </div>
            </div>
            <div class="extend-activities">
                <ul class="activities_listings">

                </ul>
            </div>
        </div>

        <script>

            $ = jQuery;

            $('body .extend-adventure').hide();

            var data = {
                action: 'pp_trails_get_trails'
            };

            $.post(wc_add_to_cart_params.ajax_url , data , function (res) {
                $('body #trails-search-form select[name="_trail"]').html(res)
            });

        </script>

    <?php
}


add_action( 'wp_ajax_pp_trails_get_trails', 'pp_trails_get_trails' );
add_action( 'wp_ajax_nopriv_pp_trails_get_trails', 'pp_trails_get_trails' );

function pp_trails_get_trails(){

    $trails = new WP_Query(
        array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => 'trails'
                )
            )
        )
    );

    echo '<option selected disabled value="0">-- Please Select A Trail --</option>';

    if($trails->have_posts()){
        while ($trails->have_posts()){ $trails->the_post();
            echo '<option value="'.$trails->post->ID.'">'.get_the_title($trails->post->ID).'</option>';
        }
    }

}

add_action( 'wp_ajax_pp_trails_validate_uid', 'pp_trails_validate_uid' );
add_action( 'wp_ajax_nopriv_pp_trails_validate_uid', 'pp_trails_validate_uid' );

function pp_trails_validate_uid(){

    global $wpdb;
    $errors = array();

    // CHECK IF THE UID HAS BEEN USED

    $checkUID = $wpdb->get_row('SELECT * FROM wp_order_trail_unique_ids WHERE uid = "'.$_POST['uid'].'" AND date_used IS NULL');

    if($checkUID){

        $checkTrail = $wpdb->get_row('SELECT * FROM wp_order_trail_unique_ids WHERE uid = "'.$_POST['uid'].'" AND trail_id = '.$_POST['trail']);

        if($checkTrail){

            $questionGroupID = $wpdb->get_row('SELECT id FROM wp_question_groups WHERE trail_id = '.$_POST['trail']);
            $questions = $wpdb->get_results('SELECT * FROM wp_questions WHERE group_id ='.$questionGroupID->id);

        }else{
            $errors[] = 'The unique reference code doesnt match the trail selected';
        }

    }else{
        $errors[] = 'The unique reference code has already been used';
    }

    // CREATE THE RESPONSE ARRAY

    if(!empty($errors)){
        $response = array(
            'code' => 400,
            'errors' => $errors
        );
    }else{
        $response = array(
            'code' => 200,
            'questions' => $questions
        );
    }

    echo json_encode($response);

    die();

}

add_action( 'wp_ajax_pp_trails_create_questions_html', 'pp_trails_create_questions_html' );
add_action( 'wp_ajax_nopriv_pp_trails_create_questions_html', 'pp_trails_create_questions_html' );

function pp_trails_create_questions_html(){

    $code = $_POST['json']['code'];
    $group = $_POST['json']['questions'][0]['group_id'];

    if($code == 200){

        $questions = $_POST['json']['questions'];

        ?>

        <div class="trails-search-form-response-content success">
            <h2>Success!</h2>
            <strong>Please enter your answers below to be entered into our monthly prize draw.</strong>
            <form action="" method="post" id="trail-questions-form">
                <input type="hidden" name="group_id" value="<?=$group?>">
                <?php foreach($questions as $question){ ?>
                    <label for="">
                        <?=$question['question']?>
                        <input type="text" data-question-id="<?=$question['id']?>" name="question[]">
                    </label>
                <?php } ?>
                <label for="">
                    Treats
                    <input type="text" name="treats">
                </label>
                <br clear="all">
                <button class="pp-btn navy" type="submit">Submit</button>
                <div class="trails-search-form-response-content-errors"></div>
            </form>
        </div>

        <div class="trails-questions-success"></div>

        <?php
    }elseif($code == 400){



    }

    die();

}

add_action( 'wp_ajax_pp_trails_questions_validate', 'pp_trails_questions_validate' );
add_action( 'wp_ajax_nopriv_pp_trails_questions_validate', 'pp_trails_questions_validate' );

function pp_trails_questions_validate(){

    global $wpdb;
    $errors = array();

    $i = 0;

    foreach($_POST['questions'] as $key => $question){

        $i++;

        $answerCheck = $wpdb->get_row('SELECT * FROM wp_questions WHERE id = '.$key.' AND answer = "'.$question.'"');

        if($answerCheck){

        }else{
            $errors[] = 'Uh oh! It seems the the answer to question '.$i.' is incorrect. Why not have another check and see if you can get it right next time.';
        }

    }

    $treatsCheck = $wpdb->get_row('SELECT * FROM wp_question_groups WHERE id = '.$_POST['group'].' AND treats = '.$_POST['treats']);

    if(!$treatsCheck){
        $errors[] = 'Uh oh! It seems the the answer to treats question is incorrect. Why not have another check and see if you can get it right next time.';
    }

    $success_html = "<div class='inner'>";
    $success_html .= "<h2>Congratulation's!</h2>";
    $success_html .= "<p>Good work adventurers! You've found the correct answers to all of the questions. If you ticked the box above, you have been entered into our monthly prize draw. Remember to keep an eye on your email address on the 1st of next month to see if you have won!</p>";
    $success_html .= '<p>We hope you enjoyed the '.get_the_title($_POST['trail']).' Pawprint Trail and will join us next time. Where will your next adventure take you?</p>';
    $success_html .= '</div>';

    if(!empty($errors)){
        $response = array(
            'code' => 400,
            'errors' => $errors
        );
    }else{
        $response = array(
            'code' => 200,
            'html' => $success_html
        );
    }

    echo json_encode($response);

    die();

}

add_action( 'wp_ajax_pp_trails_mark_uid_as_used', 'pp_trails_mark_uid_as_used' );
add_action( 'wp_ajax_nopriv_pp_trails_mark_uid_as_used', 'pp_trails_mark_uid_as_used' );

function pp_trails_mark_uid_as_used(){

    global $wpdb;
    print_r($_POST);

    $submission_check = $wpdb->get_row('SELECT * FROM wp_questions_groups_submissions WHERE uid = '.$_POST['uid']);

    if(!$submission_check){

        $submission_data = array(
            'group_id' => $_POST['group'],
            'uid' => $_POST['uid'],
            'answers' => serialize($_POST['questions']),
            'treats' => $_POST['treats']
        );

        $wpdb->insert('wp_questions_groups_submissions' , $submission_data);
        $wpdb->update('wp_order_trail_unique_ids' , array('date_used' => date('c')) , array('uid' => $_POST['uid']));

    }

}

add_action( 'wp_ajax_pp_trails_extras', 'pp_trails_extras' );
add_action( 'wp_ajax_nopriv_pp_trails_extras', 'pp_trails_extras' );

function pp_trails_extras(){

    $activities = get_field('activities' , $_POST['trail']);
    $products = get_field('extra_products' , $_POST['trail']);

    $activityIDS = array();
    $productsIDS = array();

    $activityHtml = '';
    $productHtml = '';

    foreach($activities as $activity){
        $id = $activity['activity']->ID;
        $activityIDS[] = $id;
    }

    foreach($products as $product){
        $id = $product['extra_product']->ID;
        $productsIDS[] = $id;
    }

    $activitiesObjects = new WP_Query(array('post_type' => 'ppb-activities' , 'post__in' => $activityIDS));
    $productsObjects = new WP_Query(array('post_type' => 'product' , 'post__in' => $productsIDS));


    if($activitiesObjects->have_posts()){
        while ($activitiesObjects->have_posts()){ $activitiesObjects->the_post();
            ob_start();
            include get_template_directory().'/template-parts/activity-listing.php';
            $activityHtml .= ob_get_clean();
        }
    }

    if($productsObjects->have_posts()){
        while ($productsObjects->have_posts()){ $productsObjects->the_post();
        
            ob_start();
            do_action( 'woocommerce_shop_loop' );
            wc_get_template_part( 'content', 'product' );
            $productHtml .= ob_get_clean();

        }
    }

    echo json_encode(array('activities' => $activityHtml , 'products' => $productHtml));

    die();

}