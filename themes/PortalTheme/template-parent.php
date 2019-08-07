<?php
/*
Template Name: Content Components
*/
$fields = get_fields(get_the_ID());

if (empty($fields)) {
	echo '<div class="component-error">ACF: NO FIELDS TO OUTPUT</div>';
	return;
}

// make array of page components
$page_components = array();
foreach($fields['components'] as $field){
	if($field_name !== 'components'){
		array_push($page_components, $field['acf_fc_layout']);
	}
}

if( get_current_user_id()== 0 ): 
			
	$siteurl = home_url();
	$url = $siteurl . "/login";
	wp_redirect( $url );
	exit;

endif;

?>

<?php get_header(); ?>
			
	<main>

		<div class="row p-0">

			<div class="d-none d-lg-flex col-3 p-0">
				<?php get_sidebar(); ?>
			</div>

			<div class="col-12 col-lg-9 p-0">
				<?php
				foreach($page_components as $index => $component){
					require('parts/util-get-component-values.php');
					require(locate_template( 'parts/component-' . $component . '.php', false, false));
				}
				?>
			</div>
		</div>
	
	</main> <!-- end #content -->

<?php get_footer(); ?>
