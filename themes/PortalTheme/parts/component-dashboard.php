<?php 
    $copy = $values['copy'];

    $user = wp_get_current_user();
    $user_role = (array) $user->roles; 
    $role = $user_role[0];

    if ($role == "client") {
        require('part-dashboard_client.php');
    }
    else if ($role == "delegate") {
        require('part-dashboard_delegate.php'); 
    }
?>

