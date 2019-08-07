<?php
/*
	Magic Tooltips For Gravity Forms
*/
if ( ! defined( 'ABSPATH' ) ) exit;

$mtfgf_options = get_option( 'mtfgf_settings' );
$GLOBALS['mtfgf_is_valid_license_key'] = isset($mtfgf_options['is_valid_license_key']) && (intval($mtfgf_options['is_valid_license_key'])==1);
$GLOBALS['mtfgf_disable_wp_editor'] = isset($mtfgf_options['disable_wp_editor']) && (intval($mtfgf_options['disable_wp_editor'])==1);
// echo $GLOBALS['mtfgf_is_valid_license_key'];
// die();

require_once ('lib/wp-hooks.php');

class MagicTooltipsForGravityForms extends MMWP_Hooks {

	private $editor_id = 'content';
	private $ver = MTFGF_VER;
	private $ver_css = MTFGF_VER;
	private $ver_other = MTFGF_VER;

	function maybe_better_font_awesome_enqueue_scripts(&$required_objects){
		global $better_font_awesome;
		if(!empty($better_font_awesome)) {
			$args = array(
	            'version'            => 'latest',
		        'minified'           => 1,
		        'remove_existing_fa' => '',
		        'hide_admin_notices' => '',
	            'load_styles'         => true,
	            'load_admin_styles'   => true,
	            'load_shortcode'      => true,
	            'load_tinymce_plugin' => true,
	        );

	        $better_font_awesome_lib = Better_Font_Awesome_Library::get_instance( $args );
			$admin_enqueue_scripts = $better_font_awesome_lib->enqueue_admin_scripts();

			$better_font_awesome_lib->register_font_awesome_css();

			$required_objects[] = Better_Font_Awesome_Library::SLUG.'-font-awesome';
			$required_objects[] = Better_Font_Awesome_Library::SLUG.'-admin';
			$required_objects[] = 'fontawesome-iconpicker';



			// $admin_enqueue_styles = $better_font_awesome_lib->register_font_awesome_css();
			
		}
	}

	function gform_noconflict_scripts($required_objects) {
		if(is_admin()) {
			
			$this->maybe_better_font_awesome_enqueue_scripts($required_objects);
			$this->admin_enqueue_scripts();
			// wp_enqueue_script( 'mce-view' );
			
			$required_objects[] = 'mce-view';
			$required_objects[] = 'mtfgf_admin';
			$required_objects[] = 'jquery_fonticonpicker';

			//Advanced WP Columns
			$required_objects[] = 'advanced_wp_columns_handle';

			//Popup Maker
			$required_objects[] = 'pum-admin-shortcode-ui';

			//Layer Slider WP
			$required_objects[] = 'layerslider-global';
			$required_objects[] = 'layerslider-embed';
		}
		return $required_objects;
	}

	function gform_noconflict_styles($required_objects) {
		if(is_admin()) {
			// 
			$this->maybe_better_font_awesome_enqueue_scripts($required_objects);
			$this->admin_enqueue_scripts();

			// $required_objects[] = 'better-font-awesome-admin';
			// $required_objects[] = 'fontawesome-iconpicker';
			$required_objects[] = 'mce-view';
			$required_objects[] = 'mtfgf_admin';
			$required_objects[] = 'jquery_fonticonpicker';
			$required_objects[] = 'jquery_fonticonpicker.theme.gray';

			//Advanced WP Columns
			$required_objects[] = 'dry_awp_admin_style';

			//Popup Maker
			$required_objects[] = 'pum-admin-shortcode-ui';

			//Layer Slider WP
			$required_objects[] = 'layerslider-global';
			$required_objects[] = 'layerslider-embed';
			
		}
		return $required_objects;
	}
	
	function admin_enqueue_scripts() {
		// die();
		// Register and Enqueue a Stylesheet
		if(is_admin()) {
		    wp_enqueue_style( 'wp-color-picker' ); 

		    if(isset($_GET['page']) && $_GET['page']=='gf_edit_forms'){
		    	//Popup Maker
				$GLOBALS['typenow'] = 'post';
		    }

		    
		    wp_register_style( 'mtfgf_admin', plugins_url( 'assets/css/admin.css', __FILE__ ), false, $this->ver_css);
		    wp_enqueue_style( 'mtfgf_admin' );
		    // wp_print_style('mtfgf_admin');

		    wp_register_script( 'mtfgf_admin', plugins_url( "assets/js/admin.js", __FILE__ ), array('jquery', 'wp-color-picker'), $this->ver);
	    	wp_enqueue_script( 'mtfgf_admin' );


	    	wp_register_script( 'jquery_fonticonpicker', plugins_url( "assets/fontIconPicker/jquery.fonticonpicker.min.js", __FILE__ ), array('jquery', 'wp-color-picker'), $this->ver);
	    	wp_enqueue_script( 'jquery_fonticonpicker' );

	    	wp_register_style( 'jquery_fonticonpicker', plugins_url( 'assets/fontIconPicker/css/jquery.fonticonpicker.min.css', __FILE__ ), false, $this->ver_other);
		    wp_enqueue_style( 'jquery_fonticonpicker' );

		    wp_register_style( 'jquery_fonticonpicker.theme.gray', plugins_url( 'assets/fontIconPicker/themes/grey-theme/jquery.fonticonpicker.grey.min.css', __FILE__ ), false, $this->ver_other);
		    wp_enqueue_style( 'jquery_fonticonpicker.theme.gray' );

		    wp_register_style( 'mtfgf_fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7');
		    wp_enqueue_style( 'mtfgf_fontawesome' );


			// wp_enqueue_media();
			// wp_enqueue_script( 'common' );
		 //    wp_enqueue_script( 'jquery-color' );
		 //    wp_print_scripts('editor');
		 //    if (function_exists('add_thickbox')) add_thickbox();
		 //    wp_print_scripts('media-upload');
		 //    if (function_exists('wp_tiny_mce')) wp_tiny_mce();
		 //    wp_admin_css();
		 //    wp_enqueue_script('utils');
		 //    do_action("admin_print_styles-post-php");
		 //    do_action('admin_print_styles');
			wp_enqueue_media();
		}   	
	}
	
