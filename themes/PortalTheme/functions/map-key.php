<?php 
function my_acf_google_map_api( $api ){
	
	$api['key'] = 'AIzaSyBLe0qx6ZQoX02ks3VXwyW01u5njQbNQJw';
	return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

?>