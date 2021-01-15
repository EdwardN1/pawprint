<?php

    add_action('admin_menu' , 'ppb_import_export_main_page');

    function ppb_import_export_main_page(){

        add_submenu_page(
            'edit.php?post_type=ppb-activities',
            'Import/Export',
            'Import/Export',
            'manage_options',
            'import-export',
            'ppb_import_export_main_page_html'
        );

    }

    function ppb_import_export_main_page_html(){

        switch($_GET['action']){

            case 'import':

                if(isset($_POST['import'])) {

                    $csv = array();

                    $fp = fopen($_FILES['_csv']['tmp_name'], 'r');
                    while ($row = fgetcsv($fp)) {
                        $csv[] = $row;
                    }
                    fclose($fp);

                    $data = map_csv($csv, $csv[0]);
                    $split_array = split_array_tax($data);

                    $insertedCount = 0;
                    $failedCount = 0;
                    $missedCount = 0;

                    $i = 0;

                    foreach ($split_array as $row) {

                        $i++;

                        if ($i > 1) {

                            if(!get_page_by_path(sanitize_title($row['other_info']['Title']) , OBJECT , 'ppb-activities')){

                                if ($row['other_info']['Badges'] != '') {

                                    $badges = explode(',', $row['other_info']['Badges']);
                                    $badgeIDs = array();
                                    foreach ($badges as $badge) {
                                        $badgeobject = get_page_by_path(sanitize_title($badge), OBJECT, 'product');
                                        $badgeIDs[] = $badgeobject->ID;
                                    }

                                }

                                $content = '';

                                if ($row['other_info']['Here\'s An Idea'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-idea {
                                            "id": "group_5c64241a4ee41",
                                            "data": {
                                                "content": "' . $row['other_info']['Here\'s An Idea'] . '",
                                                "_content": "field_5c64243e2460c"
                                            },
                                            "name": "acf\/red-ppb-idea",
                                            "align": "",
                                            "mode": "edit"
                                        } /-->';
                                }

                                if ($row['other_info']['For Leaders'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-for-leaders {
                                            "id": "group_5c643c3703d7e",
                                            "data": {
                                                "content": "' . $row['other_info']['For Leaders'] . '",
                                                "_content": "field_5c643c370a66b"
                                            },
                                            "name": "acf\/red-ppb-for-leaders",
                                            "align": "",
                                            "mode": "edit"
                                        } /-->';
                                }

                                if ($row['other_info']['Did You Know'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-did-you-know {
                                            "id": "group_5c643c512450e",
                                            "data": {
                                                "content": "' . $row['other_info']['Did You Know'] . '",
                                                "_content": "field_5c643c5129b5f"
                                            },
                                            "name": "acf\/red-ppb-did-you-know",
                                            "align": "",
                                            "mode": "edit"
                                        } /-->';
                                }

                                if ($row['other_info']['Why'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-why {
                                            "id": "group_5c643c17672f7",
                                            "data": {
                                                "content": "' . $row['other_info']['Why'] . '",
                                                "_content": "field_5c643c176d7cb"
                                            },
                                            "name": "acf\/red-ppb-why",
                                            "align": "",
                                            "mode": "edit"
                                        } /-->';
                                }

                                if ($row['other_info']['Age 3 - 5 Detail'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-age-group {
                                            "id": "block_5d39d012ac882",
                                            "name": "acf\/red-ppb-age-group",
                                            "data": {
                                                "title": "63",
                                                "_title": "field_5c64497317332",
                                                "content": "' . $row['other_info']['Age 3 - 5 Detail'] . '",
                                                "_content": "field_5c643c864ee91"
                                            },
                                            "align": "",
                                            "mode": "edit"
                                        } /-->
                                        ';
                                }

                                if ($row['other_info']['Age 5 - 7 Detail'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-age-group {
                                            "id": "block_5d39d10eac883",
                                            "name": "acf\/red-ppb-age-group",
                                            "data": {
                                                "title": "40",
                                                "_title": "field_5c64497317332",
                                                "content": "' . $row['other_info']['Age 5 - 7 Detail'] . '",
                                                "_content": "field_5c643c864ee91"
                                            },
                                            "align": "",
                                            "mode": "edit"
                                        } /-->
                                        ';
                                }
                                if ($row['other_info']['Age 7 - 11 Detail'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-age-group {
                                            "id": "block_5d39d139ac884",
                                            "name": "acf\/red-ppb-age-group",
                                            "data": {
                                                "title": "41",
                                                "_title": "field_5c64497317332",
                                                "content": "' . $row['other_info']['Age 7 - 11 Detail'] . '",
                                                "_content": "field_5c643c864ee91"
                                            },
                                            "align": "",
                                            "mode": "edit"
                                        } /-->
                                        ';
                                }
                                if ($row['other_info']['Age 14 - 18 Detail'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-age-group {
                                            "id": "block_5d39d14fac885",
                                            "name": "acf\/red-ppb-age-group",
                                            "data": {
                                                "title": "39",
                                                "_title": "field_5c64497317332",
                                                "content": "' . $row['other_info']['Age 14 - 18 Detail'] . '",
                                                "_content": "field_5c643c864ee91"
                                            },
                                            "align": "",
                                            "mode": "edit"
                                        } /-->
                                        ';
                                }

                                // Check If Activity Exists

                                $insert_array = array(
                                    'post_type' => 'ppb-activities',
                                    'post_title' => $row['other_info']['Title'],
                                    'post_content' => $content,
                                    'post_status' => 'publish',
                                    'tax_input' => array(
                                        'ppb-activity-type' => $row['types'],
                                        'ppb-activity-season' => $row['seasons'],
                                        'ppb-activity-environment' => $row['environment'],
                                        'ppb-activity-time' => $row['time'],
                                        'ppb-activity-price' => $row['cost'],
                                        'ppb-activity-age' => $row['ages'],
                                        'ppb-activity-soft-skills' => $row['skills'],
                                        'ppb-activity-subject' => $row['subjects'],
                                        'ppb-activity-equipment' => $row['equipment']
                                    )
                                );

                                $insert_id = wp_insert_post(
                                    $insert_array
                                );

                                update_field('badges', $badgeIDs, $insert_id);

                                if($insert_id){
                                    $insertedCount++;
                                }else{
                                    $failedCount++;
                                }

                            }else{

                                $activity = get_page_by_path(sanitize_title($row['other_info']['Title']) , OBJECT , 'ppb-activities');

                                if ($row['other_info']['Badges'] != '') {

                                    $badges = explode(',', $row['other_info']['Badges']);
                                    $badgeIDs = array();
                                    foreach ($badges as $badge) {
                                        $badgeobject = get_page_by_path(sanitize_title($badge), OBJECT, 'product');
                                        $badgeIDs[] = $badgeobject->ID;
                                    }

                                }

                                $content = '';

                                if ($row['other_info']['Here\'s An Idea'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-idea {
                                            "id": "group_5c64241a4ee41",
                                            "data": {
                                                "content": "' . $row['other_info']['Here\'s An Idea'] . '",
                                                "_content": "field_5c64243e2460c"
                                            },
                                            "name": "acf\/red-ppb-idea",
                                            "align": "",
                                            "mode": "edit"
                                        } /-->';
                                }

                                if ($row['other_info']['For Leaders'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-for-leaders {
                                            "id": "group_5c643c3703d7e",
                                            "data": {
                                                "content": "' . $row['other_info']['For Leaders'] . '",
                                                "_content": "field_5c643c370a66b"
                                            },
                                            "name": "acf\/red-ppb-for-leaders",
                                            "align": "",
                                            "mode": "edit"
                                        } /-->';
                                }

                                if ($row['other_info']['Did You Know'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-did-you-know {
                                            "id": "group_5c643c512450e",
                                            "data": {
                                                "content": "' . $row['other_info']['Did You Know'] . '",
                                                "_content": "field_5c643c5129b5f"
                                            },
                                            "name": "acf\/red-ppb-did-you-know",
                                            "align": "",
                                            "mode": "edit"
                                        } /-->';
                                }

                                if ($row['other_info']['Why'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-why {
                                            "id": "group_5c643c17672f7",
                                            "data": {
                                                "content": "' . $row['other_info']['Why'] . '",
                                                "_content": "field_5c643c176d7cb"
                                            },
                                            "name": "acf\/red-ppb-why",
                                            "align": "",
                                            "mode": "edit"
                                        } /-->';
                                }

                                if ($row['other_info']['Age 3 - 5 Detail'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-age-group {
                                            "id": "block_5d39d012ac882",
                                            "name": "acf\/red-ppb-age-group",
                                            "data": {
                                                "title": "63",
                                                "_title": "field_5c64497317332",
                                                "content": "' . $row['other_info']['Age 3 - 5 Detail'] . '",
                                                "_content": "field_5c643c864ee91"
                                            },
                                            "align": "",
                                            "mode": "edit"
                                        } /-->
                                        ';
                                }

                                if ($row['other_info']['Age 5 - 7 Detail'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-age-group {
                                            "id": "block_5d39d10eac883",
                                            "name": "acf\/red-ppb-age-group",
                                            "data": {
                                                "title": "40",
                                                "_title": "field_5c64497317332",
                                                "content": "' . $row['other_info']['Age 5 - 7 Detail'] . '",
                                                "_content": "field_5c643c864ee91"
                                            },
                                            "align": "",
                                            "mode": "edit"
                                        } /-->
                                        ';
                                }
                                if ($row['other_info']['Age 7 - 11 Detail'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-age-group {
                                            "id": "block_5d39d139ac884",
                                            "name": "acf\/red-ppb-age-group",
                                            "data": {
                                                "title": "41",
                                                "_title": "field_5c64497317332",
                                                "content": "' . $row['other_info']['Age 7 - 11 Detail'] . '",
                                                "_content": "field_5c643c864ee91"
                                            },
                                            "align": "",
                                            "mode": "edit"
                                        } /-->
                                        ';
                                }
                                if ($row['other_info']['Age 14 - 18 Detail'] != '') {
                                    $content .= '<!-- wp:acf/red-ppb-age-group {
                                            "id": "block_5d39d14fac885",
                                            "name": "acf\/red-ppb-age-group",
                                            "data": {
                                                "title": "39",
                                                "_title": "field_5c64497317332",
                                                "content": "' . $row['other_info']['Age 14 - 18 Detail'] . '",
                                                "_content": "field_5c643c864ee91"
                                            },
                                            "align": "",
                                            "mode": "edit"
                                        } /-->
                                        ';
                                }

                                // Check If Activity Exists

                                $insert_array = array(
                                    'ID' => $activity->ID,
                                    'post_content' => $content,
                                    'tax_input' => array(
                                        'ppb-activity-type' => $row['types'],
                                        'ppb-activity-season' => $row['seasons'],
                                        'ppb-activity-environment' => $row['environment'],
                                        'ppb-activity-time' => $row['time'],
                                        'ppb-activity-price' => $row['cost'],
                                        'ppb-activity-age' => $row['ages'],
                                        'ppb-activity-soft-skills' => $row['skills'],
                                        'ppb-activity-subject' => $row['subjects'],
                                        'ppb-activity-equipment' => $row['equipment']
                                    )
                                );

                                $insert_id = wp_update_post(
                                    $insert_array
                                );

                                update_field('badges', $badgeIDs, $insert_id);

                                $missedCount++;

                            }

                        }

                    }

                    echo 'Inserted: '.$insertedCount.' Out of: '.(count($csv)-1).'<br/>';
                    echo 'Failed: '.$failedCount.' Out of: '.(count($csv)-1).'<br/>';
                    echo 'Missed: '.$missedCount.' Out of: '.(count($csv)-1).'<br/>';

                }

                break;

            case 'export':

                header('Content-Encoding: UTF-8');
                header("Content-type: text/csv; charset=UTF-8");
                header('Content-Disposition: attachment; filename="ppb_activies_export_'.date('ymdhis').'.csv"');
                header("Pragma: no-cache");
                header("Expires: 0");

                $allsubjects = get_terms(array('taxonomy' => 'ppb-activity-subject' , 'hide-empty' => false));
                $allskills = get_terms(array('taxonomy' => 'ppb-activity-soft-skills' , 'hide-empty' => false));

                $activities = new WP_Query(array('post_type' => 'ppb-activities' , 'posts_per_page' => -1));
                $headings = array('ID' , 'Title', 'Badges', 'Craft', 'Food', 'Games', 'Other', 'Spring', 'Summer', 'Autumn', 'Winter', 'Indoor', 'Outdoor', 'Day', 'Night', 'Free', '£', '££', '£££');

                foreach($allsubjects as $item){
                    $headings[] = $item->name;
                }

                foreach($allskills as $item){
                    $headings[] = $item->name;
                }

                $array2_headings = array('Equipment' , 'Age 3 - 5', 'Age 5 - 7', 'Age 7 - 11', 'Age 14 - 18', 'Age 3 - 5 Detail', 'Age 5 - 7 Detail', 'Age 7 - 11 Detail', 'Age 14 - 18 Detail', 'For Leaders', 'Did You Know', 'Why', 'Here\'s An Idea');

                foreach ($array2_headings as $array2_heading) {
                    $headings[] = $array2_heading;
                }

                ob_end_clean();

                echo "\xEF\xBB\xBF";
                $fp = fopen('php://output', 'wb');

                // ADD THE CSV HEADERS
                fputcsv($fp, $headings);

                if($activities->have_posts()){

                    while ($activities->have_posts()){ $activities->the_post();

                        $leaders = '';
                        $know = '';
                        $why = '';
                        $idea = '';

                        $age35 = '';
                        $age57 = '';
                        $age711 = '';
                        $age1418 = '';

                        $blocks = parse_blocks( $activities->post->post_content );
                        foreach ($blocks as $key => $block){

                            if($block['blockName'] == "acf/red-ppb-for-leaders"){
                                $leaders = $block['attrs']['data']['content'];
                            }

                            if($block['blockName'] == "acf/red-ppb-did-you-know"){
                                $know = $block['attrs']['data']['content'];
                            }

                            if($block['blockName'] == "acf/red-ppb-why"){
                                $why = $block['attrs']['data']['content'];
                            }

                            if($block['blockName'] == "acf/red-ppb-idea"){
                                $idea = $block['attrs']['data']['content'];
                            }

                            if($block['blockName'] == "acf/red-ppb-age-group"){

                                switch ($block['attrs']['data']['title']){

                                    case '44':

                                        $age35 = $block['attrs']['data']['content'];
                                        break;

                                    case '45':

                                        $age57 = $block['attrs']['data']['content'];
                                        break;

                                    case '46':

                                        $age711 = $block['attrs']['data']['content'];
                                        break;

                                    case '48':

                                        $age1418 = $block['attrs']['data']['content'];
                                        break;

                                }

                            }

                        }

                        $badges = get_field('badges' , $activities->post->ID);
                        $badges_string_array = array();
                        foreach($badges as $badge){
                            $badges_string_array[] = get_the_title($badge);
                        }

                        $type = wp_get_post_terms($activities->post->ID, 'ppb-activity-type');

                        $seasons = wp_get_post_terms($activities->post->ID , 'ppb-activity-season');
                        $seasons_array = array();
                        foreach($seasons as $season){
                            $seasons_array[] = $season->name;
                        }

                        $environment = wp_get_post_terms($activities->post->ID , 'ppb-activity-environment');
                        $environment_array = array();
                        foreach($environment as $item){
                            $environment_array[] = $item->name;
                        }

                        $time = wp_get_post_terms($activities->post->ID , 'ppb-activity-time');
                        $time_array = array();
                        foreach($time as $item){
                            $time_array[] = $item->name;
                        }

                        $price = wp_get_post_terms($activities->post->ID , 'ppb-activity-price');
                        $price_array = array();
                        foreach($price as $item){
                            $price_array[] = $item->name;
                        }

                        $subject = wp_get_post_terms($activities->post->ID , 'ppb-activity-subject');
                        $subject_array = array();
                        foreach($subject as $item){
                            $subject_array[] = $item->name;
                        }

                        $skills = wp_get_post_terms($activities->post->ID , 'ppb-activity-soft-skills');
                        $skills_array = array();
                        foreach($skills as $item){
                            $skills_array[] = $item->name;
                        }


                        $equipment = wp_get_post_terms(get_the_ID() , 'ppb-activity-equipment');
                        $equipment_string_array = array();
                        foreach($equipment as $item){
                            $equipment_string_array[] = $item->name;
                        }

                        $ages = wp_get_post_terms(get_the_ID() , 'ppb-activity-age');
                        $ages_array = array();
                        foreach($ages as $item){
                            $ages_array[] = $item->name;
                        }

                        $array = array(
                            $activities->post->ID,
                            get_the_title($activities->post->ID),
                            implode(',' , $badges_string_array),
                            ($type[0]->name == "Craft") ? 'Yes' : 'No',
                            ($type[0]->name == "Food") ? 'Yes' : 'No',
                            ($type[0]->name == "Games") ? 'Yes' : 'No',
                            ($type[0]->name == "Other") ? 'Yes' : 'No',
                            (in_array('Spring' , $seasons_array)) ? 'Yes' : 'No',
                            (in_array('Summer' , $seasons_array)) ? 'Yes' : 'No',
                            (in_array('Autumn' , $seasons_array)) ? 'Yes' : 'No',
                            (in_array('Winter' , $seasons_array)) ? 'Yes' : 'No',
                            (in_array('Indoors' , $environment_array)) ? 'Yes' : 'No',
                            (in_array('Outdoors' , $environment_array)) ? 'Yes' : 'No',
                            (in_array('Day' , $time_array)) ? 'Yes' : 'No',
                            (in_array('Night' , $time_array)) ? 'Yes' : 'No',
                            (in_array('Free' , $price_array)) ? 'Yes' : 'No',
                            (in_array('£' , $price_array)) ? 'Yes' : 'No',
                            (in_array('££' , $price_array)) ? 'Yes' : 'No',
                            (in_array('£££' , $price_array)) ? 'Yes' : 'No'
                        );

                        foreach($allsubjects as $item){

                            if(in_array($item->name , $subject_array)){
                                array_push($array , 'Yes');
                            }else{
                                array_push($array , 'No');
                            }

                        }

                        foreach($allskills as $item){

                            if(in_array($item->name , $skills_array)){
                                array_push($array , 'Yes');
                            }else{
                                array_push($array , 'No');
                            }

                        }

                        array_push($array , implode('|' , $equipment_string_array));
                        (in_array('3 - 5' , $ages_array)) ? array_push($array , 'Yes') : array_push($array , 'No');
                        (in_array('5 - 7' , $ages_array)) ? array_push($array , 'Yes') : array_push($array , 'No');
                        (in_array('7 - 11' , $ages_array)) ? array_push($array , 'Yes') : array_push($array , 'No');
                        (in_array('14 - 18' , $ages_array)) ? array_push($array , 'Yes') : array_push($array , 'No');
                        array_push($array , $age35);
                        array_push($array , $age57);
                        array_push($array , $age711);
                        array_push($array , $age1418);
                        array_push($array , $leaders);
                        array_push($array , $know);
                        array_push($array , $why);
                        array_push($array , $idea);

                        fputcsv($fp, $array);

                    }

                }

                fclose($fp);

                exit();

                break;

        }

        ?>

            <div class="wrap nosubsub">
                <h1 class="wp-heading-inline">Activity Import/Export</h1>
                <a href="<?=esc_url( add_query_arg( 'action', 'import' ))?>" class="page-title-action">Import</a>
                <a href="<?=esc_url( add_query_arg( 'action', 'export' ))?>" class="page-title-action">Export</a>

                <?php
                    if($_GET['action'] == 'import'){

                        ?>

                        <form action="" enctype="multipart/form-data" method="post">
                            <input type="file" name="_csv">
                            <button class="button button-primary" name="import" type="submit">Submit</button>
                        </form>

                        <?php

                    }
                ?>

            </div>

        <?php

    }

    function map_csv($csv , $csv_headers){

        $rows = array();

        foreach ($csv as $item) {
            $array = array();
            foreach($item as $key => $value){
                $array[$csv_headers[$key]] = $value;
            }
            $rows[] = $array;
        }

        return $rows;

    }

    function split_array_tax($data){

        $types = get_terms(array('taxonomy' => 'ppb-activity-type' , 'hide_empty' => false));
        $seasons = get_terms(array('taxonomy' => 'ppb-activity-season' , 'hide_empty' => false));
        $environment = get_terms(array('taxonomy' => 'ppb-activity-environment' , 'hide_empty' => false));
        $time = get_terms(array('taxonomy' => 'ppb-activity-time' , 'hide_empty' => false));
        $cost = get_terms(array('taxonomy' => 'ppb-activity-price' , 'hide_empty' => false));
        $ages = get_terms(array('taxonomy' => 'ppb-activity-age' , 'hide_empty' => false));
        $skills = get_terms(array('taxonomy' => 'ppb-activity-soft-skills' , 'hide_empty' => false));
        $subjects = get_terms(array('taxonomy' => 'ppb-activity-subject' , 'hide_empty' => false));
        $equipment = get_terms(array('taxonomy' => 'ppb-activity-equipment' , 'hide_empty' => false));

        $types2 = array();
        $seasons2 = array();
        $environment2 = array();
        $time2 = array();
        $cost2 = array();
        $ages2 = array();
        $skills2 = array();
        $subjects2 = array();
        $equipment2 = array();

        $types3 = array();
        $seasons3 = array();
        $environment3 = array();
        $time3 = array();
        $cost3 = array();
        $ages3 = array();
        $skills3 = array();
        $subjects3 = array();
        $equipment3 = array();

        foreach ($types as $term){
            $types2[] = $term->name;
            $types3[$term->name] = $term->term_id;
        }
        foreach ($seasons as $term){
            $seasons2[] = $term->name;
            $seasons3[$term->name] = $term->term_id;
        }
        foreach ($environment as $term){
            $environment2[] = $term->name;
            $environment3[$term->name] = $term->term_id;
        }
        foreach ($time as $term){
            $time2[] = $term->name;
            $time3[$term->name] = $term->term_id;
        }
        foreach ($cost as $term){
            $cost2[] = $term->name;
            $cost3[$term->name] = $term->term_id;
        }
        foreach ($ages as $term){
            $ages2[] = 'Age '.$term->name;
            $ages3['Age '.$term->name] = $term->term_id;
        }
        foreach ($skills as $term){
            $skills2[] = $term->name;
            $skills3[$term->name] = $term->term_id;
        }
        foreach ($subjects as $term){
            $subjects2[] = $term->name;
            $subjects3[$term->name] = $term->term_id;
        }
        foreach ($equipment as $term){
            $equipment2[] = $term->name;
            $equipment3[$term->slug] = $term->term_id;
        }

        $return_array = array();

        foreach ($data as $item) {

            $array = array(
                'other_info' => array(),
                'types' => array(),
                'seasons' => array(),
                'environment' => array(),
                'time' => array(),
                'cost' => array(),
                'ages' => array(),
                'skills' => array(),
                'subjects' => array(),
                'equipment' => array(),
            );



            foreach($item as $key => $value){

                if(in_array($key , $types2)){
                    if($value == "Yes"){
                        array_push($array['types'] , $types3[$key]);
                    }
                }
                elseif(in_array($key , $seasons2)){
                    if($value == "Yes"){
                        array_push($array['seasons'] , $seasons3[$key]);
                    }
                }
                elseif(in_array($key.'s' , $environment2)){
                    if($value == "Yes"){
                        array_push($array['environment'] , $environment3[$key.'s']);
                    }
                }
                elseif(in_array($key , $time2)){
                    if($value == "Yes"){
                        array_push($array['time'] , $time3[$key]);
                    }
                }
                elseif(in_array($key , $cost2)){
                    if($value == "Yes"){
                        array_push($array['cost'] , $cost3[$key]);
                    }
                }
                elseif(in_array($key , $ages2)){
                    if($value == "Yes"){
                        array_push($array['ages'] , $ages3[$key]);
                    }
                }
                elseif(in_array($key , $skills2)){
                    if($value == "Yes"){
                        array_push($array['skills'] , $skills3[$key]);
                    }
                }
                elseif(in_array($key , $subjects2)){
                    if($value == "Yes"){
                        array_push($array['subjects'] , $subjects3[$key]);
                    }
                }
                elseif($key == 'Equipment'){
                    $equipmentExplode = explode('|' , $value);
                    foreach($equipmentExplode as $item){
                        $slug = sanitize_title($item);
                        array_push($array['equipment'] , $equipment3[$slug]);
                    }
                }
                else{
                    $array['other_info'][$key] = $value;
                }

            }

            $return_array[] = $array;

        }

        return $return_array;

    }

?>