	function ____wp_footer_300() {
		
		//if($GLOBALS['mtfgf_is_valid_license_key']) {
		?>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.0.0/imagesloaded.pkgd.min.js"></script>
			<style></style>
		<?php 
		//}
	}
	
	function gform_enqueue_scripts($form, $is_ajax) {


			
		// Register and Enqueue css file
		// wp_register_style( 'tooltipster', plugins_url( 'assets/css/tooltipster.css', __FILE__ ));
	 //    wp_enqueue_style( 'tooltipster' );
	 //    
	 	//if($GLOBALS['mtfgf_is_valid_license_key']) {
		    wp_register_style( 'mtfgf-magic', plugins_url( 'assets/css/jquery.magic.min.css', __FILE__ ), false, $this->ver_other);
		    wp_enqueue_style( 'mtfgf-magic' );
			
		    wp_register_style( 'mtfgf', plugins_url( 'assets/css/custom.css', __FILE__ ), false, $this->ver_css);
		    wp_enqueue_style( 'mtfgf' );
			
		    // Register and Enqueue js files
		    
		    // wp_register_script( 'jquery.tooltipster', plugins_url( "assets/js/jquery.tooltipster.min.js", __FILE__ ), array('jquery'));
		    // wp_enqueue_script( 'jquery.tooltipster' );

		    wp_register_script( 'mtfgf-magic', plugins_url( "assets/js/jquery.magic.js", __FILE__ ), array('jquery'), $this->ver_other);
		    wp_enqueue_script( 'mtfgf-magic' );
			
			// wp_register_script( 'imageloaded2', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.0.0/imagesloaded.pkgd.min.js', array('jquery'));
			// wp_enqueue_script( 'imageloaded2' );
			
			wp_register_script( 'mtfgf', plugins_url( "assets/js/custom.js", __FILE__ ), array('jquery', 'mtfgf-magic'), $this->ver);

		    wp_enqueue_script( 'mtfgf' );

		    $mtfgf_options = get_option('mtfgf_tooltip_generator', false);

		    // echo json_encode($mtfgf_options);
		    // die();

		    wp_localize_script( 'mtfgf', 'mtfgf', $mtfgf_options);

		    $mtfgf_settings = get_option('mtfgf_settings', false);

		    $mtfgf_all_named_styles = mtfgf_all_named_styles(true);
		    wp_localize_script( 'mtfgf', 'mtfgf_named_styles', $mtfgf_all_named_styles);

		    // echo json_encode($mtfgf_settings);
		    // die();

		    //add fontawsome support
		    if($mtfgf_settings && $mtfgf_settings['add_icon_fontawsome']) {
		    	wp_register_style( 'mtfgf_fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7');
		    	wp_enqueue_style( 'mtfgf_fontawesome' );
		    }

		    if($mtfgf_settings && isset($mtfgf_settings['enable_lightbox']) && $mtfgf_settings['enable_lightbox']) {
		    	wp_register_style( 'swipebox', 'https://cdnjs.cloudflare.com/ajax/libs/swipebox/1.4.4/css/swipebox.min.css', array(), '1.4.4');
		    	wp_enqueue_style( 'swipebox' );
		    	wp_register_script( 'swipebox', 'https://cdnjs.cloudflare.com/ajax/libs/swipebox/1.4.4/js/jquery.swipebox.min.js', array('jquery'), '1.4.4');

		    	wp_enqueue_script( 'swipebox' );
		    }

		    // $enable_modal = rgar( $form, 'mm_tooltip_modal_mode' );

		    // var_dump($enable_modal);
		    // die();
		    // if($enable_modal) {
		    	wp_register_style( 'jquery_modal_mode', plugins_url( "assets/css/jquery.modal.css", __FILE__ ), array(), $this->ver_other);
		    	wp_enqueue_style( 'jquery_modal_mode' );
		    	wp_register_script( 'jquery_modal_mode', plugins_url( "assets/js/jquery.modal.js", __FILE__ ), array('jquery'), $this->ver_other);

		    	wp_enqueue_script( 'jquery_modal_mode' );
		    // }

		    $license_control = true;
			if(!$license_control) {
				$mtfgf_settings['is_valid_license_key'] = 1;
			}
			
			if(isset($mtfgf_settings['license_key'])) {
				unset($mtfgf_settings['license_key']);
			}

			// $mtfgf_settings['mtfgf_enable_no_label_mode'] = rgar( $form, 'mtfgf_enable_no_label_mode1' );
			// $mtfgf_settings['mtfgf_no_label_show_q_mark'] = rgar( $form, 'mtfgf_no_label_show_q_mark1' );
			// $mtfgf_settings['mtfgf_no_label_show_required'] = rgar( $form, 'mtfgf_no_label_show_required1' );
			// 
			// $mtfgf_settings['mtfgf_enable_form_button_tooltip'] = rgar( $form, 'mtfgf_enable_form_button_tooltip' );
			// $mtfgf_settings['mtfgf_form_button_tooltip_content'] = rgar( $form, 'mtfgf_form_button_tooltip_content' );

		    wp_localize_script( 'mtfgf', 'mtfgf_settings', $mtfgf_settings);
		//}
	}

	// function gform_field_input( $input, $field, $value, $lead_id, $form_id ) {
	// 	if( $field["cssClass"] == 'richtext' ) {

	// 		// ob_start();
	// 		// wp_editor( $value, "input_{$form_id}_{$field['id']}",
	// 	 //  		array(
	// 		// 		'media_buttons' => false,
	// 		// 		'textarea_name' => "input_{$field['id']}"
	// 		// 	)	);
	// 		// $input = ob_get_clean();
	// 	}
	// 	print_r(array($input, $field, $value, $lead_id, $form_id));
	// 	return $input;
	// }



