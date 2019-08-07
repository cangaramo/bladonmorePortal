<?php 
    $user_id = get_current_user_id();

    /* AGENDAS */
    $agendas_user = array();
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'agendas'
    );

    //Get only the agendas need to be approved
    if ( $approval ) {
        $args['meta_key'] = "session_status";
        $args['meta_value'] = "Pending";  
    }
    $agendas = get_posts( $args );

    if (!empty($agendas)):
        foreach ($agendas as $agenda):
            $agenda_id = $agenda->ID;
            $title_agenda = get_the_title($agenda_id);
            $clients = get_field('organisation_client', $agenda_id );
            $status = get_field('session_status', $agenda_id );
            $client_id = $clients['ID'];
            if( $client_id ==  $user_id ): 
                array_push($agendas_user, $agenda_id);
            endif; 

        endforeach;
    else:
        $agendas_user = array(0);
    endif;

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
            'meta_key'  => 'agenda_date'
        );
        
        $upcoming_agendas = get_posts( $args_upcoming );
    }
    else {
        $upcoming_agendas = array();
    }

   // print_r($upcoming_agendas);

?>