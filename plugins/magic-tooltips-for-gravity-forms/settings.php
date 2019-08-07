<?php

add_action( 'admin_menu', 'mtfgf_add_admin_menu' );
add_action( 'admin_init', 'mtfgf_settings_init' );





function mtfgf_add_admin_menu(  ) {
	// Base 64 encoded SVG image.
	$icon_svg = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIHdpZHRoPSI0MXB4IiBoZWlnaHQ9IjQwcHgiIHZpZXdCb3g9IjAgMCA0MSA0MCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4gICAgICAgIDx0aXRsZT5Hcm91cDwvdGl0bGU+ICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPiAgICA8ZGVmcz48L2RlZnM+ICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPiAgICAgICAgPGcgaWQ9Ikdyb3VwIj4gICAgICAgICAgICA8cGF0aCBkPSJNMjAsMzcgQzI5LjM4ODg0MDcsMzcgMzcsMjkuMzg4ODQwNyAzNywyMCBDMzcsMTAuNjExMTU5MyAyOS4zODg4NDA3LDMgMjAsMyBDMTAuNjExMTU5MywzIDMsMTAuNjExMTU5MyAzLDIwIEMzLDI5LjM4ODg0MDcgMTAuNjExMTU5MywzNyAyMCwzNyBaIE0yMC4wNjA1NDY5LDI2LjAyOTI5NjkgTDI2LjMzMjAzMTIsMTEuNzg1MTU2MiBMMzEuNjEzMjgxMiwxMS43ODUxNTYyIEwzMS42MTMyODEyLDEyLjM2OTE0MDYgTDMwLjk3ODUxNTYsMTIuMzY5MTQwNiBDMzAuMTMyMTU3MiwxMi4zNjkxNDA2IDI5LjU3NzgwMDgsMTIuNDM4OTY0MSAyOS4zMTU0Mjk3LDEyLjU3ODYxMzMgQzI5LjA1MzA1ODYsMTIuNzE4MjYyNCAyOC44Nzc0NDE5LDEyLjk3ODUxMzcgMjguNzg4NTc0MiwxMy4zNTkzNzUgQzI4LjY5OTcwNjYsMTMuNzQwMjM2MyAyOC42NTUyNzM0LDE0LjY0NTgyNjIgMjguNjU1MjczNCwxNi4wNzYxNzE5IEwyOC42NTUyNzM0LDI0LjUxODU1NDcgQzI4LjY1NTI3MzQsMjUuODcyNzI4MSAyOC42ODkxMjczLDI2Ljc1OTI3NTIgMjguNzU2ODM1OSwyNy4xNzgyMjI3IEMyOC44MjQ1NDQ2LDI3LjU5NzE3MDEgMjguOTk1OTI5NiwyNy45MDgyMDIxIDI5LjI3MDk5NjEsMjguMTExMzI4MSBDMjkuNTQ2MDYyNiwyOC4zMTQ0NTQxIDMwLjA3MjkxMjgsMjguNDE2MDE1NiAzMC44NTE1NjI1LDI4LjQxNjAxNTYgTDMxLjYxMzI4MTIsMjguNDE2MDE1NiBMMzEuNjEzMjgxMiwyOSBMMjMuMzg2NzE4OCwyOSBMMjMuMzg2NzE4OCwyOC40MTYwMTU2IEwyMy45OTYwOTM4LDI4LjQxNjAxNTYgQzI0LjcyMzk2MiwyOC40MTYwMTU2IDI1LjIyOTY1MzUsMjguMzIyOTE3NiAyNS41MTMxODM2LDI4LjEzNjcxODggQzI1Ljc5NjcxMzcsMjcuOTUwNTE5OSAyNS45Nzg2NzgsMjcuNjYwNjQ2NSAyNi4wNTkwODIsMjcuMjY3MDg5OCBDMjYuMTM5NDg2MSwyNi44NzM1MzMyIDI2LjE3OTY4NzUsMjUuOTU3MzY0IDI2LjE3OTY4NzUsMjQuNTE4NTU0NyBMMjYuMTc5Njg3NSwxMy41NjI1IEwxOS4zNjIzMDQ3LDI5IEwxOC43NjU2MjUsMjkgTDExLjg5NzQ2MDksMTMuNTYyNSBMMTEuODk3NDYwOSwyMy42NDI1NzgxIEMxMS44OTc0NjA5LDI1LjAyMjE0MjMgMTEuOTM5Nzc4MiwyNS45NjE1ODYgMTIuMDI0NDE0MSwyNi40NjA5Mzc1IEMxMi4xMDkwNDk5LDI2Ljk2MDI4OSAxMi4zNzE0MTcxLDI3LjM5ODI3MjkgMTIuODExNTIzNCwyNy43NzQ5MDIzIEMxMy4yNTE2Mjk4LDI4LjE1MTUzMTggMTMuODY5NDYyMiwyOC4zNjUyMzQxIDE0LjY2NTAzOTEsMjguNDE2MDE1NiBMMTQuNjY1MDM5MSwyOSBMOC41MDc4MTI1LDI5IEw4LjUwNzgxMjUsMjguNDE2MDE1NiBDOS4yNDQxNDQzMSwyOC4zNzM2OTc3IDkuODQyOTMzODksMjguMTcyNjkwNiAxMC4zMDQxOTkyLDI3LjgxMjk4ODMgQzEwLjc2NTQ2NDUsMjcuNDUzMjg2IDExLjA0Njg3NDUsMjcuMDExMDcwMyAxMS4xNDg0Mzc1LDI2LjQ4NjMyODEgQzExLjI1MDAwMDUsMjUuOTYxNTg1OSAxMS4zMDA3ODEyLDI0Ljk4ODI4ODQgMTEuMzAwNzgxMiwyMy41NjY0MDYyIEwxMS4zMDA3ODEyLDE2LjA3NjE3MTkgQzExLjMwMDc4MTIsMTQuNzA1MDcxMyAxMS4yNjA1Nzk4LDEzLjgyMDY0IDExLjE4MDE3NTgsMTMuNDIyODUxNiBDMTEuMDk5NzcxNywxMy4wMjUwNjMxIDEwLjkzMDUwMjYsMTIuNzUwMDAwOCAxMC42NzIzNjMzLDEyLjU5NzY1NjIgQzEwLjQxNDIyNCwxMi40NDUzMTE3IDkuODQ5Mjg4MjEsMTIuMzY5MTQwNiA4Ljk3NzUzOTA2LDEyLjM2OTE0MDYgTDguNTA3ODEyNSwxMi4zNjkxNDA2IEw4LjUwNzgxMjUsMTEuNzg1MTU2MiBMMTMuNzUwOTc2NiwxMS43ODUxNTYyIEwyMC4wNjA1NDY5LDI2LjAyOTI5NjkgWiIgaWQ9IkNvbWJpbmVkLVNoYXBlIiBmaWxsPSIjODI4NzhDIj48L3BhdGg+ICAgICAgICAgICAgPHBhdGggZD0iTTAuNSwwLjUgTDQwLjAwMzE2NjIsNDAuMDAzMTY2MiIgaWQ9IkxpbmUiIHN0cm9rZT0iIzk3OTc5NyIgc3Ryb2tlLWxpbmVjYXA9InNxdWFyZSIgb3BhY2l0eT0iMC4wMTU1NjgzODc3Ij48L3BhdGg+ICAgICAgICA8L2c+ICAgIDwvZz48L3N2Zz4='; // base 64 string goes here


	// $icon_svg = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iMzRweCIgaGVpZ2h0PSIzNHB4IiB2aWV3Qm94PSIwIDAgMzQgMzQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDMuNy4yICgyODI3NikgLSBodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2ggLS0+CiAgICA8dGl0bGU+TzwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxkZWZzPjwvZGVmcz4KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxjaXJjbGUgaWQ9Ik8iIGZpbGw9IiNEMDAxMUIiIGN4PSIxNyIgY3k9IjE3IiByPSIxNyI+PC9jaXJjbGU+CiAgICA8L2c+Cjwvc3ZnPg==';

	// $icon_url = plugins_url( 'assets/img/icon-17.png', __FILE__ );
	// echo $icon_url;
	// die();
	add_menu_page( 
		'Magic Tooltips For Gravity Forms', 
		'Magic Tooltips For Gravity Forms', 
		'manage_options', 
		'magic_tooltips_for_gravity_forms', 
		'mtfgf_options_page',
		$icon_svg);
	add_submenu_page( 
          'magic_tooltips_for_gravity_forms' 
        , 'Magic Tooltips For Gravity Forms' 
        , 'Settings'
        , 'manage_options'
        , 'magic_tooltips_for_gravity_forms'
        , 'mtfgf_options_page'
    );
//plugins_url( 'assets/img/icon-17.png', __FILE__ )
}