	function gform_field_advanced_settings($position, $form_id){
		//TODO: flannian 2017-12-5 put tooltip settings into tab
		if ( $position == -1 ) {
	        ?>
	        </ul>
	        </div>
	        <div id="gform_tab_1977">
			<ul>
	        <?php
	//     }
	// }

	// function gform_field_standard_settings( $position, $form_id ) {
		// global $mm_field_id;


		/*<?php wp_editor( '', $prefix.$form_id.'0'.$mm_field_id, array(
						'media_buttons' => true,
						'textarea_name' => $prefix.$form_id.'0'.$mm_field_id
					)); ?>*/
	    //create settings on position 25 (right after Field Label)
	    // if ( $position == 25 ) {
	    	$editor_id = 'content';//'mm_tooltip_text_value'; //'mm_tooltip_text_value'
	  //   	if(!isset($mm_field_id)) {
			// 	$mm_field_id = 1;
			// }
			// else {
			// 	$mm_field_id = $mm_field_id+1;
			// }
	        
	        ?>

	        <li class="mm_tooltip_text field_setting">
	            <label for="field_admin_label" class="section_label">
	                <?php _e( 'Tooltip Content', 'gravityforms' ); ?>
	                <?php gform_tooltip( $editor_id ) ?>
	            </label>
	            <!-- <div id="mm_tooltip_text_editor_container"></div> -->
	            <?php 
					// wp_enqueue_media();
	            	if(!$GLOBALS['mtfgf_disable_wp_editor']) {
		            	wp_editor( '', $editor_id, array(
							'media_buttons' => true,
							'textarea_name' => $editor_id
						)); 
		            }
		            else {
				?>
	            <textarea id="mm_tooltip_text_value" class="fieldwidth-3 fieldheight-2"></textarea>
	            <?php } ?>
	        </li>
	        <li class="mm_tooltip_text field_setting">
	            <label for="field_admin_label" class="section_label">
	                <?php _e( 'Tooltip Options', 'gravityforms' ); ?>
	            </label>
	            <div><input type="checkbox" id="field_mm_enable_custom_icon" onclick="SetFieldProperty('mm_enable_custom_icon', this.checked);" /> Enable custom help icon <select id="field_mm_custom_icon">
	            	<?php $option_s = get_option( 'mtfgf_settings' );
	$custom_icons = $option_s['custom_icons'];
	if(empty($custom_icons)) {
		$custom_icons = mtfgf_get_default_icons();
	}
	echo mtfgf_get_icons_select_options_html($custom_icons);
	 ?> 
				</select></div>
				<div><input type="checkbox" id="field_mm_enable_force_show_tooltip" onclick="SetFieldProperty('mm_enable_force_show_tooltip', this.checked);" /> Display the tooltips or tooltip hint by default.
				</div>
				<div><input type="checkbox" id="field_mm_enable_named_style" onclick="SetFieldProperty('mm_enable_named_style', this.checked);" /> Enable custom tooltip style <select id="field_mm_named_style">
					<option value="default">Default</option>
	            	<?php 
		          	$named_styles = mtfgf_all_named_styles();
		          	foreach($named_styles as $cc => $named_style) {
					    echo '<option value="' . $named_style['id'] . '">' . $named_style['label'] . '</option>';
					}?>
				</select></div>
				<div style="margin-top: 10px"><input type="checkbox" id="field_mm_tooltip_no_label_mode_show_help_icon" onclick="SetFieldProperty('mm_tooltip_no_label_mode_show_help_icon', this.checked);" /> Show tooltips after input or textarea.</div>
	        </li>
	        <li class="mm_tooltip_no_label_mode field_setting">
	            <label for="field_admin_label" class="section_label">
	                <?php _e( 'No-Label Mode', 'gravityforms' ); ?>
	                <?php gform_tooltip( 'field_mm_tooltip_no_label_mode' ) ?>
	            </label>
	            <!-- <div id="mm_tooltip_text_editor_container"></div> -->
	            <div><input type="checkbox" id="field_mm_tooltip_no_label_mode" onclick="SetFieldProperty('mm_tooltip_no_label_mode', this.checked);" /> Enable No-Label Mode.
	            <input style="margin-left: 10px" type="checkbox" id="field_mm_tooltip_no_label_mode_placeholder" onclick="SetFieldProperty('mm_tooltip_no_label_mode_placeholder', this.checked);" /> Show Field Label as Placeholder.</div>
	            <div style="margin-top: 10px"><input type="checkbox" id="field_mm_tooltip_no_label_mode_required" onclick="SetFieldProperty('mm_tooltip_no_label_mode_required', this.checked);" /> Show required as * after placeholder text.</div>
	            <div style="margin-top: 10px"><input type="checkbox" id="field_mm_tooltip_no_label_mode_agree" onclick="SetFieldProperty('mm_tooltip_no_label_mode_agree', this.checked);" /> Show tooltip on option label when only one option in checkbox group.</div>
	            
	        </li>
	        <li class="mm_tooltip_modal_mode field_setting">
	            <label for="field_admin_label" class="section_label">
	                <?php _e( 'Modal Mode', 'gravityforms' ); ?>
	                <?php gform_tooltip( 'field_mm_tooltip_modal_mode' ) ?>
	            </label>
	            <!-- <div id="mm_tooltip_text_editor_container"></div> -->
	            <div><input type="checkbox" id="field_mm_tooltip_modal_mode" onclick="SetFieldProperty('mm_tooltip_modal_mode', this.checked);" /> Enable Modal Mode.</div>
	            <div style="margin-left: 23px"><input type="checkbox" id="field_mm_tooltip_mm_enable_tooltip_hint" onclick="SetFieldProperty('mm_tooltip_mm_enable_tooltip_hint', this.checked);" /> Enable tooltip hint: <input type="text" id="field_mm_tooltip_modal_tooltip_hint" size="25"></div>
	            <div style="margin-left: 23px">Read More Button Text: <input type="text" id="field_mm_tooltip_modal_more_text" size="25"></div>
	        </li>
	        <?php
	    }
	}

	function gform_editor_js() {
		if(!$GLOBALS['mtfgf_disable_wp_editor']) {
			$this->gform_editor_js_wp_edtor();
		}
		else {
			$this->gform_editor_js_textarea();
		}
	}

