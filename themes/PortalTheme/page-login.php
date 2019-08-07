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
	<div class="bg">

		<div class="layer w-100">
			
			<div class="container small-padding min-650">

				<div class="row">
					<div class="col-12 col-lg-6 pb-3">
						<a href="<?php echo home_url(); ?>"><img style="height:30px" src="<?php echo get_bloginfo('template_directory'); ?>/images/white-logo.png"></a>
					</div>
					<div class="col-12 col-lg-6 float-left text-left float-lg-right text-lg-right">
						<a href="<?php echo home_url(); ?>"><img style="height:40px" src="<?php echo get_bloginfo('template_directory'); ?>/images/story-told.png"></a>
					</div>
				</div>

				<div class="row" >
					<div class="col-12 col-lg-6" style="height:85vh">
						<div class="h-100 d-flex align-items-center">
							<div>
								<?php require('parts/part-login.php'); ?>
							</div>
						</div>
					</div>
					<div class="col-6"></div>
				</div>

			</div>
		<div>

	</div>
</main>

<?php get_footer(); ?>
