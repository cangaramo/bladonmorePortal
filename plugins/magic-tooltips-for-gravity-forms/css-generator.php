<?php

add_action( 'admin_menu', 'mtfgf_tooltip_generator_add_admin_menu' );
add_action( 'admin_init', 'mtfgf_tooltip_generator_init' );


function mtfgf_get_style($id){
	if(intval($id)>0){
		$post = get_post(intval($id));
		// echo $post->post_content;
		// die();
		if((!$post) || ($post->post_type!='mtfgf_styles') ) {
			wp_redirect(admin_url('admin.php?page=mtfgf_tooltip_generator'));
			// exit;
		}
		$content = str_replace('#&92;', "\\", $post->post_content);
		return json_decode($content, true);
	}
	else {
		return get_option( 'mtfgf_tooltip_generator' );
	}
}

//Get all styles
function mtfgf_all_named_styles($include_style = false){
	$all_named_styles_query = new WP_Query(
	    array(
	        'post_type' => 'mtfgf_styles',
	        'posts_per_page' => -1,
	        'orderby' => 'ID',
	        'order' => 'DESC',
	        'post_status' => 'publish',
	        // 'tax_query' => array(
	        //     array(
	        //         'taxonomy' => 'my_taxonomy_name_here',
	        //         'field' => 'slug',
	        //         'terms' => 'my_category_slug_here'
	        //     )
	        // )
	    )
	);

	$all_named_styles = array();
	if($all_named_styles_query->have_posts()) {
		while($all_named_styles_query->have_posts()) {
			$all_named_styles_query->the_post();
			$the_id = get_the_id();
			$the_style = array(
			 'label'=>get_the_title(),
			 'id'=> $the_id
			);

			if($include_style) {
				global $post;
				$content = str_replace('#&92;', "\\", $post->post_content);
				$the_style['style'] = json_decode($content, true);
				$all_named_styles[$the_id] = $the_style;
			}
			else {
				$all_named_styles[] = $the_style;
			}
		} 
	}
	wp_reset_query();

	return $all_named_styles;
}

function mtfgf_fix_generator_option(&$obj, $key, $defaultKey ) { 
	if(!(isset($obj[$key]) && $obj[$key])) {
		$obj[$key] = $obj[$defaultKey];
	}
}


// print_r($GLOBALS['mtfgf_css_generator_option']);
// die();

// echo $GLOBALS['mtfgf_css_generator_options_key'];
// die();

function mtfgf_tooltip_generator_add_admin_menu(  ) { 

	add_submenu_page( 
          'magic_tooltips_for_gravity_forms' 
        , 'Tooltip Style Generator' 
        , 'Tooltip Style Generator'
        , 'manage_options'
        , 'mtfgf_tooltip_generator'
        , 'mtfgf_tooltip_generator_page'
    );
//plugins_url( 'assets/img/icon-17.png', __FILE__ )
}

function mtfgf_tooltip_generator_before_save($options_tooltip_generator, $old_value) {
	$license_control = true;
	if($license_control) {
		$options = get_option( 'mtfgf_settings' );
		if(isset($options['license_key']) && $options['license_key']) {
			$is_valid_license = mtfgf_check_license($options['license_key'], true);
			if($options['is_valid_license_key'] != $is_valid_license) {
				$options['is_valid_license_key'] = $is_valid_license;
				update_option('mtfgf_settings', $options);
			}
		}
	}

	if(isset($_GET['mtfgf_style']) && (intval($_GET['mtfgf_style'])>0)){
		$content = str_replace("\\", '#&92;', json_encode($options_tooltip_generator));
		// Update post 
		$mtfgf_style = array(
		    'ID'           => intval($_GET['mtfgf_style']),
		    'post_content' => $content
		);
		remove_filter ('the_content', 'wpautop'); 
		// Update the post into the database
		wp_update_post( $mtfgf_style );

		return $old_value;
	}

	return $options_tooltip_generator;
}


