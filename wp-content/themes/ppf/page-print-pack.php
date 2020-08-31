<?php

require_once get_template_directory().'/library/vendor/autoload.php';
include get_template_directory().'/library/activity-pdf.php';

ini_set('display_errors' , 1);
error_reporting(E_ALL);

ini_set("pcre.backtrack_limit", "5000000");

use Mpdf\Mpdf;

if( isset( $_GET['challenge_id'] ) ) {

	$id = $_GET['challenge_id'];

	$pack = pp_get_challenge_pack(get_current_user_id() , $id);
	$badge = $pack->badge;

	$badge_background = get_field('cp_background' , $badge);
    $badge_cover = get_field('cp_cover' , $badge);
    
    $pdf = new Mpdf(
        [
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'setAutoTopMargin' => 'stretch',
            'autoMarginPadding' => 0,
            'bleedMargin' => 0,
            'crossMarkMargin' => 0,
            'cropMarkMargin' => 0,
            'nonPrintMargin' => 0,
            'margBuffer' => 0,
            'collapseBlockMargins' => false,
        ]
    );

    $head_css = "
    <head>
    
        <style>
            
            @page {
                background: url('".$badge_background."') no-repeat 0 0;
                background-image-resize: 6;
            }

            @page :first {
                background: url('".$badge_cover."') no-repeat 0 0;
                background-image-resize: 6;
            }
            
            strong{
                font-size: 30px;
                color: #0A246A;
                text-align: center;
                font-family: 'Helvetica';
            }
            
            span{
                font-size: 20px;
                color: #0A246A;
                text-align: center;
                font-family: 'Helvetica';
                font-weight: bold;
            }
            
            li{
                font-size: 20px;
                color: #0A246A;
                text-align: center;
                font-family: 'Helvetica';
                font-weight: bold;
            }
            
            div.text{
                width: 500px;
                text-align: justify;
                letter-spacing: 0;
            }
            
        </style>
    </head>
    ";

    $title = '<table width="100%">
                        <tbody>
                            <tr>
                                <td align="center">
                                 <strong>'.$pack->name.'</strong>
                                </td>
                            </tr>
                        </tbody>
                     </table>';

    $badgeTextHtml = '<table width="100%">
                        <tbody>
                            <tr>
                                <td align="center">
                                 <strong>'.get_the_title($badge).'</strong><br/>
                                 <span>'.date('jS F Y' , strtotime($pack->date_created)).'</span>
                                </td>
                            </tr>
                        </tbody>
                     </table>';

    $activitiesList = '<table width="100%" cellpadding="30">
                        <tbody>
                            <tr>
                                <td align="left">
                                <ul>
                        ';

                        foreach($pack->activities as $actvity){
                            $activitiesList .= '<li>'.get_the_title($actvity).'</li>';
                        }

    $activitiesList .= '</ul></td>
                            </tr>
                        </tbody>
                     </table>';

    $badgeImageId = get_post_thumbnail_id($badge);

    $pdf->showImageErrors = true;

    $pdf->SetTitle('challenge-pack-'.sanitize_title($pack->name));
    $pdf->WriteHTML($head_css);
    $pdf->WriteFixedPosHTML($title , 85 , 55 , '40' , '10');
    $pdf->Image(get_attached_file($badgeImageId) , 70, 65, 70, 70, 'png', '', true, false);
    $pdf->WriteHTML($badgeTextHtml);

    $pdf->AddPage('P');

    $pdf->WriteHTML($activitiesList);

    $pdf->Output('challenge-pack-'.sanitize_title($pack->name).'.pdf', 'I');

	echo $id;

} elseif( isset( $_GET['activity_id'] ) ) {

	$id = $_GET['activity_id'];
	$data = new stdClass();

    $activity = new WP_Query(array('post_type' => 'ppb-activities' , 'post__in' => array($id)));

	$blocks = parse_blocks( $activity->posts[0]->post_content );

    $data->age_details = array();

	foreach ($blocks as $block){
	    if($block['blockName'] == 'acf/red-ppb-age-group'){
            $data->age_details[$block['attrs']['data']['title']] = $block['attrs']['data']['content'];
        }
    }

	$data->blocks = $blocks;

	$type = get_the_terms($id , 'ppb-activity-type');
    $data->type = $type[0];

    $cost = get_the_terms($id , 'ppb-activity-price');
    $data->price = $cost;

    $seasons = get_the_terms($id , 'ppb-activity-season');
    $data->seasons = $seasons;

    $environment = get_the_terms($id , 'ppb-activity-environment');
    $data->environment = $environment;

    $time = get_the_terms($id , 'ppb-activity-time');
    $data->time = $time;

    $skills = get_the_terms($id , 'ppb-activity-soft-skills');
    $data->skills = $skills;

    $subjects = get_the_terms($id , 'ppb-activity-subject');
    $data->subjects = $subjects;

    $equipment = get_the_terms($id , 'ppb-activity-equipment');
    $data->equipment = $equipment;

    $ages = get_the_terms($id , 'ppb-activity-age');
    $data->ages = $ages;

    $badges = get_field('badges' , $id);
    $data->badges = $badges;

    $pdf = new Mpdf(
        [
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'setAutoTopMargin' => 'stretch',
            'autoMarginPadding' => 0,
            'bleedMargin' => 0,
            'crossMarkMargin' => 0,
            'cropMarkMargin' => 0,
            'nonPrintMargin' => 0,
            'margBuffer' => 0,
            'collapseBlockMargins' => false,
        ]
    );

    $head_css = "
    <head>
    
        <style>

            @page{
                margin-header: 5mm;
                margin: 10% 5mm;
                font-family: 'Helvetica';
            }

            *{
                font-family: 'Helvetica';
            }

            p{
                color: #000;
                font-size: 14px;
                margin-bottom: 2mm;
                font-family: 'Helvetica';
            }

            h2{
                margin-top: 2mm;
                display: block;
                clear: both;
                font-family: 'Helvetica';
                font-size: 20px;
            }
            
            h3{
                font-family: 'Helvetica';
            }
            
            li{
                font-family: 'Helvetica';
            }
            
        </style>
    </head>
    ";


    $pdf->showImageErrors = true;

    $pdf->SetTitle(get_the_title($id));
    $pdf->WriteHTML($head_css);
    $pdf->SetHTMLHeader(generate_activity_pdf_header($id , $data->type->name) , 'OE' , true);
    $pdf->WriteHTML(generate_activity_pdf_body($id , $data));
    $pdf->Output(sanitize_title(get_the_title($id)).'.pdf', 'I');

} else {
	get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap cf">

			<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

				<article id="post-not-found" class="hentry cf">

					<header class="article-header">

						<h1><?php _e( 'PDF Not Found', 'bonestheme' ); ?></h1>

					</header>

					<section class="entry-content">

						<p><?php _e( 'The PDF you were looking for was not found!', 'bonestheme' ); ?></p>

					</section>

				</article>

			</main>

		</div>

	</div>

	<?php
	get_footer();
}

