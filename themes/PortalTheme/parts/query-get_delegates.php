<?php

/* Get client organisation
$curr_user = 'user_'. get_current_user_id() ;
$organisation = get_field('organisation', $curr_user);
$client_org = $organisation[0] ; */

//Get delegates
$args_user = array(
	'blog_id'      => $GLOBALS['blog_id'],
	'role'         => 'delegate'
 );  
$users = get_users( $args_user  ); 

//Get matching delegates
$delegates = array ();

foreach ( $users as $user ) {

    $user_delegate =  'user_' . $user->ID;
    $client = get_field('client', $user_delegate);
    $client_id = $client['ID'];

    $current_user_id = get_current_user_id() ;
    if ($client_id == $current_user_id) {
        array_push($delegates, $user);
    }

    /* Organisation
    $organisation = get_field('organisation', $user_delegate);
    $delegate_org = $organisation[0];
    if ($delegate_org == $client_org ) {
        array_push($delegates, $user);
    }
    */

} 
?>

