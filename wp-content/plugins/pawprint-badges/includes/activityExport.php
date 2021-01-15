<?php

use Mpdf\Tag\P;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class activityExport {

	public $general = array(
		'title',
		'badges',
		'age',
		'subject',
		'cost',
		'soft skills',
		'craft',
		'food',
		'games',
		'other',
		'spring',
		'summer',
		'autumn',
		'winter',
		'indoor',
		'outdoor',
		'day',
		'night',
		'equipment'
	);

	const ACTIVITY = 1;

	public function __construct() {
		add_action( 'init', array( $this, 'ppb_activity_export_setup' ) );
	}

	public function ppb_activity_export_setup() {
		add_filter( 'bulk_actions-edit-ppb-activities', array( $this, 'ppb_register_csv_export_bulk_actions' ) );
		add_filter( 'handle_bulk_actions-edit-ppb-activities', array( $this, 'ppb_register_csv_export_handler' ), 10, 3 );
		add_action( 'admin_notices', array( $this, 'ppb_register_csv_export_notice' ) );
		add_action( 'admin_post_print.csv', array( $this, 'ppb_print_csv' ) );
	}

	/**
	 * Add new menu item (bulk action) to its stack
	 */
	public function ppb_register_csv_export_bulk_actions($bulk_actions) {
		$bulk_actions['ppb_generate_activity_export'] = __( 'Export All Activity CSV', RED_PPB__TEXTDOMAIN );
		$bulk_actions['ppb_generate_selected_activity_export'] = __( 'Export Selected Activity CSV', RED_PPB__TEXTDOMAIN );
		return $bulk_actions;
	}

	/**
	 * Add argument with selected post ids to redirect url
	 */
	public function ppb_register_csv_export_handler( $redirect_to, $doaction, $post_ids ) {
		global $wpdb;

		error_log( $doaction );

		if ( ! in_array($doaction, array('ppb_generate_activity_export','ppb_generate_selected_activity_export') ) ) {
			return $redirect_to;
		}

		$response = false;

		try {
			// Generate a csv file path
			$date     = date( "Y-m-d_H:i:s" );
			$filename = 'activities-' . md5( $date ) . '.csv';
			$path     = trailingslashit( RED_PPB__PLUGIN_EXPORT_DIR ) . $filename;

			// Create csv file from path for writing
			$fh = fopen( $path, "w" );

			// Check file handler didn't error
			if( $fh ) {

				$header = "Title,Badges,Age,Subject,Cost,Soft Skills,Craft,Food,Games,Other,Spring,Summer,Autumn,Winter,Indoor,Outdoor,Day,Night,Equipment";
				$fields = $this->general;

				// Give header columns
				fwrite( $fh, $header );

				if( $doaction == 'ppb_generate_activity_export' ) {
					$posts = get_posts(array(
						'fields'          => 'ids',
						'posts_per_page'  => -1,
						'post_type' => 'ppb-activities'
					));
				} else {
					if( $post_ids > 0 ) {
						$posts = $post_ids;
					}
				}

				// Write data to csv for each post.
				foreach( $posts as $post_id ) {
					$output = '';
					foreach( $fields as $field ) {
						if( $output == '' ) {
							$output = "\r\n" . $this->ppb_get__values( $field, $post_id, self::ACTIVITY );
						} else {
							$output .= "," . $this->ppb_get__values( $field, $post_id, self::ACTIVITY );
						}
					}
					fwrite( $fh, $output );
				}

				// Close csv
				fclose( $fh );

				$response = $filename;

			}
		} catch( Exception $e ) {
			error_log( $e->getMessage() );
		}

		// Pass filename to url
		$redirect_to = add_query_arg( 'ppb_generate_activity_export', base64_encode( $response ), $redirect_to );

		return $redirect_to;
	}

	/**
	 * Show notice
	 */
	public function ppb_register_csv_export_notice() {
		if ( isset( $_REQUEST['ppb_generate_activity_export'] ) ) {
			$response = base64_decode( $_REQUEST['ppb_generate_activity_export'] );
			echo '<div id="message" class="' . ( $response ? 'updated' : 'error' ) . ' fade">';
			if ( $response !== '' ) {
				echo '<p><a href="admin-post.php?action=print.csv&file=' . $response . '" target="_blank">' . __( 'Activity Export Complete, Click here to download', RED_PPB__TEXTDOMAIN ) . '</a></p>';
			} else {
				echo '<p>' . __( 'Something went wrong. Please contact your developer for more information.', RED_PPB__TEXTDOMAIN ) . '</p>';
			}
			echo '</div>';
		}
	}

	public function ppb_round_up($number, $precision = 2) {
		$fig = (int) str_pad('1', $precision, '0');
		return (ceil($number * $fig) / $fig);
	}

	public function ppb_terms_to_string( $terms ) {
		$_string = "";
		if( sizeof($terms) > 0 ) {
			foreach( $terms as $term ) {
				$_string .= "[" . $term->name . "] ";
			}
		}
		return $_string;
	}

	public function ppb_badges_to_string( $badges ) {
		$_string = "";
		if( sizeof($badges) > 0 ) {
			foreach( $badges as $badge ) {
				$_b = get_post( $badge );
				$_string .= "[" . $_b->post_name . "] ";
			}
		}
		return $_string;
	}

	public function ppb_has_term( $term, $tax, $post_id ) {
		if ( has_term( $term, $tax, $post_id ) ) {
			return "Yes";
		} else {
			return '';
		}
	}

	public function ppb_print_csv() {
		if ( ! current_user_can( 'manage_options' ) )
			return;

		$path = trailingslashit( RED_PPB__PLUGIN_EXPORT_DIR ) . esc_attr( $_GET['file'] );
		header( 'Content-Description: File Transfer' );
		header('Content-Disposition: attachment; filename=' . esc_attr( $_GET['file'] ) );
		header('Content-Encoding: UTF-8');
		header('Content-Type: text/csv; charset=utf-8');
		header( 'Expires: 0' );
		header( 'Cache-Control: no-cache, must-revalidate' );
		header('Pragma: no-cache');
		header( 'Content-Length: ' . filesize( $path ) );
		echo "\xEF\xBB\xBF";
		readfile( $path );
	}

	public function ppb_get__values( $field, $post_id, $exportType = self::ACTIVITY, $variation = false, $options = null ) {

		if( $exportType == self::ACTIVITY ) {

			switch( $field ) {

				case "title":
					return str_replace( ",", ' ', get_post_field( 'post_title', $post_id ) );
					break;

				case "badges":
					$badges = get_field('badges', $post_id );
					return $this->ppb_badges_to_string( $badges );
					break;

				case "age":
					$terms = get_the_terms( $post_id, 'ppb-activity-age');
					return $this->ppb_terms_to_string( $terms );
					break;

				case "subject":
					$terms = get_the_terms( $post_id, 'ppb-activity-subject');
					return $this->ppb_terms_to_string( $terms );
					break;

				case "cost":
					$terms = get_the_terms( $post_id, 'ppb-activity-price');
					return $this->ppb_terms_to_string( $terms );
					break;

				case "soft skills":
					$terms = get_the_terms( $post_id, 'ppb-activity-soft-skills');
					return $this->ppb_terms_to_string( $terms );
					break;

				case "craft":
					return $this->ppb_has_term('craft', 'ppb-activity-type', $post_id );
					break;

				case "food":
					return $this->ppb_has_term('food', 'ppb-activity-type', $post_id );
					break;

				case "games":
					return $this->ppb_has_term('games', 'ppb-activity-type', $post_id );
					break;

				case "other":
					return $this->ppb_has_term('other', 'ppb-activity-type', $post_id );
					break;

				case "spring":
					return $this->ppb_has_term('spring', 'ppb-activity-season', $post_id );
					break;

				case "summer":
					return $this->ppb_has_term('summer', 'ppb-activity-season', $post_id );
					break;

				case "autumn":
					return $this->ppb_has_term('autumn', 'ppb-activity-season', $post_id );
					break;

				case "winter":
					return $this->ppb_has_term('winter', 'ppb-activity-season', $post_id );
					break;

				case "indoor":
					return $this->ppb_has_term('indoors', 'ppb-activity-environment', $post_id );
					break;

				case "outdoor":
					return $this->ppb_has_term('outdoors', 'ppb-activity-environment', $post_id );
					break;

				case "day":
					return $this->ppb_has_term('day', 'ppb-activity-time', $post_id );
					break;

				case "night":
					return $this->ppb_has_term('night', 'ppb-activity-time', $post_id );
					break;

				case "equipment":
					$terms = get_the_terms( $post_id, 'ppb-activity-equipment');
					return $this->ppb_terms_to_string( $terms );
					break;
			}

		}

		return '';

	}

}
