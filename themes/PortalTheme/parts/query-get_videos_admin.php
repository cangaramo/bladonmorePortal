<?php
    $user_id = get_current_user_id();

    /*  VIDEOS */
    $videos_user = array();
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'videos'
    );

    $videos = get_posts( $args );

    if (!empty($videos)):
        foreach ($videos as $video):
            $video_id = $video->ID;
            $title_video = get_the_title($video_id);
            $session = get_field('session', $video_id );
            $session_id = $session->ID;
            $clients = get_field('organisation_client', $session_id );
            $client_id = $clients['ID'];
            if ($client_id ==  $user_id ): 
                        array_push($videos_user, $video_id);
            endif;
        endforeach;
    else:
        $videos_user = array(0);
    endif;

    
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
