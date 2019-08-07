<?php
/**
 * LOGIN FAILED AND EMPTY
 */

function custom_login_failed( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];
 
    if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		$siteurl = home_url();
		$url = $siteurl . "/login?login=failed'";
        wp_redirect($url );
   //exit;
    }
}
add_action( 'wp_login_failed', 'custom_login_failed' );


/* Where to go if any of the fields were empty */
function verify_user_pass($user, $username, $password) {
	$login_page  = home_url('/login/');
	if($username == "" || $password == "") {
		wp_redirect($login_page . "?login=empty");
		exit;
	}
}
add_filter('authenticate', 'verify_user_pass', 1, 3);


/* Main redirection of the default login page */
function redirect_login_page() {
	$login_page  = home_url('/login/');
	$page_viewed = basename($_SERVER['REQUEST_URI']);

	if($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
		wp_redirect($login_page);
		exit;
	}
}


add_action('init','redirect_login_page');
?>