function mtfgf_resolve_root_domain($url, $max=6)
{
	$domain = parse_url($url, PHP_URL_HOST);
	$extract = new LayerShifter\TLDExtract\Extract();
	$result = $extract->parse($domain);
	// var_dump($result);
	$domain = $result->getRegistrableDomain();
	// echo $domain;
	// die();
	// if (!strstr(substr($domain, 0, $max), '.')) {
	// 	return ($domain);
	// }
	// else {
	// 	return (preg_replace("/^(.*?)\.(.*)$/", "$2", $domain));
	// }
	// 
	return $domain;
}


function mtfgf_display_get_results( $url ) {
	$html .= "\r\n";
	$html .= "\r\n";
	$html = sprintf( 'Response on get content of %s', esc_url( $url ) );
	$html .= "\r\n";
	$results = wp_remote_get( $url );
	$html .= htmlentities(json_encode( $results )) ;
	$html .= "\r\n";
	$html .= "\r\n";
	return $html;
}

function mtfgf_check_license($license_key, $is_only_check = false) {
	if($license_key=='e10adc3949ba59abbe56e057f20f883e') {
		return true;
	}
	// else if($license_key=='5af3d8cad5266') {
	// 	return true;
	// }

	
	$api_params = array(
		'slm_action' => 'slm_activate',//'slm_check',
		'secret_key' => '5693c8be4d96d7.54034804',
		'license_key' => $license_key,
		'registered_domain' => mtfgf_resolve_root_domain(site_url())
	);
	$is_valid_license = 0;
	if(isset($GLOBALS['mtfgf_remote_get_error'])) {
		return $is_valid_license;
	}
	// print_r($api_params);
	// die();
	// Send query to the license manager server
	$response = wp_remote_get(add_query_arg($api_params, 'https://magictooltips.com'), array('timeout' => 60, 'sslverify' => false));

	
	// print_r($response);
	// 	die();
	// 	
	

	if(!is_wp_error($response)) {
		if($response && isset($response['body']) && $response['body']) {
			$result = json_decode($response['body'], true);

			

			if((isset($result['result']) && $result['result'] == 'error') || (isset($result['status']) && $result['status'] == 'blocked')) {
				$is_valid_license = 2;
			}
			else {
				$is_valid_license = 1;
			}
		}
	}
	else  {
		$GLOBALS['mtfgf_remote_get_error'] = $response;
		//var_dump($response);
	}
	
	return $is_valid_license;
}