	function gform_editor_js_textarea(){

	    ?>
	    <script type='text/javascript'>
	        //adding setting to fields of type "text"

	        for (var key in fieldSettings) {
			  if (fieldSettings.hasOwnProperty(key)) {
			  	fieldSettings[key] += ", .mm_tooltip_text";
			  	fieldSettings[key] += ", .mm_tooltip_modal_mode";
			  	fieldSettings[key] += ", .mm_tooltip_modal_more_text";
			  	fieldSettings[key] += ", .field_mm_tooltip_modal_tooltip_hint";
			  	fieldSettings[key] += ", .mm_tooltip_mm_enable_tooltip_hint";
			  	fieldSettings[key] += ", .mm_tooltip_no_label_mode";
			  	fieldSettings[key] += ", .mm_tooltip_no_label_mode_placeholder";
			  	fieldSettings[key] += ", .mm_tooltip_no_label_mode_required";
			  	fieldSettings[key] += ", .mm_tooltip_no_label_mode_agree";
			  	fieldSettings[key] += ", .mm_enable_custom_icon";
			  	fieldSettings[key] += ", .mm_enable_named_style";
			  	fieldSettings[key] += ", .mm_enable_force_show_tooltip";
			  	fieldSettings[key] += ", .mm_custom_icon";
			  	fieldSettings[key] += ", .mm_named_style";
			  }
			}
	        //console.log(fieldSettings);

	        //binding to the load field settings event to initialize the checkbox
	        jQuery(document).bind("gform_load_field_settings", function(event, field, form){
	            jQuery("#mm_tooltip_text_value").val(field["mm_tooltip_text"]);
	            jQuery('#field_mm_tooltip_modal_mode').attr('checked', field.mm_tooltip_modal_mode == true);
	            jQuery('#field_mm_tooltip_modal_more_text').val(field.mm_tooltip_modal_more_text || 'Read More' );
	            jQuery('#field_mm_tooltip_mm_enable_tooltip_hint').attr('checked', field.mm_tooltip_mm_enable_tooltip_hint == true);
	            jQuery('#field_mm_tooltip_modal_tooltip_hint').val(field.mm_tooltip_modal_tooltip_hint || 'Click to show...' );
	            jQuery('#field_mm_tooltip_no_label_mode').attr('checked', field.mm_tooltip_no_label_mode == true);
	            jQuery('#field_mm_tooltip_no_label_mode_placeholder').attr('checked', field.mm_tooltip_no_label_mode_placeholder == true);
	            jQuery('#field_mm_tooltip_no_label_mode_required').attr('checked', field.mm_tooltip_no_label_mode_required == true);
	            jQuery('#field_mm_tooltip_no_label_mode_agree').attr('checked', field.mm_tooltip_no_label_mode_agree == true);
	            jQuery('#field_mm_tooltip_no_label_mode_show_help_icon').attr('checked', field.mm_tooltip_no_label_mode_show_help_icon == true);

	            jQuery('#field_mm_enable_custom_icon').attr('checked', field.mm_enable_custom_icon == true);

	            jQuery('#field_mm_enable_named_style').attr('checked', field.mm_enable_named_style == true);

	            jQuery('#field_mm_enable_force_show_tooltip').attr('checked', field.mm_enable_force_show_tooltip == true);
	            
	            // console.log('window.mmfontIconPicker', window.mmfontIconPicker);
	            if(!field["mm_custom_icon"]) {
	            	field["mm_custom_icon"] = 'fa fa-question-circle';
	            }
	            if(!field["mm_named_style"]) {
	            	field["mm_named_style"] = 'default';
	            }

	            if(field["mm_custom_icon"]) {
	            	jQuery("#field_mm_custom_icon").val(field["mm_custom_icon"]);

					if(!window.mmfontIconPicker) {
						window.mmfontIconPicker = typeof(jQuery('#field_mm_custom_icon').fontIconPicker) != 'undefined' ? jQuery('#field_mm_custom_icon').fontIconPicker({
							emptyIcon: false,
							hasSearch: false
						}) : false;
					}
					if(window.mmfontIconPicker && window.mmfontIconPicker.data("fontIconPicker")) {
						window.mmfontIconPicker.data("fontIconPicker").setSelectedIcon(field["mm_custom_icon"]);
					}
	            	
	            }

	            if(field["mm_named_style"]) {
	            	jQuery("#field_mm_named_style").val(field["mm_named_style"]);
	            }
	            
	            
	        });

	        jQuery('#mm_tooltip_text_value').bind('input propertychange', function() {
	        	SetFieldProperty('mm_tooltip_text', jQuery(this).val());
			});

			jQuery('#field_mm_tooltip_modal_more_text').bind('input propertychange', function() {
	        	SetFieldProperty('mm_tooltip_modal_more_text', jQuery(this).val());
			});

			jQuery('#field_mm_tooltip_modal_tooltip_hint').bind('input propertychange', function() {
	        	SetFieldProperty('mm_tooltip_modal_tooltip_hint', jQuery(this).val());
			});

			jQuery('#field_mm_custom_icon').bind('change propertychange', function() {
	        	SetFieldProperty('mm_custom_icon', jQuery(this).val());
			});

			jQuery('#field_mm_named_style').bind('change propertychange', function() {
	        	SetFieldProperty('mm_named_style', jQuery(this).val());
			});
	    </script>
	    <?php
	}
	
	
	function gform_editor_js_wp_edtor(){

	    ?>
	    <script type='text/javascript'>
	        //adding setting to fields of type "text"
	        (function($) {
		        for (var key in fieldSettings) {
				  if (fieldSettings.hasOwnProperty(key)) {
				  	fieldSettings[key] += ", .mm_tooltip_text";
				  	fieldSettings[key] += ", .mm_tooltip_modal_mode";
				  	fieldSettings[key] += ", .mm_tooltip_modal_more_text";
				  	fieldSettings[key] += ", .mm_tooltip_mm_enable_tooltip_hint";
				  	fieldSettings[key] += ", .mm_tooltip_modal_mode_tooltip_hint";
				  	fieldSettings[key] += ", .mm_tooltip_no_label_mode";
				  	fieldSettings[key] += ", .mm_tooltip_no_label_mode_placeholder";
			  		fieldSettings[key] += ", .mm_tooltip_no_label_mode_required";
			  		fieldSettings[key] += ", .mm_tooltip_no_label_mode_agree";
			  		fieldSettings[key] += ", .mm_enable_custom_icon";
			  		fieldSettings[key] += ", .mm_enable_named_style";
			  		fieldSettings[key] += ", .mm_enable_force_show_tooltip";
			  		fieldSettings[key] += ", .mm_custom_icon";
			  		fieldSettings[key] += ", .mm_named_style";
				  }
				}

				var editor_id = 'content' //'mm_tooltip_text_value';
		        var field_name = "mm_tooltip_text";
		        var current_field = false;
		        //console.log(fieldSettings);

		        //binding to the load field settings event to initialize the checkbox
		        jQuery(document).bind("gform_load_field_settings", function(event, field, form){
		        	if(window.tinymce) {
		        		tinymce.remove(tinyMCE.get(editor_id));
		        	}
		        	

		            jQuery("#"+editor_id).val(field[field_name] || '');

		            jQuery('#field_mm_tooltip_modal_mode').attr('checked', field.mm_tooltip_modal_mode == true);
		            jQuery('#field_mm_tooltip_modal_more_text').val(field.mm_tooltip_modal_more_text || 'Read More' );
		            jQuery('#field_mm_tooltip_modal_tooltip_hint').val(field.mm_tooltip_modal_tooltip_hint || 'Click to show...' );
		            jQuery('#field_mm_tooltip_mm_enable_tooltip_hint').attr('checked', field.mm_tooltip_mm_enable_tooltip_hint == true);
		            jQuery('#field_mm_tooltip_no_label_mode').attr('checked', field.mm_tooltip_no_label_mode == true);
		            jQuery('#field_mm_tooltip_no_label_mode_placeholder').attr('checked', field.mm_tooltip_no_label_mode_placeholder == true);
		            jQuery('#field_mm_tooltip_no_label_mode_required').attr('checked', field.mm_tooltip_no_label_mode_required == true);
	            	jQuery('#field_mm_tooltip_no_label_mode_agree').attr('checked', field.mm_tooltip_no_label_mode_agree == true);
					jQuery('#field_mm_tooltip_no_label_mode_show_help_icon').attr('checked', field.mm_tooltip_no_label_mode_show_help_icon == true);

					jQuery('#field_mm_enable_custom_icon').attr('checked', field.mm_enable_custom_icon == true);
					jQuery('#field_mm_enable_named_style').attr('checked', field.mm_enable_named_style == true);

					jQuery('#field_mm_enable_force_show_tooltip').attr('checked', field.mm_enable_force_show_tooltip == true);
					if(!field["mm_custom_icon"]) {
		            	field["mm_custom_icon"] = 'fa fa-question-circle';
		            }

		            if(!field["mm_named_style"]) {
		            	field["mm_named_style"] = 'default';
		            }

					if(field["mm_custom_icon"]) {
		            	jQuery("#field_mm_custom_icon").val(field["mm_custom_icon"]);
		            	// console.log('window.mmfontIconPicker', window.mmfontIconPicker);

		            	if(!window.mmfontIconPicker) {
							window.mmfontIconPicker = typeof(jQuery('#field_mm_custom_icon').fontIconPicker) != 'undefined' ? jQuery('#field_mm_custom_icon').fontIconPicker({
								emptyIcon: false,
								hasSearch: false
							}) : false;
						}
						if(window.mmfontIconPicker && window.mmfontIconPicker.data("fontIconPicker")) {
							window.mmfontIconPicker.data("fontIconPicker").setSelectedIcon(field["mm_custom_icon"]);
						}
		            }

		            if(field["mm_named_style"]) {
		            	jQuery("#field_mm_named_style").val(field["mm_named_style"]);
		            }


		            console.log('gform_post_load_field_settings 1', field_name, jQuery("#"+editor_id).val());
		        });

		        jQuery('#'+editor_id).bind('input propertychange', function() {
		        	SetFieldProperty(field_name, jQuery(this).val());
		        	console.log('update content on change',field_name, jQuery(this).val());
				});

				jQuery('#field_mm_tooltip_modal_more_text').bind('input propertychange', function() {
		        	SetFieldProperty('mm_tooltip_modal_more_text', jQuery(this).val());
				});

				jQuery('#field_mm_tooltip_modal_tooltip_hint').bind('input propertychange', function() {
		        	SetFieldProperty('mm_tooltip_modal_tooltip_hint', jQuery(this).val());
				});

				jQuery('#field_mm_custom_icon').bind('change propertychange', function() {
		        	SetFieldProperty('mm_custom_icon', jQuery(this).val());
				});

				jQuery('#field_mm_named_style').bind('change propertychange', function() {
		        	SetFieldProperty('mm_named_style', jQuery(this).val());
				});

				gform.addAction( 'gform_post_load_field_settings', function( field_form_arr ) {
					
					var field = field_form_arr[0]
        			var content = jQuery("#"+editor_id).val();
					console.log('gform_post_load_field_settings 2', content, field );
					// $('#field_settings').addClass('init_wp_editor');
					// for(var ed_instance_idx = tinymce.editors.length-1; ed_instance_idx >= 0; ed_instance_idx--){
			  //           if(tinymce.editors[ed_instance_idx].id === editor_id){
			  //               tinymce.remove(tinymce.editors[ed_instance_idx]);
			  //           }
			  //       }
			  		if(window.tinymce) {
				        switchEditors.go( editor_id, 'tmce' );

				        // $('#field_settings').removeClass('init_wp_editor');

				        setTimeout(function(){
				        	// jQuery('#wp-mm_tooltip_text_value-wrap').detach().appendTo('#mm_tooltip_text_editor_container');
							current_field = field;
				        	console.log('editor set content', content);
							tinyMCE.get(editor_id).setContent(content);
							tinyMCE.get(editor_id).onChange.add(function(ed, l) {
								console.log('editor change 1111', ed, l);
						        $('#'+editor_id).val(ed.getContent());
						        current_field[field_name] = $('#'+editor_id).val();
						    });
					        // code to trigger on AJAX form render
					        // $('#field_settings').removeClass('init_wp_editor');
					        console.log(field_name, jQuery("#"+editor_id).val());
				        }, 1000);
			        }

					
				}, 10 );

				// jQuery(document).bind('gform_post_load_field_settings', function(){
				// 	console.log('gform_post_load_field_settings');
    //     			var editor_id = 'mm_tooltip_text_value';
				
				// 	$('#field_settings').addClass('init_wp_editor');
				// 	for(var ed_instance_idx = tinymce.editors.length-1; ed_instance_idx >= 0; ed_instance_idx--){
			 //            if(tinymce.editors[ed_instance_idx].id === editor_id){
			 //                tinymce.remove(tinymce.editors[ed_instance_idx]);
			 //            }
			 //        }

				// 	// jQuery('#wp-mm_tooltip_text_value-wrap').detach().appendTo('#mm_tooltip_text_editor_container');
				// 	switchEditors.go( editor_id, 'tmce' );
			 //        // code to trigger on AJAX form render
			 //        $('#field_settings').removeClass('init_wp_editor');
			 //    });
			
			setTimeout(function(){
				// var editor_id = 'mm_tooltip_text_value';
				
				// $('#field_settings').addClass('init_wp_editor');
				// for(var ed_instance_idx = tinymce.editors.length-1; ed_instance_idx >= 0; ed_instance_idx--){
		  //           if(tinymce.editors[ed_instance_idx].id === editor_id){
		  //               tinymce.remove(tinymce.editors[ed_instance_idx]);
		  //           }
		  //       }

				// // jQuery('#wp-mm_tooltip_text_value-wrap').detach().appendTo('#mm_tooltip_text_editor_container');
				// switchEditors.go( editor_id, 'tmce' );
				// setTimeout(function(){
				// 	$('#field_settings').removeClass('init_wp_editor');
				// }, 2000);
				
		
				$('.insert-media').click( function( event ) {
					console.log('add-media-button');
					var elem = $( event.currentTarget ),
						editor = elem.data('editor'),
						options = {
							frame:    'post',
							state:    'insert',
							title:    wp.media.view.l10n.addMedia,
							multiple: true
						};

					event.preventDefault();

					// Remove focus from the `.insert-media` button.
					// Prevents Opera from showing the outline of the button
					// above the modal.
					//
					// See: https://core.trac.wordpress.org/ticket/22445
					elem.blur();

					if ( elem.hasClass( 'gallery' ) ) {
						options.state = 'gallery';
						options.title = wp.media.view.l10n.createGalleryTitle;
					}

					wp.media.editor.open( editor, options );
				});

				$( '.wp-switch-editor' ).on( 'click', function( event ) {
					var id, mode,
						target = $( event.target );

					if ( target.hasClass( 'wp-switch-editor' ) ) {
						id = target.attr( 'data-wp-editor-id' );
						mode = target.hasClass( 'switch-tmce' ) ? 'tmce' : 'html';
						switchEditors.go( id, mode );
					}
				});

			}, 1000);
			})(jQuery);
	    </script>
	    <?php
	}

	
	function gform_tooltips( $tooltips ) {
	   $tooltips[$this->editor_id] = "<h6>Tooltip</h6>Displays a tooltip when the mouse hovers over the title. You can separate tooltips with the <strong>&amp;lt;hr&amp;gt;</strong> tag in order to display sub-tooltips for complex fields such as Name, Address, Radio Group, and Checkbox Group.";

	   $tooltips['field_mm_tooltip_no_label_mode'] = '<h6>No-Label Mode</h6>Check it to enable No-Label mode, form field label will not be shown as field title, and it will be shown as field placeholder.';

	   $tooltips['field_mm_tooltip_modal_mode'] = '<h6>Modal Mode</h6>Check it to enable Modal mode, Tooltip Content will be shown as a modal when user clicks help icon. <br/><br/>You can also show Read More link like normal Wordpress posts by adding read more tag (<strong>&amp;lt;!--more--&amp;gt;</strong>) with Visual Editor.</div>';

	   $tooltips['mtfgf_enable_form_button_tooltip'] = '<h6>Form Button Tooltip</h6>Check it to enable show a tooltip besides Form Button.';
	   return $tooltips;
	}

