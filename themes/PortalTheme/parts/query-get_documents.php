<?php
     /* ALL VIDEOS */
    $documents_user = array();
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'documents'
    );
    $documents = get_posts( $args );

    foreach ($documents as $document):
        $document_id = $document->ID;
        $delegates = get_field('delegate', $document_id );
         
        if ($delegates):

            foreach ($delegates as $delegate):
                $single_delegate_id = $delegate['ID'];
                if( $single_delegate_id ==  get_current_user_id()): 
                    array_push($documents_user, $document_id);
                endif;
            endforeach;

        endif;
       
    endforeach;



    /* COMPLETED VIDEOS */
    if (!empty($documents_user)) {

        $args_completed = array( 
            'post_type' => 'documents', 
            'posts_per_page' => -1, 
            'post__in'  => $documents_user,
            'order' => 'DESC',
            
        );
        $selected_documents = get_posts( $args_completed );
    }

    
?>