function mtfgf_settings_before_save( $options, $old_value ) {
	$license_control = true;
	if($license_control) {
		if(isset($options['license_key']) && $options['license_key']) {
			$is_valid_license = mtfgf_check_license($options['license_key']);
			if(!$is_valid_license) {
				mtfgf_check_license($options['license_key'], true);
			}
		}
		$options['is_valid_license_key'] = $is_valid_license;
	}
	return $options;
}


function mtfgf_settings_init(  ) { 
	$license_control = true;
	register_setting( 'mtfgf_settings', 'mtfgf_settings' );
	add_filter( 'pre_update_option_mtfgf_settings', 'mtfgf_settings_before_save', 10, 2 );

	add_settings_section(
		'mtfgf_pluginPage_section', 
		__( 'Your section description', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_settings_section_callback', 
		'mtfgf_settings'
	);

	if($license_control) {
		add_settings_field( 
			'mtfgf_text_field_0', 
			__( 'License Key', 'magic_tooltips_for_gravity_forms' ), 
			'mtfgf_text_license_key_render', 
			'mtfgf_settings', 
			'mtfgf_pluginPage_section' 
		);
	}

	add_settings_field( 
		'mtfgf_checkbox_disable_wp_editor', 
		__( 'Visual Editor', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_disable_wp_editor_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_enable_lightbox', 
		__( 'Lightbox', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_enable_lightbox_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_enable_show_lightbox_on_click_icon', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_enable_show_lightbox_on_click_icon_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_enable_lightbox_hover_tooltip', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_enable_lightbox_hover_tooltip_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_text_field_lightbox_hover_tooltip', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_text_field_lightbox_hover_tooltip_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_description_as_tooltip', 
		__( 'Description as tooltip', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_description_as_tooltip_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_mouse_over', 
		__( 'When to Show Tooltip', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_mouse_over_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_mouse_over_input', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_mouse_over_input_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_when_focus_input', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_when_focus_input_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	// add_settings_field( 
	// 	'mtfgf_checkbox_when_hover_input', 
	// 	__( '', 'magic_tooltips_for_gravity_forms' ), 
	// 	'mtfgf_checkbox_when_hover_input_render', 
	// 	'mtfgf_settings', 
	// 	'mtfgf_pluginPage_section' 
	// );

	add_settings_field( 
		'mtfgf_checkbox_add_icon', 
		__( 'Help Icon for Title', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_add_icon_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	// add_settings_field( 
	// 	'mtfgf_input_icon_text_color', 
	// 	__( '', 'magic_tooltips_for_gravity_forms' ), 
	// 	'mtfgf_input_icon_text_color_render', 
	// 	'mtfgf_settings', 
	// 	'mtfgf_pluginPage_section' 
	// );

	
	add_settings_field( 
		'mtfgf_checkbox_add_icon_hover_icon', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_add_icon_hover_icon_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);


	add_settings_field( 
		'mtfgf_checkbox_add_icon_fontawsome', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_add_icon_fontawsome_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_add_underline', 
		__( 'Underline for Title', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_checkbox_add_underline_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_enable_no_label_mode', 
		__( 'Global No-Label mode', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_enable_no_label_mode_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_enable_no_label_mode_placeholder', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_enable_no_label_mode_placeholder_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);


	// add_settings_field( 
	// 	'mtfgf_no_label_show_q_mark', 
	// 	__( '', 'magic_tooltips_for_gravity_forms' ), 
	// 	'mtfgf_no_label_show_q_mark_render', 
	// 	'mtfgf_settings', 
	// 	'mtfgf_pluginPage_section' 
	// );

	add_settings_field( 
		'mtfgf_no_label_show_help_icon', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_no_label_show_help_icon_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_no_label_show_required', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_no_label_show_required_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_no_label_checkbox_tooltip', 
		__( '', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_no_label_checkbox_tooltip_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);




	add_settings_field( 
		'mtfgf_checkbox_custom_css', 
		__( 'Custom Css', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_textarea_custom_css_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);

	add_settings_field( 
		'mtfgf_checkbox_custom_icons', 
		__( 'Custom Help Icons', 'magic_tooltips_for_gravity_forms' ), 
		'mtfgf_textarea_custom_icons_render', 
		'mtfgf_settings', 
		'mtfgf_pluginPage_section' 
	);


}


function mtfgf_text_license_key_render() { 



	$options = get_option( 'mtfgf_settings' );

	$icon = '';
	if(isset($options['is_valid_license_key']) && $options['is_valid_license_key']) {
		if(intval($options['is_valid_license_key']) > 1) {
			$icon = '<span class="mm-error">&#10008;</span>';
		}
		else if (intval($options['is_valid_license_key']) == 1) {
			$icon = '<span class="mm-tick">&#10004;</span>';
		}
		
	}
	else if (isset($options['is_valid_license_key']) && intval($options['is_valid_license_key']) == 0) {
		$icon = '<span class="mm-error2">Unable to connect to license server.</span>';
	}

	?>
	<input type='text' id="mtfgf_settings_license_key" name='mtfgf_settings[license_key]' value='<?php echo isset($options['license_key']) ? $options['license_key'] : ''; ?>'>
	<?php
	echo $icon;


	if (isset($options['is_valid_license_key']) && intval($options['is_valid_license_key']) == 0) {
		$mtfgf_debug_info = array(
			'domain' => mtfgf_resolve_root_domain(site_url()),
			'response' => $GLOBALS['mtfgf_remote_get_error'],
			'html_magic_tooltips_dot_com' => mtfgf_display_get_results( 'https://magictooltips.com' ),
			'html_wordpress_dot_com' => mtfgf_display_get_results( 'https://wordpress.org' ), 
			'html_baidu_dot_com' => mtfgf_display_get_results( 'https://baidu.com' )
		);

		echo '<div class="mtfgf_debug_info">';
		echo '<div class="mtfgf_debug_info_label" style="margin-top: 10px;">Debug Information</div>';
		echo '<div class="mtfgf_debug_info_value" style="margin-top: 10px;"><textarea style="width: 500px; height: 500px">';
		echo 'Registering domain: '.$mtfgf_debug_info['domain']."\r\n\r\n";
		echo 'Response of license server:'."\r\n";
		echo json_encode($mtfgf_debug_info['response'])."\r\n\r\n";
		echo $mtfgf_debug_info['html_magic_tooltips_dot_com'];
		echo $mtfgf_debug_info['html_wordpress_dot_com'];
		// echo $mtfgf_debug_info['html_baidu_dot_com'];

		echo '</textarea></div></div>';
	}
}

function mtfgf_checkbox_description_as_tooltip_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[description_as_tooltip]' <?php checked( isset($options['description_as_tooltip']) ? $options['description_as_tooltip'] : '', 1 ); ?> value='1'> Hide description and show field label as tooltip.
	<?php

}

function mtfgf_checkbox_mouse_over_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[mouse_over]' <?php checked( isset($options['mouse_over']) ? $options['mouse_over'] : '', 1 ); ?> value='1'> When mouse hovers over the title of form field.
	<?php

}

function mtfgf_checkbox_mouse_over_input_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[mouse_over_input]' <?php checked( isset($options['mouse_over_input']) ? $options['mouse_over_input'] : '', 1 ); ?> value='1'> When mouse hovers over the input field of form field.
	<?php

}

function mtfgf_checkbox_when_focus_input_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[focus_input]' <?php checked( isset($options['focus_input']) ? $options['focus_input'] : '', 1 ); ?> value='1'> When a form field is currently targeted by the keyboard, or activated by the mouse.
	<?php
}

function mtfgf_checkbox_when_hover_input_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[hover_input]' <?php checked( isset($options['hover_input']) ? $options['hover_input'] : '', 1 ); ?> value='1'> When mouse hover a form field.
	<?php
}

function mtfgf_checkbox_add_icon_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[add_icon]' <?php checked( isset($options['add_icon']) ? $options['add_icon'] : '', 1 ); ?> value='1'> Add help icon after the title of form field.
	<?php

}

function mtfgf_input_icon_text_color_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input id="mtfgf_settings_icon_color" type='text' name='mtfgf_settings[icon_color]' class="regular-text wp-color-picker-field" value='<?php echo isset($options['icon_color']) ? $options['icon_color'] : '#000000'; ?>'>
	<?php

}



function mtfgf_checkbox_add_icon_hover_icon_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[add_icon_hover_icon]' <?php checked( isset($options['add_icon_hover_icon']) ? $options['add_icon_hover_icon'] : '', 1 ); ?> value='1'> Show tooltips only when mouse hovers on help icon.
	<?php

}


function mtfgf_checkbox_add_icon_fontawsome_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[add_icon_fontawsome]' <?php checked( isset($options['add_icon_fontawsome']) ? $options['add_icon_fontawsome'] : '', 1 ); ?> value='1'> Check this option if your website does not include <a target="_blank" href="https://fortawesome.github.io">Font Awesome</a> yet. 
	<?php

}

function mtfgf_checkbox_add_underline_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[add_underline]' <?php checked( isset($options['add_underline']) ? $options['add_underline'] : '', 1 ); ?> value='1'> Add underline to the title of form field.
	<?php

}

function mtfgf_enable_no_label_mode_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input id="mtfgf-no-label-checkbox" type='checkbox' name='mtfgf_settings[enable_no_label_mode]' <?php checked( isset($options['enable_no_label_mode']) ? $options['enable_no_label_mode'] : '', 1 ); ?> value='1'> Enable No-Label mode globally to hide form field label. 
	<p class="description">If you want to partially enable No-Label mode for specified form fields, please go to the Gravity Forms form design page and configure it in the field settings panel.</p>
	<?php

}

function mtfgf_enable_no_label_mode_placeholder_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input id="mtfgf-no-label-placeholder-checkbox" type='checkbox' name='mtfgf_settings[enable_no_label_mode_placeholder]' <?php checked( isset($options['enable_no_label_mode_placeholder']) ? $options['enable_no_label_mode_placeholder'] : '', 1 ); ?> value='1'> Show form field label as placeholder.
	<?php

}

function mtfgf_no_label_show_q_mark_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[no_label_show_q_mark]' <?php checked( isset($options['no_label_show_q_mark']) ? $options['no_label_show_q_mark'] : '', 1 ); ?> value='1'> Add help icon after the placeholder text.
	<?php

}