function mtfgf_tooltip_generator_init(  ) { 
	register_setting( 'mtfgf_tooltip_generator', 'mtfgf_tooltip_generator' );

	// echo $GLOBALS['mtfgf_css_generator_options_key'];
	// die();
	add_filter( 'pre_update_option_mtfgf_tooltip_generator', 'mtfgf_tooltip_generator_before_save', 10, 2 );

	add_settings_section(
		'mtfgf_tooltip_generator_section', 
		__( 'Your section description', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_tooltip_generator_section_callback', 
		'mtfgf_tooltip_generator'
	);

	$settings_fields_key = array('', '_pad', '_phone');
	for($i =0; $i < 3; $i++) {
		add_settings_field( 
			'css_code'.$settings_fields_key[$i], 
			__( 'Css Code'.$settings_fields_key[$i], 'magic_tooltips_for_gravity_forms' ), 
			'mtfgf_tooltip_generator_css_code'.$settings_fields_key[$i].'_render', 
			'mtfgf_tooltip_generator', 
			'mtfgf_tooltip_generator_section' 
		);

		add_settings_field( 
			'css_options'.$settings_fields_key[$i], 
			__( 'Css Options'.$settings_fields_key[$i], 'magic_tooltips_for_gravity_forms' ), 
			'mtfgf_tooltip_generator_css_options'.$settings_fields_key[$i].'_render', 
			'mtfgf_tooltip_generator', 
			'mtfgf_tooltip_generator_section' 
		);

		add_settings_field( 
			'js_code'.$settings_fields_key[$i], 
			__( 'Js Code'.$settings_fields_key[$i], 'magic_tooltips_for_gravity_forms' ), 
			'mtfgf_tooltip_generator_js_code'.$settings_fields_key[$i].'_render', 
			'mtfgf_tooltip_generator', 
			'mtfgf_tooltip_generator_section' 
		);
	}
	
	if(!(isset($_GET['page']) && 
		$_GET['page']=='mtfgf_tooltip_generator')) {
		return;
	}

	$GLOBALS['mtfgf_css_generator_options_key'] = mtfgf_get_css_generator_options_key();

	$GLOBALS['mtfgf_css_generator_option'] = mtfgf_get_style(isset($_GET['mtfgf_style']) ? $_GET['mtfgf_style'] : 'default'); //get_option( 'mtfgf_tooltip_generator' );

	mtfgf_fix_generator_option($GLOBALS['mtfgf_css_generator_option'], 'css_code_pad', 'css_code');
	mtfgf_fix_generator_option($GLOBALS['mtfgf_css_generator_option'], 'css_code_phone', 'css_code');

	mtfgf_fix_generator_option($GLOBALS['mtfgf_css_generator_option'], 'css_options_pad', 'css_options');
	mtfgf_fix_generator_option($GLOBALS['mtfgf_css_generator_option'], 'css_options_phone', 'css_options');

	mtfgf_fix_generator_option($GLOBALS['mtfgf_css_generator_option'], 'js_code_pad', 'js_code');
	mtfgf_fix_generator_option($GLOBALS['mtfgf_css_generator_option'], 'js_code_phone', 'js_code');

	// TO DO: add named style support begin
	// wp_register_style( 'jquery_modal_mode', plugins_url( "assets/css/jquery.modal.css", __FILE__ ), array(), '0.9.1');
	// wp_enqueue_style( 'jquery_modal_mode' );
	// wp_register_script( 'jquery_modal_mode', plugins_url( "assets/js/jquery.modal.js", __FILE__ ), array('jquery'), '0.9.1');

	// wp_enqueue_script( 'jquery_modal_mode' );


	// wp_register_style( 'mtfgf_fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7');
	// wp_enqueue_style( 'mtfgf_fontawesome' );

	// wp_register_style( 'mtfgf_css_generator', plugins_url( "assets/css/css-generator.css", __FILE__ ), array(), MTFGF_VER);
	// wp_enqueue_style( 'mtfgf_css_generator' );
	// wp_register_script( 'mtfgf_css_generator', plugins_url( "assets/js/css-generator.js", __FILE__ ), array('jquery'), MTFGF_VER);

	// wp_enqueue_script( 'mtfgf_css_generator' );
	// 
	// TO DO: add named style support end

	

	
}


function mtfgf_tooltip_generator_css_code_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-css-code" type='text' name='mtfgf_tooltip_generator[css_code]' value='<?php echo $options['css_code']; ?>'>
	<?php

}

