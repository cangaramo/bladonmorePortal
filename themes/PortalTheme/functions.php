<?php

/* ADD MENUS */
require_once(get_template_directory().'/functions/add-menus.php'); 

/* REMOVE FIELDS FROM PROFILE*/
require_once(get_template_directory().'/functions/remove-user-fields.php'); 

/* ROLES */
require_once(get_template_directory().'/functions/add-roles.php'); 

/* VALIDATION LOGIN */
require_once(get_template_directory().'/functions/login-validation.php'); 

/* ENQUEUE SCRIPTS */
require_once(get_template_directory().'/functions/enqueue-scripts.php'); 

/* GOOGLE MAPS */
require_once(get_template_directory().'/functions/map-key.php'); 

/* AJAX */

function load_agendas() {
	$agenda_id = $_POST['post_id'];
	require('parts/part-agenda_info.php'); 
	die();
}
add_action( 'wp_ajax_nopriv_load_agendas', 'load_agendas' );
add_action( 'wp_ajax_load_agendas', 'load_agendas' );


function load_feedbacks() {
	$feedback_id = $_POST['post_id'];
	require('parts/part-feedback_info.php'); 
	die();
}

add_action( 'wp_ajax_nopriv_load_feedbacks', 'load_feedbacks' );
add_action( 'wp_ajax_load_feedbacks', 'load_feedbacks' );


function load_videos() {
	$video_id = $_POST['post_id'];
	require('parts/part-video_info.php'); 
	die();
}

add_action( 'wp_ajax_nopriv_load_videos', 'load_videos' );
add_action( 'wp_ajax_load_videos', 'load_videos' );


function update_status () {
	$post_id = $_POST['post_id'];
	$post_type = $_POST['post_type'];
	$status = $_POST['status'];

	if ($post_type == "Agenda") {
		update_field("session_status", $status, $post_id);
	}

	elseif ($post_type == "Feedback") {
		update_field("feedback_status", $status, $post_id);
	}

	die();
}

add_action( 'wp_ajax_nopriv_update_status', 'update_status' );
add_action( 'wp_ajax_update_status', 'update_status' );


/* QUESTIONNAIRES */

//Media
add_action( 'gform_pre_submission_2', 'pre_submission_handler_media' );
function pre_submission_handler_media( $form ) {
	$user = 'user_'. get_current_user_id() ;
    $account_manager_id = get_field('account_manager', $user);
    $email_account_manager = get_field('email', $account_manager_id);
    $_POST['input_10'] = $email_account_manager;
}

//Presentation
add_action( 'gform_pre_submission_3', 'pre_submission_handler_presentation' );
function pre_submission_handler_presentation( $form ) {
	$user = 'user_'. get_current_user_id() ;
    $account_manager_id = get_field('account_manager', $user);
    $email_account_manager = get_field('email', $account_manager_id);
    $_POST['input_12'] = $email_account_manager;
}

//Writing workshop
add_action( 'gform_pre_submission_8', 'pre_submission_handler_workshop' );
function pre_submission_handler_workshop( $form ) {
	$user = 'user_'. get_current_user_id() ;
    $account_manager_id = get_field('account_manager', $user);
    $email_account_manager = get_field('email', $account_manager_id);
    $_POST['input_11'] = $email_account_manager;
}

?>