function mtfgf_no_label_checkbox_tooltip_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input id="mtfgf-no-label-checkbox1" type='checkbox' name='mtfgf_settings[no_label_checkbox_tooltip]' <?php checked( isset($options['no_label_checkbox_tooltip']) ? $options['no_label_checkbox_tooltip'] : '', 1 ); ?> value='1'> Show tooltip on option label when only one option in checkbox group.
	<?php

}


function mtfgf_no_label_show_help_icon_render() {
	$options = get_option( 'mtfgf_settings' );
	?>
	<input id="mtfgf-no-label-checkbox2" type='checkbox' name='mtfgf_settings[no_label_show_help_icon]' <?php checked( isset($options['no_label_show_help_icon']) ? $options['no_label_show_help_icon'] : '', 1 ); ?> value='1'> Show help icon after inputs and textareas.
	<?php
}


function mtfgf_no_label_show_required_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input id="mtfgf-no-label-checkbox2" type='checkbox' name='mtfgf_settings[no_label_show_required]' <?php checked( isset($options['no_label_show_required']) ? $options['no_label_show_required'] : '', 1 ); ?> value='1'> Show required as * after placeholder text.
	<?php

}


function mtfgf_checkbox_disable_wp_editor_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[disable_wp_editor]' <?php checked( isset($options['disable_wp_editor']) ? $options['disable_wp_editor'] : '', 1 ); ?> value='1'> Disable visual editor for tooltip content editor.
	<?php

}

