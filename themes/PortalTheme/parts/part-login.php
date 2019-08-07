<?php 

	global $user_login;
	// In case of a login error.
	if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
		<p class="login-error">Invalid username or password</p>
	<?php endif;
								
	// Empty field
	if ( isset( $_GET['login'] ) && $_GET['login'] == 'empty' ) : ?>
		<p class="login-error">Please fill in the fields</p>
	<?php endif;
						
	// Login form arguments.
	$args = array(
		'echo'           => true,
		'redirect'       => home_url( '/dashboard/' ), 
		'form_id'        => 'loginform',
		'label_username' => __( 'Username' ),
		'label_password' => __( 'Password' ),
		'label_remember' => __( 'Remember Me' ),
		'label_log_in'   => __( 'Log In' ),
		'id_username'    => 'user_login',
		'id_password'    => 'user_pass',
		'id_remember'    => 'rememberme',
		'id_submit'      => 'wp-submit',
		'remember'       => false,
		'value_username' => NULL,
		'value_remember' => true
	); 
	// Calling the login form.
	wp_login_form( $args );
							
?> 