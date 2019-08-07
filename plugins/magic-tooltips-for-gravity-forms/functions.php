<?php 
function mtfgf_get_default_icons(){
	return 'question-circle
exclamation-circle
info-circle
qrcode
eye
user
map-signs
image
search
camera
video-camera
code
star';
}

function mtfgf_get_icons_select_options_html($icons_str){
	$icons = explode("\n", $icons_str);
	$html = '<option>fa fa-';

	$html .= join("</option><option>fa fa-", $icons);

	$html .= "</option>";

	return $html;
}

 ?>