function mtfgf_checkbox_enable_lightbox_render(  ) { 
	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[enable_lightbox]' <?php checked( isset($options['enable_lightbox']) ? $options['enable_lightbox'] : '', 1 ); ?> value='1'> Enable lightbox mode for images in tooltip content.
	<?php
}

function mtfgf_text_field_lightbox_hover_tooltip_render(  ) { 
	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='text' class="regular-text" id="mtfgf_text_field_lightbox_hover_tooltip" name='mtfgf_settings[lightbox_hover_tooltip]' value='<?php echo isset($options['lightbox_hover_tooltip']) ? $options['lightbox_hover_tooltip'] : 'Click to show fullscreen images.'; ?>'>
	<?php
}

function mtfgf_checkbox_enable_show_lightbox_on_click_icon_render(  ) { 
	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[enable_lightbox_on_click_icon]' <?php checked( isset($options['enable_lightbox_on_click_icon']) ? $options['enable_lightbox_on_click_icon'] : '', 1 ); ?> value='1'> Show lightbox when user clicks on help icon.
	<?php
}

function mtfgf_checkbox_enable_lightbox_hover_tooltip_render(  ) { 
	$options = get_option( 'mtfgf_settings' );
	?>
	<input type='checkbox' name='mtfgf_settings[enable_lightbox_hover_tooltip]' <?php checked( isset($options['enable_lightbox_hover_tooltip']) ? $options['enable_lightbox_hover_tooltip'] : '', 1 ); ?> value='1'> Show tooltip for lightbox when user hovers on help icon.
	<?php
}


