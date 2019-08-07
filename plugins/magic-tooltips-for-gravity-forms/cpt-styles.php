<?php 


use PostTypes\PostType;



$names = array(
    'name' => 'mtfgf_styles',
    'singular' => 'Magic Tooltips Style',
    'plural' => 'Magic Tooltips Styles',
    'slug' => 'mtfgf_styles'
);

$options = array(
    'show_in_menu'        => false,   
    'show_in_nav_menus'   => false,
    'supports'      =>  array('title')    
);

$mtfgf_styles = new PostType($names, $options);

$mtfgf_styles->register();

add_action( 'admin_init', 'mtfgf_cpt_styles_init' );

function mtfgf_dulplcate_style($id, $label){
	if($id=='default'){
		$content = json_encode(get_option( 'mtfgf_tooltip_generator' ));
		$content = str_replace("\\", '#&92;', $content);
	}
	else {
		$post = get_post(intval($id));
		$content = $post->post_content;
	}

	$default_named_style = array(
		'post_title' => $label,
		'post_type' => 'mtfgf_styles',
		'post_status' =>   'publish',
		'post_content' => $content
	);
	remove_filter ('the_content', 'wpautop'); 


	
	$mtfgf_named_style = wp_insert_post($default_named_style);

	return $mtfgf_named_style;
}

function mtfgf_cpt_styles_init()
{
	if(isset($_GET['mtfgf_dulplicate_id']) && $_GET['mtfgf_dulplicate_id'] && isset($_GET['mtfgf_dulplicate_label']) && $_GET['mtfgf_dulplicate_label']){
		$new_id = mtfgf_dulplcate_style($_GET['mtfgf_dulplicate_id'], $_GET['mtfgf_dulplicate_label']);

		$redirect_url = remove_query_arg( array('mtfgf_dulplicate_id', 'mtfgf_dulplicate_label') );

		$redirect_url .= '&mtfgf_style='.$new_id;

		wp_redirect($redirect_url);
		exit;
	}
	//create default styles
	//$enabled_named_styles = get_option('mtfgf_enabled_named_styles', false );
	//if(!$enabled_named_styles)  {
		// $default_named_style = array(
		// 	'post_title' => 'Default',
		// 	'post_type' => 'mtfgf_styles',
		// 	'post_status' =>   'publish',
		// 	'post_content' => json_encode(get_option( 'mtfgf_tooltip_generator' ))
		// );
		// $mtfgf_named_style = wp_insert_post($default_named_style);
		// // var_dump($mtfgf_named_style);
		// // print_r($default_named_style);

		// // die();
		// update_option( 'mtfgf_enabled_named_styles', 'yes' );
	//}
}



?>