<?php
/*
Plugin Name: Force Post Title
Plugin URI: http://www.jpsays.com
Description: Forces user to assign a Title to a post before publishing 
Contributors: j_p_s
Author: Jatinder Pal Singh
Version: 1.1
Author URI: http://www.jpsays.com/
*/ 
function force_post_title_init() 
{
  wp_enqueue_script('jquery');
}
function force_post_title() 
{
  echo "<script type='text/javascript'>\n";
  echo "
  jQuery('#publish').click(function(){
		var testervar = jQuery('[id^=\"titlediv\"]')
		.find('#title');
		if (testervar.val().length < 1)
		{
			jQuery('[id^=\"titlediv\"]').css('background', '#F96');
			setTimeout(\"jQuery('#ajax-loading').css('visibility', 'hidden');\", 100);
			alert('POST TITLE is required');
			setTimeout(\"jQuery('#publish').removeClass('button-primary-disabled');\", 100);
			return false;
		}
  	});
  ";
   echo "</script>\n";
}
add_action('admin_init', 'force_post_title_init');
add_action('edit_form_advanced', 'force_post_title');
?>