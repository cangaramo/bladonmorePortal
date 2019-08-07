<?php
     /* ALL VIDEOS */
    $videos_user = array();
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'videos'
    );
    $videos = get_posts( $args );

    foreach ($videos as $video):
        $video_id = $video->ID;
        $session = get_field('session', $video_id );
        $session_id = $session->ID;
        $delegates = get_field('delegates', $session_id );
         
        if ($delegates):

            foreach ($delegates as $single_delegate_id): 
                if( $single_delegate_id ==  get_current_user_id()): 
                    array_push($videos_user, $video_id);
                endif;
            endforeach;

        endif;
       
    endforeach;


    /* COMPLETED VIDEOS */
    if (!empty($videos_user)) {

        $args_completed = array( 
            'post_type' => 'videos', 
            'posts_per_page' => -1, 
            'post__in'  => $videos_user,
            'order' => 'DESC',
            
        );
        $completed_videos = get_posts( $args_completed );
    }
?>