function mtfgf_tooltip_generator_css_options_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-css-options" type='text' name='mtfgf_tooltip_generator[css_options]' value='<?php echo $options['css_options']; ?>'>
	<?php

}

function mtfgf_tooltip_generator_js_code_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-js-code" type='text' name='mtfgf_tooltip_generator[js_code]' value='<?php echo $options['js_code']; ?>'>
	<?php
}

/**
 * Pad
 * @return [type] [description]
 */
function mtfgf_tooltip_generator_css_code_pad_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-css-code-pad" type='text' name='mtfgf_tooltip_generator[css_code_pad]' value='<?php echo $options['css_code_pad']; ?>'>
	<?php

}

function mtfgf_tooltip_generator_css_options_pad_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-css-options-pad" type='text' name='mtfgf_tooltip_generator[css_options_pad]' value='<?php echo $options['css_options_pad']; ?>'>
	<?php

}

function mtfgf_tooltip_generator_js_code_pad_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-js-code-pad" type='text' name='mtfgf_tooltip_generator[js_code_pad]' value='<?php echo $options['js_code_pad']; ?>'>
	<?php
}

/**
 * Mobile
 * @return [type] [description]
 */
function mtfgf_tooltip_generator_css_code_phone_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-css-code-phone" type='text' name='mtfgf_tooltip_generator[css_code_phone]' value='<?php echo $options['css_code_phone']; ?>'>
	<?php

}

function mtfgf_tooltip_generator_css_options_phone_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-css-options-phone" type='text' name='mtfgf_tooltip_generator[css_options_phone]' value='<?php echo $options['css_options_phone']; ?>'>
	<?php

}

function mtfgf_tooltip_generator_js_code_phone_render() { 
	$options = $GLOBALS['mtfgf_css_generator_option'];
	?>
	<input id="mtfgf-tooltip-generator-js-code-phone" type='text' name='mtfgf_tooltip_generator[js_code_phone]' value='<?php echo $options['js_code_phone']; ?>'>
	<?php
}

function mtfgf_tooltip_generator_section_callback(  ) { 
	echo __( 'Use this tool to generate your custom tooltip style. You can generate css for desktop, pad and phone seperately to get responsive support.', 'magic_tooltips_for_gravity_forms' );
}

function mtfgf_named_style_selected($name) {
	$selected  = ' selected="selected"';
	if(!isset($_GET['mtfgf_style'])) {
		return $name == 'default' ? $selected : '';
	}
	else {
		return $name == $_GET['mtfgf_style'] ? $selected : '';
	}
}

function mtfgf_selected($device) {
	$selected  = ' selected="selected"';
	if(!isset($_GET['mtfgf_device'])) {
		return $device == 'pc' ? $selected : '';
	}
	else {
		return $device == $_GET['mtfgf_device'] ? $selected : '';
	}
}

function mtfgf_get_css_generator_options_key() {
	$device = (!isset($_GET['mtfgf_device'])) ? 'pc' : $_GET['mtfgf_device'];

	switch ($device) {
		
		case 'pad':
			return '-pad';
			break;
		case 'phone':
			return '-phone';
			break;
		case 'pc':
		default:
			return '';
			break;
	}
}