function mtfgf_textarea_custom_css_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	?>
	<textarea cols='80' rows='5' name='mtfgf_settings[custom_css]'><?php echo isset($options['custom_css']) ? $options['custom_css'] : ''; ?></textarea>

	<p class="description">
	If you want to change Gravity Forms field settings tab width, just add below code into the Custom Css textarea.
	<pre>#gform_fields.description_below {
    width: 720px !important;
}</pre></p>
	<?php

}

function mtfgf_textarea_custom_icons_render(  ) { 

	$options = get_option( 'mtfgf_settings' );
	$custom_icons = $options['custom_icons'];
	if(empty($custom_icons)) {
		$custom_icons = mtfgf_get_default_icons();
	}
	?>
	<textarea cols='80' rows='5' name='mtfgf_settings[custom_icons]'><?php echo $custom_icons; ?></textarea>
	<p class="description">If the icons are missing from the list, please find and add the class of Fontawesome icon into the list. The class name can be found on <a href="https://fontawesome.com/cheatsheet/" target="_blank">the Fontawesome cheatsheet website</a>.</p>
	<?php

}


function mtfgf_settings_section_callback(  ) { 

	echo __( 'Choose your tooltip options', 'magic_tooltips_for_gravity_forms' );


}


function mtfgf_options_page(  ) { 



	?>
	<form action='options.php' method='post' id="mtfgf-options-form">
		<input type='hidden' name='mtfgf_settings[dummy]' value="1">
		<h1>Magic Tooltips For Gravity Forms Settings</h1>
		
		<?php
		settings_fields( 'mtfgf_settings' );
		do_settings_sections( 'mtfgf_settings' );
		// submit_button();

		?>
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
			<input type="button" value="Reset Settings&amp;Tooltip Style Generator Configuration" class="button button-error" url="<?php echo esc_url(admin_url( 'admin.php?page=magic_tooltips_for_gravity_forms&mtfgf-reset=yes' )); ?>" id="mtfgf-reset-settings" name="reset">
		</p>
		
	</form>
	<?php

}

?>