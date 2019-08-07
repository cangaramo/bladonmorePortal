<?php
/*
 * Plugin Name: Magic Tooltips For Gravity Forms
 * Version: 1.1.1
 * Plugin URI: http://magictooltips.com
 * Description: Easily add tooltips to your Gravity Form fields
 * Author: Magic Tooltips
 * Author URI: http://magictooltips.com
 * Requires at least: 3.9
 * Tested up to: 4.7.2
 *
 * @package WordPress
 * @author Flannian
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define('MTFGF_VER', '1.1.1');
// function register_jquery() {
// 	//if(!is_admin() && $GLOBALS['pagenow']!='wp-login.php') {
// 		wp_deregister_script('jquery');
//         wp_register_script('jquery',
// 'http://cdn.bootcss.com/jquery/2.2.1/jquery.min.js', false, '2.0.s');
//         wp_enqueue_script('jquery');

// 		// wp_dequeue_script( 'jquery' );
// 		// wp_deregister_script('jquery');
// 		// wp_register_script('jquery', 'http://cdn.bootcss.com/jquery/2.2.1/jquery.min.js', false, '2.2.1');
// 		// wp_enqueue_script('jquery');
// 	//}
// }
// add_action('init', 'register_jquery');

function mtfgf_maybe_add_global_license_settings($options) {
	if(defined('MAGIC_TOOLTIPS_FOR_GRAVITY_FORMS_LICENSE_KEY')) {
		$options['license_key'] = MAGIC_TOOLTIPS_FOR_GRAVITY_FORMS_LICENSE_KEY;
		$is_valid_license = mtfgf_check_license($options['license_key']);
		if(!$is_valid_license) {
			mtfgf_check_license($options['license_key'], true);
		}
		$options['is_valid_license_key'] = $is_valid_license;
	}
	$options['mtfgf_maybe_add_global_license_settings'] = 1;
	return $options;
}

function maybe_magic_tooltips_for_gravity_forms_install($reset = false){
	
	if(isset($_GET['mtfgf-reset']) && $_GET['mtfgf-reset']=='yes') {
		$reset = true;
	}

	$installed = get_option('mtfgf_tooltip_installed', false);
	// if($installed) {
	// 	return;
	// }
	$options = get_option('mtfgf_tooltip_generator',false);
	if($reset || (!$options)) {
		$defaultOptions = '{"css_code":".mm-tooltip-container { color: #FFFFFF; border-radius: 5px; font-size: 14px; background-color: #333333; -webkit-border-radius: 5px; -moz-border-radius: 5px; margin-left: 0px; margin-top: 0px; border-color: #333333; border-width: 1; line-height: 150%;}.mm-tooltip-content { line-height: 150%; padding: 2.4000000000000004px 6px 2.4000000000000004px 6px;}","css_options":"{\"fontColor\":\"#FFFFFF\",\"fontSize\":\"14\",\"backgroundColor\":\"#333333\",\"borderRadius\":5,\"offsetLeft\":\"0\",\"padding\":0.2,\"offsetTop\":\"0\",\"borderColor\":\"#333333\",\"borderWidth\":1,\"lineHeight\":\"150%\"}","js_code":"{\"position\":{\"my\":\"left center\",\"at\":\"right center\",\"adjust\":{\"method\":\"none\"}},\"style\":{\"classes\":\"mm-tooltip-container\"},\"content\":{\"text\":{\"0\":{},\"length\":1,\"prevObject\":{\"0\":{\"jQuery172021905201394110918\":4},\"context\":{\"jQuery172021905201394110918\":4},\"length\":1},\"context\":{\"jQuery172021905201394110918\":4},\"selector\":\".next(div)\"}},\"show\":true}"}';

		$s = json_decode($defaultOptions,true);
		update_option('mtfgf_tooltip_generator',$s);
	}

	$settings = get_option('mtfgf_settings',false);
	if($reset || (!$settings)) {
		$defaultSettings = '{"dummy":"1","mouse_over":"1","add_icon":"1","add_icon_fontawsome":"1","add_underline":"1"}';
		$ss = json_decode($defaultSettings,true);

		//maybe read license key from config file.
		if(defined('MAGIC_TOOLTIPS_FOR_GRAVITY_FORMS_LICENSE_KEY')) {
			$ss = mtfgf_maybe_add_global_license_settings($ss);
		}
		else {
			$ss['dev_license_config'] = 'no';
		}
		
		update_option('mtfgf_settings',$ss);
	}
	else if(defined('MAGIC_TOOLTIPS_FOR_GRAVITY_FORMS_LICENSE_KEY')) {
		if($settings && (!$settings['is_valid_license_key'])) {
			$settings = mtfgf_maybe_add_global_license_settings($settings);
			update_option('mtfgf_settings', $settings);
		}
	}

	update_option('mtfgf_tooltip_installed', 'yes');

	if(isset($_GET['mtfgf-reset']) && $_GET['mtfgf-reset']=='yes') {
		wp_redirect(remove_query_arg( 'mtfgf-reset' ) );
	}
}


//magic_tooltips_for_gravity_forms_install();
$baseDir = dirname(__FILE__);
require dirname(__FILE__) . '/lib/vendor/autoload.php';
require_once ($baseDir.'/functions.php');
require_once ($baseDir.'/settings.php');
require_once ($baseDir.'/cpt-styles.php');
require_once ($baseDir.'/css-generator.php');
require_once ($baseDir.'/magic-tooltips-for-gravity-forms.php');

register_activation_hook( __FILE__, 'maybe_magic_tooltips_for_gravity_forms_install' );

// add_action( 'wpmu_upgrade_site', 'magic_tooltips_for_gravity_forms_install' );

add_action('admin_init', 'maybe_magic_tooltips_for_gravity_forms_install');

$mtfgf_settings = get_option('mtfgf_settings', false);
if($mtfgf_settings && isset($mtfgf_settings['is_valid_license_key']) && $mtfgf_settings['is_valid_license_key']) {
	require $baseDir.'/plugin-update-checker/plugin-update-checker.php';
	$mtfgf_myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	    'http://magictooltips.com/mmp-update-checker?plugin=magictooltips&license_key='.$mtfgf_settings['license_key'],
	    __FILE__,
	    'magictooltips'
	);	
}

