<?php 
    
    $user = wp_get_current_user();
    $user_role = (array) $user->roles; 
    $role = $user_role[0];

    if ($role == "client") {
        require('query-get_feedbacks_admin.php');
    }
    else if ($role == "delegate") {
        require('query-get_feedbacks.php');
    }

?>
			
<div class="container small-padding min-650">

    <!-- Title -->
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-8 order-2 order-lg-1 mt-5">
            <h1>Feedback</h1>
        </div>
         <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2">
            <?php require('part-team_top.php'); ?>
        </div>
    </div>

    <!-- Sessions feedback -->
    <div class="mt-4">
        <hr class="m-0">            
        <?php 
            if (!empty($completed_feedbacks)):
                foreach ($completed_feedbacks as $index=>$feedback):
                    $feedback_id = $feedback->ID; ?>

                    <div class="openFeedback p-0 px-4 py-3" href="#<?php echo $feedback_id ?>" aria-expanded="false"  >
                        <?php require('part-feedback_item.php'); ?>
                    </div>
                    <div class="collapse infoFeedback p-0 px-4 py-2" id="<?php echo $feedback_id ?>" action="<?php echo admin_url('admin-ajax.php'); ?>" ">
                        <div class="content" style="min-height: 60vh" ></div>
                    </div>

                    <hr class="m-0">

                <?php endforeach;  

            else: ?>
                <p class="no-sessions">No feedback</p>
            <?php endif;
        ?>
    </div>

</div>
    