	/**
	 * Handle Post Category Field
	 * @return [type] [description]
	 */
	function __mm_tooltip_text_for_post_category($field, $mm_tooltip_text){
		if(empty($mm_tooltip_text)) {
			$mm_tooltip_text = '';
		}
		foreach ($field->choices as $key => $value) {
			$term = get_term_by('id', $value['value'], isset($field->populateTaxonomy) ? $field->populateTaxonomy : 'category');
			$mm_tooltip_text .= '<hr>'.$term->description;
		}
		return $mm_tooltip_text;
	}

	/**
	 * Show Tooltip in the bottom of field container
	 * @param  [type] $field_container [description]
	 * @param  [type] $field           [description]
	 * @param  [type] $form            [description]
	 * @param  [type] $css_class       [description]
	 * @param  [type] $style           [description]
	 * @param  [type] $field_content   [description]
	 * @return [type]                  [description]
	 */
	function gform_field_container( $field_container, $field, $form, $css_class, $style, $field_content ) {
// die();
		if((!is_admin()) || (defined('DOING_AJAX') && DOING_AJAX) ){

// print_r($field);
			if(isset($field->mm_tooltip_no_label_mode) && $field->mm_tooltip_no_label_mode){
				$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", "$1 mm-enable-no-label$2", $field_container);
				if(isset($field->mm_tooltip_no_label_mode_placeholder) && $field->mm_tooltip_no_label_mode_placeholder){
					$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", "$1 mm-enable-no-label-placeholder$2", $field_container);
				}
				if(isset($field->mm_tooltip_no_label_mode_required) && $field->mm_tooltip_no_label_mode_required){
					$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", "$1 mm-enable-no-label-required$2", $field_container);
				}
				if(isset($field->mm_tooltip_no_label_mode_agree) && $field->mm_tooltip_no_label_mode_agree){
					$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", "$1 mm-enable-no-label-agree$2", $field_container);
				}

				
			}

			if(isset($field->mm_tooltip_no_label_mode_show_help_icon) && $field->mm_tooltip_no_label_mode_show_help_icon){
				$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", "$1 mm-enable-no-label-show-help-icon$2", $field_container);
			}
			
			if(isset($field->mm_tooltip_modal_mode) && $field->mm_tooltip_modal_mode){
				$more_text = "Read More";
				if(isset($field->mm_tooltip_modal_more_text) && $field->mm_tooltip_modal_more_text) {
					$more_text = $field->mm_tooltip_modal_more_text;
				}

				$more_text = 'mm-modal-more-text="'.esc_attr($more_text).'" ';

				$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", $more_text."$1 mm-enable-modal$2", $field_container);
			
				if(isset($field->mm_tooltip_mm_enable_tooltip_hint) && $field->mm_tooltip_mm_enable_tooltip_hint){
					$hint_text = "Click to show...";
					if(isset($field->mm_tooltip_modal_tooltip_hint) && $field->mm_tooltip_modal_tooltip_hint) {
						$hint_text = $field->mm_tooltip_modal_tooltip_hint;
					}

					$more_text = 'mm-modal-hint-text="'.esc_attr($hint_text).'" ';

					$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", $more_text."$1 mm-modal-enable-hint$2", $field_container);
				}
			}

			if(isset($field->mm_enable_force_show_tooltip) && $field->mm_enable_force_show_tooltip){
				$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", "$1 mm-force-show-tooltip$2", $field_container);
			}

			if(isset($field->mm_enable_custom_icon) && $field->mm_enable_custom_icon){
				$qmarkf = "fa fa-question-circle";
				if(isset($field->mm_custom_icon) && $field->mm_custom_icon) {
					$qmarkf = $field->mm_custom_icon;
				}

				$qmarkf = 'mm-fa-icon="'.esc_attr($qmarkf).'" ';

				$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", $qmarkf."$1 mm-enable-custom-icon$2", $field_container);
			}

			if(isset($field->mm_enable_named_style) && $field->mm_enable_named_style){
				$qmarkf = "default";
				if(isset($field->mm_named_style) && $field->mm_named_style) {
					$qmarkf = $field->mm_named_style;
				}

				$qmarkf = 'mm-named-style="'.esc_attr($qmarkf).'" ';

				$field_container = preg_replace("/(class=['|\"]gfield[^['|\"]+)(['|\"])/", $qmarkf."$1 mm-enable-named-style$2", $field_container);
			}

			if((empty($field->mm_tooltip_text) || (strpos($field->mm_tooltip_text, "<hr") === false)) && ($field->type == 'post_category' || (in_array($field->type, array('checkbox', 'radio')) && isset($field->populateTaxonomy)))){
				$field->mm_tooltip_text = $this->__mm_tooltip_text_for_post_category($field, $field->mm_tooltip_text);
			}

			//$field_id = $is_admin || empty( $form ) ? "field_$id" : 'field_' . $form['id'] . "_$id";
			global $wp_embed;
			$tooltip = isset($field->mm_tooltip_text) && $field->mm_tooltip_text ? "<div class='mm_tooltip_text' style='display:none'>" .  do_shortcode(stripslashes($wp_embed->run_shortcode($field->mm_tooltip_text))) . '</div>' : '';
			$field_container = str_replace("</li>", $tooltip."</li>", $field_container);

			// echo $field_container; exit;
	    	return $field_container;//"<li id='$field_id' class='{$css_class}' $style>{FIELD_CONTENT}{$tooltip}</li>";
		}
		else {
			return $field_container;
		}
	}

