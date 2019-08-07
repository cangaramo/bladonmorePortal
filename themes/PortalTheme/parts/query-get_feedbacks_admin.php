<?php
    $user_id = get_current_user_id();

    /*  FEEDBACKS */
    $feedbacks_user = array();
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'feedback'
    );

    //Get only the agendas need to be approved
    if ( $approval ) {
        $args['meta_key'] = "feedback_status";
        $args['meta_value'] = "Pending";  
    }
    $feedbacks = get_posts( $args );

    if (!empty($feedbacks)):
        foreach ($feedbacks as $feedback):
            $feedback_id = $feedback->ID;
            $title_feedback = get_the_title($feedback_id);
            $session = get_field('session', $feedback_id );
            $session_id = $session->ID;
            $clients = get_field('organisation_client', $session_id );
            $client_id = $clients['ID'];
            if ($client_id ==  $user_id ): 
                        array_push($feedbacks_user, $feedback_id);
            endif;
        endforeach;
    else:
        $feedbacks_user = array(0);
    endif;

    
    /* COMPLETED FEEDBACKS */
    if (!empty($feedbacks_user)) {

        $args_completed = array( 
            'post_type' => 'feedback', 
            'posts_per_page' => -1, 
            'post__in'  => $feedbacks_user,
            'order' => 'DESC',
            
        );
        $completed_feedbacks = get_posts( $args_completed );
    }
    else {
        $completed_feedbacks = array();
    }
                
?>
