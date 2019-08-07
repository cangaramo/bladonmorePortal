<?php
/***********************************************************************************************/
/* Add Menus */
/***********************************************************************************************/
  add_theme_support( 'post-thumbnails' ); 
  
	register_nav_menus(
		array(
			'delegate' => __('Delegate Menu'),
			'client' => __('Client Menu'),
			'footer' => __('Footer  Menu'),
		)
	);

?>