	//hook submit button
	function gform_submit_button($button_input, $form){
		if(rgar( $form, 'mtfgf_enable_form_button_tooltip' ) == 1){
			$html = rgar( $form, 'mtfgf_form_button_tooltip_content' );
			if(!empty($html)) {
				global $wp_embed;
				$css_class = "mtfgf_enable_form_button_tooltip";
				if(rgar( $form, 'mtfgf_enable_form_button_remove_help_icon' ) == 1){
					$css_class .= " mtfgf_enable_form_button_remove_help_icon";
				}

				$button_input = str_replace(" class='", " class='".$css_class." ", $button_input);
				$button_input .= "<div class='mm_tooltip_text' style='display:none'>" .  do_shortcode(stripslashes($wp_embed->run_shortcode($html))) . '</div>';
			}
		}
		
		return $button_input;
	}

	// save your custom form setting
	function gform_pre_form_settings_save($form) {
		$form['mtfgf_enable_form_button_tooltip'] = rgpost( 'mtfgf_enable_form_button_tooltip' );
		$form['mtfgf_enable_form_button_remove_help_icon'] = rgpost( 'mtfgf_enable_form_button_remove_help_icon' );
		$form['mtfgf_form_button_tooltip_content'] = rgpost( 'mtfgf_form_button_tooltip_content' );
    	return $form;
	}

