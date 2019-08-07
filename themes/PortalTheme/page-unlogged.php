<?php 
	global $user_login;
					  
	// If user is already logged in: Go to home
	if ( is_user_logged_in() ) : 
		$siteurl = home_url();
		$url = $siteurl . "/dashboard";
		wp_redirect( $url );
		exit;
	endif;
?>

<?php get_header(); ?>
			
	<main>

		<div class="gray-bg">
			
			<div class="container small-padding min-650 d-flex align-items-center">

				<div class="w-100">

					<?php
						$siteurl = home_url();
						$url = $siteurl . "/login";		
					?>

					<div class="p-2 p-6 w-100 h-100 d-flex text-center justify-content-center align-items-center" >
						<p class="unlogged">Please <a href="<?php echo $url?>">login</a> to see the content</p>
					</div>

				</div>

			</div>

		</div>

	</main>

<?php get_footer(); ?>
