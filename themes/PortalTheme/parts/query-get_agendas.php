<?php 
    if ($user_delegate) {
        $current_delegate = $user_delegate;
    }
    else {
        $current_delegate = get_current_user_id();
    }

    /* ALL AGENDAS */
    $agendas_user = array();
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'agendas',
    );

	$args['meta_key'] = "session_status";
        $args['meta_value'] = "Approved";

    $agendas = get_posts( $args );

    foreach ($agendas as $agenda):
        $agenda_id = $agenda->ID;
        $title_agenda = get_the_title($agenda_id);
        $delegates = get_field('delegates', $agenda_id );
        
        if ($delegates):
            foreach ($delegates as $single_delegate_id): 
                            
                if( $single_delegate_id == $current_delegate ): 
                    array_push($agendas_user, $agenda_id);
                endif;
            endforeach;
        endif;

    endforeach;

    /* GET TODAY DATE */
    $date_now = date('Y-m-d H:i:s');
    $time_now = strtotime($date_now);

    /* UPCOMING AGENDAS */
    if (!empty($agendas_user)) {

        $args_upcoming = array(
            'post_type' => 'agendas', 
            'posts_per_page' => -1, 
            'post__in'  => $agendas_user,
            'orderby'=> 'meta_value', 
            'meta_key'  => 'agenda_date',
        );
        $upcoming_agendas = get_posts( $args_upcoming );
    }
   
    /* COMPLETED AGENDAS 
    if (!empty($agendas_user)) {

        $args_completed = array( 
            'post_type' => 'agendas', 
            'posts_per_page' => -1, 
            'post__in'  => $agendas_user,
            'orderby'=> 'meta_value', 
            'meta_key'  => 'agenda_date', 
            'order' => 'DESC',
            'meta_query' => array(
                    array(
                        'key'			=> 'agenda_date',
                        'compare'		=> '<',
                        'value'			=> $date_now,
                        'type'			=> 'DATETIME'
                    )
            ),
        );
        $completed_agendas = get_posts( $args_completed );
    } */
?>