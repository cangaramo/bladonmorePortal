<?php

    /* ALL FEEDBACKS */
    $feedbacks_user = array();
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'feedback'
    );

    $args['meta_key'] = "feedback_status";
    $args['meta_value'] = "Approved";
    $feedbacks = get_posts( $args );

    foreach ($feedbacks as $feedback):
        $feedback_id = $feedback->ID;
        $title_feedback = get_the_title($feedback_id);
        $session = get_field('session', $feedback_id );
        $session_id = $session->ID;
        $delegates = get_field('delegates', $session_id );
         
        if ($delegates):

            foreach ($delegates as $single_delegate_id): 
                if( $single_delegate_id ==  get_current_user_id()): 
                    echo ' ' . $single_delegate_id . ' ' . get_current_user_id();
                    array_push($feedbacks_user, $feedback_id);
                endif;
            endforeach;

        endif;
       
    endforeach;


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
                
?>
