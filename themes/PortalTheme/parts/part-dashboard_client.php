<!-- DASHBOARD -->			
<div class="container small-padding min-650">

    <!-- Title -->
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-8 order-2 order-lg-1 mt-4 mt-lg-5">
                <h1>Dashboard</h1>
        </div>
         <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2 ">
            <?php require('part-team_top.php'); ?>
        </div>
    </div>

    <!-- Delegates -->
    <?php 
        require('query-get_delegates.php'); 
        $num_delegates = count($delegates);
    ?>
      <!--
    <div class="mt-4">
        <hr class="m-0">

        <div class="row px-3 px-lg-4">
            <div class="col-8 col-lg-6 p-0">
                <h3 class="mt-4">Your delegates</h3>
                <p>Overview of employees who have been trained or are booked to be trained in upcoming sessions. </p>
            </div>
            <div class="col-1 col-lg-4 p-0"></div>
            <div class="col-2 col-lg-1 p-0"> 
                <?php if ($delegates) : ?>
                    <div class="h-100 d-flex align-items-center">
                        <div class="badge turquoise d-flex align-items-center justify-content-center" onclick="location.href='/delegates';">
                            <span><?php echo $num_delegates?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-1 p-0 d-flex align-items-center right">
                <div onclick="location.href='/delegates';" class="arrow-right" ></div>
            </div>
        </div>

    </div>
-->

    <!-- Sessions list -->
    <div class="mt-4">
        <hr class="m-0">
        <div class="row px-3 px-lg-4">
            <div class="col-12 p-0">
            <h3 class="mt-4">Your sessions</h3>
            </div>
        </div>

        <?php 
        $approval = false;
        require('query-get_agendas_admin.php');
                
        if (!empty($upcoming_agendas)):
            foreach ($upcoming_agendas as $index=>$agenda):
                $agenda_id = $agenda->ID;  ?>
                                
                <div class="p-0 px-3 px-lg-4 py-3" href="#<?php echo $agenda_id ?>" aria-expanded="false" >
                    <?php require('part-agenda_item_small.php'); ?>
                </div>

            <?php endforeach;  

        else: ?>
            <p class="no-sessions">No upcoming sessions</p>
        <?php endif; ?>

    </div>

    <!-- Approvals list -->
    <div class="mt-4">
        
        <hr class="m-0">

        <?php 
            $user = wp_get_current_user();
            $approval = true;
            require('query-get_agendas_admin.php'); 
            require('query-get_feedbacks_admin.php'); 

            //Number of agendas
            if (!empty($upcoming_agendas)) {
                $num_agendas = count($upcoming_agendas);
            }
            else {
                $num_agendas = 0;
            }

            //Number of feedbacks
            if (!empty($completed_feedbacks)){
                $num_feedbacks = count($completed_feedbacks);
            }
            else {
                $num_feedbacks = 0;
            }
            
            $num_approvals = $num_agendas + $num_feedbacks;
        ?>

        <!-- Title -->
        <div class="row px-3 px-lg-4">
            <div class="col-8 col-lg-6 p-0">
                <h3 class="mt-4">Approvals</h3>
                <p>Items awaiting your feedback before they are shared with delegates. </p>
            </div>
            <div class="col-1 col-lg-4 p-0"></div>
            <div class="col-2 col-lg-1 p-0">
                <div class="h-100 d-flex align-items-center">
                    <div class="badge salmon d-flex align-items-center justify-content-center" onclick="location.href='/approvals';">
                        <span><?php echo $num_approvals ?></span>
                    </div>
                </div>
            </div>
            <div class="col-1 p-0"></div>
        </div>

        <?php if ($num_approvals == 0) : ?>
            <p class="no-sessions mt-3">No items to approve</p>
        <?php endif; ?>

        <!-- Sessions list -->
        <div class="mt-2">
            <?php        
            if (!empty($upcoming_agendas)):
                foreach ($upcoming_agendas as $index=>$agenda):
                    $agenda_id = $agenda->ID;  ?>
                    <div class="openAgenda p-0 px-3 px-lg-4 py-3" href="#<?php echo $agenda_id ?>" aria-expanded="false" >
                        <?php require('part-agenda_item_approval.php'); ?>
                    </div>
                <?php endforeach;  
            else: 
                /* No sessions to approve */
            endif; ?>
        </div>


        <!-- Sessions feedback -->
        <div class="mb-5">
              
                <?php 
                if (!empty($completed_feedbacks)):
                    foreach ($completed_feedbacks as $index=>$feedback):
                        $feedback_id = $feedback->ID; ?>
                        <div class="openFeedback p-0 px-3 px-lg-4 py-3" href="#<?php echo $feedback_id ?>" aria-expanded="false"  >
                            <?php require('part-feedback_item_approval.php'); ?>
                        </div>
                    <?php endforeach;  
                else: 
                    /* No feedback to approve */
                endif;
            ?>
        </div>

       
    </div>

</div>
