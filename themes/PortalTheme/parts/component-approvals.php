<?php 
    
    $user = wp_get_current_user();
    $user_role = (array) $user->roles; 
    $role = $user_role[0];

    if ($role == "client") {
        $approval = true;
        require('query-get_feedbacks_admin.php');
        require('query-get_agendas_admin.php');
    }
?>

<!-- Change query -->
<div class="container small-padding min-650">

    <!-- Title -->
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-8 order-2 order-lg-1 mt-5">
            <h1>Approvals</h1>
        </div>
         <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2">
            <?php require('part-team_top.php'); ?>
        </div>
    </div>

    <hr class="m-0 mt-4 d-none d-lg-block">

    <!-- Sessions list -->
    <div class="mt-2">
        <?php 
                
        if (!empty($upcoming_agendas)):
            foreach ($upcoming_agendas as $index=>$agenda):
                $agenda_id = $agenda->ID;  ?>
                                
                <div class="p-0 px-3 px-lg-4 py-3" href="#<?php echo $agenda_id ?>" aria-expanded="false" >
                    <?php require('part-agenda_item_approval.php'); ?>
                </div>

            <?php endforeach;  

        else:
            /* No sessions to approve */
        endif; ?>

    </div>

    <!-- Sessions feedback -->
    <div class="">

        <?php 
            if (!empty($completed_feedbacks)):
                foreach ($completed_feedbacks as $index=>$feedback):
                    $feedback_id = $feedback->ID; ?>

                    <div class=" p-0 px-4 py-3" href="#<?php echo $feedback_id ?>" aria-expanded="false"  >
                        <?php require('part-feedback_item_approval.php'); ?>
                    </div>

                <?php endforeach;  

            else:
                /* No feedback to approve */
            endif;
        ?>
    </div>

    <?php 
    if ( empty($upcoming_agendas) && empty ($completed_feedbacks) ) : ?>
        <p class="no-sessions mt-4">No items to approve </p>
    <?php endif ?>
    

</div>
    