	function gform_form_settings($settings, $form ){
		$mtfgf_enable_form_button_tooltip_checked = '';
		if ( rgar( $form, 'mtfgf_enable_form_button_tooltip' ) ) {
			$mtfgf_enable_form_button_tooltip_checked = 'checked="checked"';
		}
		//rgar( $form, 'yakker_form_mode' )
		$settings[__( 'Form Button', 'gravityforms' )]['mtfgf_enable_form_button_tooltip'] = '
		    <tr>
	            <th><label for="mtfgf_enable_form_button_tooltip">Button Tooltip '.gform_tooltip( 'mtfgf_enable_form_button_tooltip', '', true ).'</th>
	            <td>
	                <input type="checkbox" id="mtfgf_enable_form_button_tooltip" name="mtfgf_enable_form_button_tooltip" value="1" ' . $mtfgf_enable_form_button_tooltip_checked . '/>
	                <label for="mtfgf_enable_form_button_tooltip">' . __( 'Enable Button Tooltip', 'mtfgf' ) . '</label>
	            </td>
	        </tr>';

	    $mtfgf_enable_form_button_remove_help_icon_checked = '';
		if ( rgar( $form, 'mtfgf_enable_form_button_remove_help_icon' ) ) {
			$mtfgf_enable_form_button_remove_help_icon_checked = 'checked="checked"';
		}
		//rgar( $form, 'yakker_form_mode' )
		$settings[__( 'Form Button', 'gravityforms' )]['mtfgf_enable_form_button_remove_help_icon'] = '
		    <tr>
	            <th></th>
	            <td>
	                <input type="checkbox" id="mtfgf_enable_form_button_remove_help_icon" name="mtfgf_enable_form_button_remove_help_icon" value="1" ' . $mtfgf_enable_form_button_remove_help_icon_checked . '/>
	                <label for="mtfgf_enable_form_button_remove_help_icon">' . __( 'Hide the help icon for Button Tooltip.', 'mtfgf' ) . '</label>
	            </td>
	        </tr>';

	    $button_tooltip_content = rgar( $form, 'mtfgf_form_button_tooltip_content' );
	    $settings[__( 'Form Button', 'gravityforms' )]['mtfgf_form_button_tooltip_content'] = '
		    <tr>
	            <th></th>
	            <td>
	                <textarea id="mtfgf_form_button_tooltip_content" name="mtfgf_form_button_tooltip_content" class="fieldwidth-3 fieldheight-2">'.html_entity_decode($button_tooltip_content).'</textarea>
	            </td>
	        </tr>';

        return $settings;
	}


