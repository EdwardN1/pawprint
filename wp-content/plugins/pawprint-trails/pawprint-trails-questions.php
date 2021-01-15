<?php

    add_action('admin_menu' , 'add_questions_page');

    function add_questions_page(){

        add_menu_page(
            'Trail Questions Groups',
            'Trail Questions Groups',
            'manage_options',
            'trail-questions',
            'add_questions_page_html',
            'dashicons-admin-post'
        );

        add_submenu_page(
           'trail-questions',
            'Add New Group',
            'Add New Group',
            'manage_options',
            'trail-questions-new',
            'add_questions_page_new_html'
        );

    }

    function add_questions_page_html(){

        global $wpdb;
        $rows = $wpdb->get_results('SELECT * FROM wp_question_groups' , OBJECT);

        ?>

        <div class="wrap">
            <h1>Trail Questions Groups</h1>
            <a href="<?=get_admin_url().'/admin.php?page=trail-questions-new'?>" class="button button-primary">Add New Question Group</a>
            <hr>
            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                    <tr>
                        <th>Trail ID</th>
                        <th>Trail Name</th>
                        <th>Number Of Questions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) { ?>
                        <?php $questions = $wpdb->get_results('SELECT * FROM wp_questions WHERE group_id ='.$row->id); ?>
                        <tr>
                            <td><?=$row->trail_id?></td>
                            <td><?=get_the_title($row->trail_id)?></td>
                            <td><?=count($questions)?></td>
                            <td>
                                <a href="<?=admin_url().'admin.php?page=trail-questions-new&action=edit&id='.$row->id?>">Edit</a> |
                                <a href="">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php

    }

    function add_questions_page_new_html(){

        global $wpdb;

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

        if(isset($_POST['_update_questions'])){

            $update_data = array(
                'trail_id' => $_POST['trail'],
                'treats' => $_POST['treats']
            );

            $wpdb->update('wp_question_groups' , $update_data , array('id' => $_GET['id']));

            $questions_inserted = 0;

            $wpdb->delete('wp_questions' , array('group_id' => $_GET['id']));

            foreach($_POST['questions'] as $question){

                $question_data = array(
                    'group_id' => $_GET['id'],
                    'question' => $question['question'],
                    'answer' => $question['answer'],
                    'date_created' => date('c')
                );

                $wpdb->insert('wp_questions' , $question_data);

                $question_id = $wpdb->insert_id;

                if($question_id){
                    $questions_inserted++;
                }

            }

            if($questions_inserted == count($_POST['questions'])){
                ob_start();
                wp_redirect(get_admin_url().'admin.php?page=trail-questions');
                exit();
            }

        }

        if(isset($_POST['_submit_questions'])){

            $check = $wpdb->get_row('SELECT * FROM wp_question_groups WHERE trail_id ='.$_POST['trail']);

            if(!$check){

                $insert_data = array(
                    'trail_id' => $_POST['trail'],
                    'treats' => $_POST['treats'],
                    'date_created' => date('c')
                );

                $wpdb->insert('wp_question_groups' , $insert_data);
                $group_id = $wpdb->insert_id;

                $questions_inserted = 0;

                foreach($_POST['questions'] as $question){

                    $question_data = array(
                        'group_id' => $group_id,
                        'question' => $question['question'],
                        'answer' => $question['answer'],
                        'date_created' => date('c')
                    );

                    $wpdb->insert('wp_questions' , $question_data);

                    $question_id = $wpdb->insert_id;

                    if($question_id){
                        $questions_inserted++;
                    }

                }

                if($questions_inserted == count($_POST['questions'])){
                    ob_start();
                    wp_redirect(get_admin_url().'admin.php?page=trail-questions');
                    exit();
                }

            }

        }

        ?>

        <?php if(isset($_GET['action']) && $_GET['action'] == 'edit'){ ?>

            <?php
                global $wpdb;
                $row = $wpdb->get_row('SELECT * FROM wp_question_groups WHERE id = '.$_GET['id'] , OBJECT);
                $questions = $wpdb->get_results('SELECT * FROM wp_questions WHERE group_id ='.$_GET['id']);
            ?>

            <div class="wrap">
                <h1>Edit Trail Questions Group</h1>
                <hr>
                <form action="" method="post">
                    <label for="">
                        Trail:<br/>
                        <select name="trail" required id="" class="form-control widefat">
                            <option disabled selected>-- Please choose a trail</option>
                            <?php
                            if($trails->have_posts()){
                                while ($trails->have_posts()){ $trails->the_post();
                                    if($trails->post->ID == $row->trail_id){
                                        echo '<option selected value="'.$trails->post->ID.'">'.get_the_title($trails->post->ID).'</option>';
                                    }else{
                                        echo '<option value="'.$trails->post->ID.'">'.get_the_title($trails->post->ID).'</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </label>
                    <br><br>
                    <label for="">
                        Number of treats:<br/>
                        <input type="text" class="form-control widefat" name="treats" value="<?=$row->treats?>" required>
                    </label>
                    <h3>Questions</h3>
                    <table border="1" cellpadding="10" cellspacing="0" width="80%" id="questions">
                        <tbody>
                            <?php if(!empty($questions)){ ?>
                                <?php foreach($questions as $question){ ?>
                                    <tr>
                                        <td><input type="text" required name="questions[<?=$question->id?>][question]" value="<?=$question->question?>" placeholder="Question" class="widefat form-control"></td>
                                        <td><input type="text" required name="questions[<?=$question->id?>][answer]" value="<?=$question->answer?>" placeholder="Answer" class="widefat form-control"></td>
                                        <td width="100px">
                                            <button type="button" width="100%" class="button button-cancel" onclick="removeRow(this)">Remove Row</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr>
                                    <td><input type="text" required name="questions[0][question]" placeholder="Question" class="widefat form-control"></td>
                                    <td><input type="text" required name="questions[0][answer]" placeholder="Answer" class="widefat form-control"></td>
                                    <td width="100px">
                                        <button type="button" width="100%" class="button button-cancel" onclick="removeRow(this)">Remove Row</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                <button type="button" class="button button-primary" width="100%" onclick="add_row()">Add Row</button>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <br>
                    <button type="submit" name="_update_questions" class="button button-primary">Update Questions</button>
                </form>
            </div>

        <?php }else{ ?>

        <div class="wrap">
            <h1>New Trail Questions Group</h1>
            <hr>
            <form action="" method="post">
                <label for="">
                    Trail:<br/>
                    <select name="trail" required id="" class="form-control widefat">
                        <option disabled selected>-- Please choose a trail</option>
                        <?php
                            if($trails->have_posts()){
                                while ($trails->have_posts()){ $trails->the_post();
                                    echo '<option value="'.$trails->post->ID.'">'.get_the_title($trails->post->ID).'</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
                <br><br>
                <label for="">
                    Number of treats:<br/>
                    <input type="text" class="form-control widefat" name="treats" required>
                </label>
                <h3>Questions</h3>
                <table border="1" cellpadding="10" cellspacing="0" width="80%" id="questions">
                    <tbody>
                        <tr>
                            <td><input type="text" required name="questions[0][question]" placeholder="Question" class="widefat form-control"></td>
                            <td><input type="text" required name="questions[0][answer]" placeholder="Answer" class="widefat form-control"></td>
                            <td width="100px">
                                <button type="button" width="100%" class="button button-cancel" onclick="removeRow(this)">Remove Row</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                <button type="button" class="button button-primary" width="100%" onclick="add_row()">Add Row</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <button type="submit" name="_submit_questions" class="button button-primary">Submit Questions</button>
            </form>
        </div>

        <?php } ?>

        <script>

            function removeRow(element){
                $(element).parents('tr').remove();
            }

            function add_row(){

                var container = jQuery('#questions tbody');
                var id = Math.random();

                var item = '<tr>\n' +
                    '                            <td><input required type="text" name="questions['+id+'][question]" placeholder="Question" class="widefat form-control"></td>\n' +
                    '                            <td><input required type="text" name="questions['+id+'][answer]" placeholder="Answer" class="widefat form-control"></td>\n' +
                    '                            <td width="100px">\n' +
                    '                                <button type="button" width="100%" class="button button-cancel" onclick="removeRow(this)">Remove Row</button>\n' +
                    '                            </td>\n' +
                    '                        </tr>';

                container.append(item);

            }

        </script>

        <?php

    }

?>