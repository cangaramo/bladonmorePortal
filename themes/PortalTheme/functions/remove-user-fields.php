<?php
function wordpress_remove_user_personal_options($personal_options) {
	
	//PERSONAL OPTIONS
	$personal_options = preg_replace('#<h2>' . __("Personal Options") . '</h2>#s', '', $personal_options, 1); //Personal Options
	$personal_options = preg_replace('#<tr class="user-rich-editing-wrap(.*?)</tr>#s', '', $personal_options, 1); // Visual Editor
	$personal_options = preg_replace('#<tr class="user-syntax-highlighting-wrap(.*?)</tr>#s', '', $personal_options, 1); // Syntax highlight
	$personal_options = preg_replace('#<tr class="user-comment-shortcuts-wrap(.*?)</tr>#s', '', $personal_options, 1); // Keyboard Shortcuts
	$personal_options = preg_replace('#<tr class="show-admin-bar user-admin-bar-front-wrap(.*?)</tr>#s', '', $personal_options, 1); // Toolbar
	$personal_options = preg_replace('#<tr class="user-language-wrap(.*?)</tr>#s', '', $personal_options, 1); // Toolbar
	
	//NAME
	$personal_options = preg_replace('#<h2>' . __("Name") . '</h2>#s', '', $personal_options, 1); // Remove the "Name" title
	$personal_options = preg_replace('#<tr class="user-display-name-wrap(.*?)</tr>#s', '', $personal_options, 1); // Remove the "Display name publicly as" field
	
	//CONTACT INFO
	$personal_options = preg_replace('#<h2>' . __("Contact Info") . '</h2>#s', '', $personal_options, 1); // Remove the "Contact Info" title
	$personal_options = preg_replace('#<tr class="user-url-wrap(.*?)</tr>#s', '', $personal_options, 1); // Remove the "Website" field
	
	//ABOUT YOURSELF
	$personal_options = preg_replace('#<h2>' . __("About Yourself") . '</h2>#s', '', $personal_options, 1); // Remove the "About Yourself" title
	$personal_options = preg_replace('#<tr class="user-description-wrap(.*?)</tr>#s', '', $personal_options, 1); // Remove the "Biographical Info" field
	$personal_options = preg_replace('#<tr class="user-profile-picture(.*?)</tr>#s', '', $personal_options, 1); // Remove the "Profile Picture" field
	
	//ACCOUNT MANAGEMENT
	$personal_options = preg_replace('#<h2>' . __("Account Management") . '</h2>#s', '', $personal_options, 1); // Remove the "About Yourself" title
	$personal_options = preg_replace('#<tr class="user-sessions-wrap hide-if-no-js(.*?)</tr>#s', '', $personal_options, 1); // Remove the "Sessions" field

	//EXTRA USER FIELDS
	$personal_options = preg_replace('#<h2>' . __("Extra user fields") . '</h2>#s', '', $personal_options, 1); // Remove the "Extra user fields" title

	//ABOUT THE USER
	$personal_options = preg_replace('#<h2>' . __("About the user") . '</h2>#s', '', $personal_options, 1); // Remove the "About the user" title
	
	//ADDITIONAL CAPABILITIES
	$personal_options = preg_replace('#<h3>' . __("Additional Capabilities") . '</h3>#s', '', $personal_options, 1); // Remove the "About the user" title
	
	return $personal_options;
}

function wordpress_profile_subject_start() {
 ob_start('wordpress_remove_user_personal_options');
}

function wordpress_profile_subject_end() {
 ob_end_flush();
}

// Hooks.
add_action('admin_head', 'wordpress_profile_subject_start');
add_action('admin_footer', 'wordpress_profile_subject_end');

//REMOVE COLOR BARS
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

//REMOVE FIELDS FROM REGISTRATION FORM
add_action('admin_footer', 'remove_first_name_and_last_name');
function remove_first_name_and_last_name() { 
	global $pagenow;
			if ($pagenow !='user-new.php') return;
	echo '<script>
			jQuery(document).ready(function(){
			jQuery(".user-new-php #url, #send_user_notification").parent().parent().hide();
		jQuery(".user-new-php  #ure_select_other_roles").parent().parent().hide();
	});
	</script>';
}

//REMOVE ROLES FIELDS FROM USER FORM
add_action('admin_footer', 'remove_shit');
function remove_shit() { 
	global $pagenow;
			if ($pagenow !='user-edit.php') return;
	echo '<script>
			jQuery(document).ready(function(){
		jQuery("#ure_select_other_roles").parent().parent().parent().hide();
	});
	</script>';
}
?>