	/*function gform_form_settings_menu($tabs) {
        $tabs[] = array("name" => 'mtfgf', "label" => __("Magic Tooltips", "mcfgf"));
        return $tabs;
    }

    function gform_form_settings_page_mtfgf() {
        GFFormSettings::page_header();
        ?>

        <h2>Just Happened</h2>
        <p>I'm going to let Kev handle this issue where small content and taller tabs results in a some funk.</p>
        <p>I'm going to let Kev handle this issue where small content and taller tabs results in a some funk.</p>
        <p>I'm going to let Kev handle this issue where small content and taller tabs results in a some funk.</p>
        <p>I'm going to let Kev handle this issue where small content and taller tabs results in a some funk.</p>

        <?php
        GFFormSettings::page_footer();
    }*/

	// function gform_form_settings($settings, $form) {
	// 	$mtfgf_enable_no_label_mode_checked = '';
	// 	if ( rgar( $form, 'mtfgf_enable_no_label_mode' ) ) {
	// 		$mtfgf_enable_no_label_mode_checked = 'checked="checked"';
	// 	}
	// 	$settings['Magic Tooltips']['mtfgf_enable_no_label_mode'] = '
 //        <tr>
 //            <th><label for="mtfgf_enable_no_label_mode">No-Label mode '.gform_tooltip( 'mtfgf_enable_no_label_mode', '', true ).'</th>
 //            <td>
 //                <input type="checkbox" id="mtfgf_enable_no_label_mode" name="mtfgf_enable_no_label_mode" value="1" ' . $mtfgf_enable_no_label_mode_checked . '/>
 //                <label for="mtfgf_enable_no_label_mode">' . __( 'Enable No-Label mode', 'mtfgf' ) . '</label>
 //            </td>
 //        </tr>';


 //        $mtfgf_no_label_show_q_mark = '';
	// 	if ( rgar( $form, 'mtfgf_no_label_show_q_mark' ) ) {
	// 		$mtfgf_no_label_show_q_mark = 'checked="checked"';
	// 	}
	// 	$settings['Magic Tooltips']['mtfgf_no_label_show_q_mark'] = '
 //        <tr>
 //            <th></th>
 //            <td>
 //                <input type="checkbox" id="mtfgf_no_label_show_q_mark" name="mtfgf_no_label_show_q_mark" value="1" ' . $mtfgf_no_label_show_q_mark . '/>
 //                <label for="mtfgf_no_label_show_q_mark">' . __( 'Show Question Mark in No-Label mode', 'mtfgf' ) . '</label>
 //            </td>
 //        </tr>';

 //        $mtfgf_no_label_show_required = '';
	// 	if ( rgar( $form, 'mtfgf_no_label_show_required' ) ) {
	// 		$mtfgf_no_label_show_required = 'checked="checked"';
	// 	}
	// 	$settings['Magic Tooltips']['mtfgf_no_label_show_required'] = '
 //        <tr>
 //            <th></th>
 //            <td>
 //                <input type="checkbox" id="mtfgf_no_label_show_required" name="mtfgf_no_label_show_required" value="1" ' . $mtfgf_no_label_show_required . '/>
 //                <label for="mtfgf_no_label_show_required">' . __( 'Show Required in No-Label mode', 'mtfgf' ) . '</label>
 //            </td>
 //        </tr>';

 //    	return $settings;
	// }

	// // save your custom form setting
	// function gform_pre_form_settings_save($form) {
	// 	$form['mtfgf_enable_no_label_mode'] = rgpost( 'mtfgf_enable_no_label_mode' );
	// 	$form['mtfgf_no_label_show_q_mark'] = rgpost( 'mtfgf_no_label_show_q_mark' );
	// 	$form['mtfgf_no_label_show_required'] = rgpost( 'mtfgf_no_label_show_required' );
 //    	return $form;
	// }

	// function gform_form_settings( $settings, $form ) {
	// 	$settings['Form Basics']['mm_tooltip_text'] = '
	//         <tr>
	//             <th><label for="mm_tooltip_text">Tooltip Text</label></th>
	//             <td><input value="' . rgar($form, 'mm_tooltip_text') . '" name="mm_tooltip_text"></td>
	//         </tr>';
	
	//     return $settings;
	// }
	
	// function gform_pre_form_settings_save($form) {
	//     $form['mm_tooltip_text'] = rgpost( 'mm_tooltip_text' );
	//     return $form;
	// }
	
}

global $magic_tooltips_for_gravity_forms;
$magic_tooltips_for_gravity_forms = new MagicTooltipsForGravityForms();

/**/