function mtfgf_tooltip_generator_page(  ) { 
	?>
	<form action='options.php?mtfgf_style=<?php echo isset($_GET['mtfgf_style']) ? $_GET['mtfgf_style'] : 'default'; ?>' id="mtfgf-tooltip-generator-form" method='post'>
		<h1>Tooltip Style Generator</h1>
		<style>
			#mtfgf-tooltip-generator-form .form-table {
				display: none;
			}

			#mtfgf-tooltip-generator-form .form-table input {
				width: 100%;
			}
		</style>
		<div class="mtfgf-tooltip-generator-form-box">
		<?php
		settings_fields( 'mtfgf_tooltip_generator' );
		do_settings_sections( 'mtfgf_tooltip_generator' );
		?>
		</div>
		<div class="text">
	      <h2 style="display: block;">Choose a Named Style</h2>
	      <div class="inline-container">
	          <select id="mtfgf-named-style-picker" opt-key="<?php echo mtfgf_get_css_generator_options_key(); ?>" class="form-control">
	          	<option value="default" <?php echo mtfgf_named_style_selected('default'); ?>>Default</option>
	          	<?php 
	          	$named_styles = mtfgf_all_named_styles();
	          	foreach($named_styles as $cc => $named_style) {
				    echo '<option value="' . $named_style['id'] . '" '.mtfgf_named_style_selected($named_style['id']).'>' . $named_style['label'] . '</option>';
				}?>
	            
	          </select>
	          <!-- <input type="button" value="Add/Edit" class="button button-primary" id="btn-add-edit-style" name="btn-add-edit-style"> -->

	          <?php add_thickbox(); ?>
	          	<style type="text/css">
					.mtfgf_input {
					  padding: 5px;
					  -webkit-border-radius: 4px;
					  -khtml-border-radius: 4px;
					  -moz-border-radius: 4px;
					  border-radius: 4px;
					  -webkit-box-shadow: inset 0 0 4px rgba(0, 0, 0, .25), 0 0 2px #fff;
					  -moz-box-shadow: inset 0 0 4px rgba(0, 0, 0, .25), 0 0 2px #fff;
					  box-shadow: inset 0 0 4px rgba(0, 0, 0, .25), 0 0 2px #fff;
					  border: 1px solid #7e7e7e;
					  background-color: #fff;
					}
	          	</style>
				<a id="mtfgf_btn_edit_styles" title="Magic Tooltips Styles" href="<?php echo admin_url('edit.php?post_type=mtfgf_styles'); ?>&amp;TB_iframe=true&amp;width=600&amp;height=550" class="thickbox button button-primary">Edit</a>
				<input id="mtfgf_input_new_style_name" style="display: none;" class="mtfgf_input" type="text" placeholder="Please enter a new name" />
				<button id="mtfgf_btn_dulplicate_style" title="Dulplicate Magic Tooltips Style" class="button">Dulplicate</button>
				<button id="mtfgf_btn_confirm" style="display: none;" class="button button-primary">OK</button>
				<button id="mtfgf_btn_cancel" style="display: none;" class="button">Cancel</button>
	          <script type="text/javascript">
			    (function($){ 
			    	$('#mtfgf_btn_dulplicate_style').click(function(){
			    		$('#mtfgf_btn_edit_styles').hide();
			    		$('#mtfgf_btn_dulplicate_style').hide();
			    		$('#mtfgf_input_new_style_name').show();
			    		$('#mtfgf_btn_confirm').show();
			    		$('#mtfgf_btn_cancel').show();
			    		return false;
			    	});

			    	$('#mtfgf_btn_cancel').click(function(){
			    		$('#mtfgf_btn_edit_styles').show();
			    		$('#mtfgf_btn_dulplicate_style').show();
			    		$('#mtfgf_input_new_style_name').hide();
			    		$('#mtfgf_btn_confirm').hide();
			    		$('#mtfgf_btn_cancel').hide();
			    		return false;
			    	});

			    	//确认复制样式
			    	$('#mtfgf_btn_confirm').click(function(){
			    		$('#mtfgf_btn_edit_styles').show();
			    		$('#mtfgf_btn_dulplicate_style').show();
			    		$('#mtfgf_input_new_style_name').hide();
			    		$('#mtfgf_btn_confirm').hide();
			    		$('#mtfgf_btn_cancel').hide();

			    		$newLabel = $('#mtfgf_input_new_style_name').val();

			    		if($newLabel) {
			    			location.href = '<?php echo admin_url('admin.php?page=mtfgf_tooltip_generator');?>'+'&mtfgf_device='+$('#mtfgf-device-picker').val()+'&mtfgf_dulplicate_id='+$('#mtfgf-named-style-picker').val()+'&mtfgf_dulplicate_label='+encodeURIComponent($('#mtfgf_input_new_style_name').val());
			    		}

			    		
			    		return false;
			    	});
			    	// Open modal in AJAX callback
			    	$('#mtfgf-named-style-picker').change(function () {
				        location.href = '<?php echo admin_url('admin.php?page=mtfgf_tooltip_generator');?>'+'&mtfgf_device='+$('#mtfgf-device-picker').val()+'&mtfgf_style='+$(this).val();
				    })
				    
	
// 					$('#btn-add-edit-style').click(function(event) {
// 						event.preventDefault();
// 						var html = `<div id="mtfgf-named-style-editing-list"><div class="demo-wrapper">
//   <header>
//       <h1>Creative Add/Remove Effects for List Items</h1>
//   </header>
//   <div class="notification undo-button">Item Deleted. Undo?</div>
//   <div class="notification save-notification">Item Saved</div>
//   <div class="reminder-container">
    
//     <form id="input-form">
//       <input type="text" id="text" placeholder="Remind me to.."/>
//       <input type="submit" value="Add" />
//     </form>
//     <ul class="reminders">

//     </ul>
//     <footer>
//       <span class="count"></span>
//       <button class="clear-all">Delete All</button>
//     </footer>
//   </div>
  
    
// </div><!--end demo-wrapper--><div>`;
// 						$(html).appendTo('body').modalmm();
// 					});
					// TO DO: add named style support end
			    })(jQuery);    
			</script>
	      </div>
	    </div>
		<div class="text">
	      <h2 style="display: block;">Choose a Device</h2>
	      <div class="inline-container">
	          <select id="mtfgf-device-picker" opt-key="<?php echo mtfgf_get_css_generator_options_key(); ?>" class="form-control">
	            <option value="pc" <?php echo mtfgf_selected('pc'); ?>>Desktop</option>
	            <option value="pad" <?php echo mtfgf_selected('pad'); ?>>Pad and Tablet</option>
	            <option value="phone" <?php echo mtfgf_selected('phone'); ?>>Mobile Phone</option>
	          </select>
	          <script type="text/javascript">
			    (function($){
			    	$('#mtfgf-device-picker').change(function () {
				        location.href = '<?php echo admin_url('admin.php?page=mtfgf_tooltip_generator');?>'+'&mtfgf_device='+$(this).val()+'&mtfgf_style='+$('#mtfgf-named-style-picker').val();
				    })
			    })(jQuery);    
			</script>
	      </div>
	    </div>
		<iframe id="mtfgf-tooltip-generator-iframe" src="<?php echo plugins_url('/magic-tooltips-for-gravity-forms/assets/tooltip-style-generator/index.html?ver='.MTFGF_VER) ?>" align="middle" width="95%" height="460" style="overflow:hidden" frameborder="0"></iframe>
		
		<p class="submit">
		<?php submit_button(null, 'primary', 'submit', false); ?>
		<input type="button" value="Reset" class="button button-info" id="reset-css" name="reset"></p>
	</form>
	<?php

}

?>