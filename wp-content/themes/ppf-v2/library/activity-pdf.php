<?php

    include 'base64encode-image.php';

    function generate_activity_pdf_header($activity , $type){

        switch ($type){

            case 'Craft':

                $bgColour = '#ff9d33';
                break;

            case 'Games':

                $bgColour = '#2096fb';
                break;

            case 'Food':

                $bgColour = '#00aa4f';
                break;

            case 'Other':

                $bgColour = '#9933ff';
                break;

        }

        $checked_image_id = get_term_meta(wp_get_post_terms($activity , array('taxonomy' => 'ppb-activity-type'))[0]->term_id , 'checked_image' , true);
        $checked_image_url = get_attached_file($checked_image_id);

        $html  = '<table class="header type_'.$type.'" cellspacing="0" cellpadding="20" bgcolor="'.$bgColour.'" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td><h2 style="color: #FFF;">'.get_the_title($activity).'</h2></td>
                                <td align="right"><img height="50px" src="'.$checked_image_url.'" alt=""></td>
                            </tr>
                        </tbody>
                  </table>';

        return $html;

    }

    function generate_badges_html($badges){

        $html = '';

        foreach($badges as $badge){
            $badgeImageId = get_post_thumbnail_id($badge);
            $html .= '<div style="width: 80px; text-align: center"><img width="80px" src="'.get_attached_file($badgeImageId).'"></div>';
        }

        $html .= '<br/>';

        foreach($badges as $badge){
            $html .= '<li>'.get_the_title($badge).'</li>';
        }

        return $html;

    }

    function generate_first_ul_content($data){

        $html = '<table width="100%">';
            $html .= '<tbody>';

                $html .= '<tr>';
                    $html .= '<td>';
                        $p = 0;
                        foreach($data->price as $item){
                            $p++;
                            $html .= $item->name;
                            if($p != count($data->price)){
                                $html .= '/';
                            }
                        }
                    $html .= '</td>';
                    $html .= '<td>';
                        $e = 0;
                        foreach($data->environment as $item){
                            $e++;
                            $html .= $item->name;
                            if($e != count($data->environment)){
                                $html .= '/';
                            }
                        }
                    $html .= '</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                    $html .= '<td>';
                        $t = 0;
                        foreach($data->time as $item){
                            $t++;
                            $html .= $item->name;
                            if($t != count($data->time)){
                                $html .= '/';
                            }
                        }
                    $html .= '</td>';
                $html .= '</tr>';

            $html .= '</tbody>';
        $html .= '</table>';

        return $html;

    }

    function generate_content($blocks){

        $html = '';

        foreach ($blocks as $block) {

            if ($block['blockName'] != "acf/red-ppb-age-group" && $block['blockName'] != NULL) {

                switch ($block['blockName']){

                    case 'acf/red-ppb-idea':

                        $h2 = "Here's an idea";
                        break;

                    case 'acf/red-ppb-for-leaders':

                        $h2 = "For leaders";
                        break;

                    case 'acf/red-ppb-did-you-know':

                        $h2 = "Did you know";
                        break;

                    case 'acf/red-ppb-why':

                        $h2 = "Why?";
                        break;

                }

                $html .= '<h2>'.$h2.'</h2>';
                $html .= '<p>'.$block['attrs']['data']['content'].'</p><br/>';
            }

        }

        return $html;

    }

    function generate_age_blocks($ages , $age_details){

        $html = '';

        foreach($ages as $age){

            if($age->name == '3 - 5'){

                $html .= '<h2>Age '.$age->name.'</h2>';
                $html .= $age_details[$age->term_id];
                $html .= '<br/><br/>';

            }elseif($age->name == '5 - 7'){

                $html .= '<h2>Age '.$age->name.'</h2>';
                $html .= $age_details[$age->term_id];
                $html .= '<br/><br/>';

            }elseif($age->name == '7 - 11'){

                $html .= '<h2>Age '.$age->name.'</h2>';
                $html .= $age_details[$age->term_id];
                $html .= '<br/><br/>';

            }elseif($age->name == '14 - 18'){

                $html .= '<h2>Age '.$age->name.'</h2>';
                $html .= $age_details[$age->term_id];
                $html .= '<br/><br/>';

            }

        }

        return $html;

    }

    function generate_sidebar_age_details($data){

        $notickId = attachment_url_to_postid(get_site_url().'/wp-content/uploads/2020/02/no-tick.png');
        $tickId = attachment_url_to_postid(get_site_url().'/wp-content/uploads/2020/02/tick.png');

        $notick = get_attached_file($notickId);
        $tick = get_attached_file($tickId);

        $ages = array();

        foreach($data->ages as $age){
            $ages[] = $age->term_id;
        }

        $allAges = get_terms(array('taxonomy' => 'ppb-activity-age' , 'hide_empty' => false));

        asort($allAges);

        $html = '<table width="100%">';
            $html .= '<tbody>';
                $html .= '<tr>';
                $i = 0;
                foreach($allAges as $age){
                    $i++;
                    if(in_array($age->term_id , $ages)){
                        $html .= '<td><img width="16px" src="'.$tick.'"> '.$age->name.'</td>';
                    }else{
                        $html .= '<td><img width="16px" src="'.$notick.'"> '.$age->name.'</td>';
                    }
                    if ($i % 2 == 0 && $i != count($allAges)) {
                        $html .= "</tr><tr>";
                    }
                }
                $html .= '</tr>';
            $html .= '</tbody>';
        $html .= '</table>';

        return $html;

    }

    function generate_sidebar_season_details($data){

        $notickId = attachment_url_to_postid(get_site_url().'/wp-content/uploads/2020/02/no-tick.png');
        $tickId = attachment_url_to_postid(get_site_url().'/wp-content/uploads/2020/02/tick.png');

        $notick = get_attached_file($notickId);
        $tick = get_attached_file($tickId);
        
        $seasons = array();

        foreach($data->seasons as $season){
            $seasons[] = $season->term_id;
        }

        $allSeasons = get_terms(array('taxonomy' => 'ppb-activity-season' , 'hide_empty' => false));

        $html = '<table width="100%">';
            $html .= '<tbody>';
                $html .= '<tr>';
                    $i = 0;
                    foreach($allSeasons as $season){
                        $i++;
                        if(in_array($season->term_id , $seasons)){
                            $html .= '<td><img width="16px" src="'.$tick.'"> '.$season->name.'</td>';
                        }else{
                            $html .= '<td><img width="16px" src="'.$notick.'"> '.$season->name.'</td>';
                        }
                        if ($i % 2 == 0 && $i != count($allSeasons)) {
                            $html .= "</tr><tr>";
                        }
                    }
                $html .= '</tr>';
            $html .= '</tbody>';
        $html .= '</table>';

        return $html;

    }

    function generate_equipment_skills($data){

        $html = '<h3>Skills:</h3><br/><ul>';

        foreach($data->skills as $skill){
            $html .= '<li>'.$skill->name.'</li>';
        }

        $html .= '</ul><br/>';

        $html .= '<h3>Equipment:</h3><br/><ul>';

        foreach($data->equipment as $equipment){
            $html .= '<li>'.$equipment->name.'</li>';
        }

        $html .= '</ul>';

        return $html;

    }

    function generate_activity_pdf_body($id , $data){

        $html = '
            <table style="width: 100%;" cellpadding="10">
                <tbody>
                    <tr>
                        <td valign="top">
                            '.generate_content($data->blocks).'
                            '.generate_age_blocks($data->ages , $data->age_details).'
                        </td>
                        <td valign="top" width="300px">
                            <h2>Activity details</h2>
                            <br/>
                            <h3>This activity counts towards...</h3>
                            <br/>
                            '.generate_badges_html($data->badges).'
                            <hr>
                            '.generate_first_ul_content($data).'
                            <hr>
                            '.generate_sidebar_age_details($data).'
                            <hr>
                            '.generate_sidebar_season_details($data).'
                            <hr>
                            '.generate_equipment_skills($data).'
                        </td>
                    </tr>
                </tbody>
            </table>
        ';

        return $html;

    }