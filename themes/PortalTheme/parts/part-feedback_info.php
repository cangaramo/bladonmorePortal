<?php
    $link = get_the_permalink($feedback_id);

    $session = get_field('session', $feedback_id);

    //Session
    $session_id = $session->ID;
    $date = get_field('agenda_date', $session_id);
    $end_time = get_field('end_time', $session_id);
    $start_time = get_field('start_time', $session_id);
    $address = get_field('address', $session_id)['address']; 
    $trainers = get_field('trainers', $session_id);

    //Feedback
    $overview = get_field('overview', $feedback_id);
    $empty_box = get_field('empty_box', $feedback_id);
    $went_well = get_field('went_well', $feedback_id);
    $more_work = get_field('more_work', $feedback_id);
    $conclusions = get_field('conclusions', $feedback_id); 
    $allow_approve = get_field('allow_approve', $feedback_id); 

    //Status
    $status = get_field('feedback_status', $feedback_id);

    //Admin 
    $client = get_field('organisation_client', $session_id);
    $client_id = $client['ID'];
    $current_id = get_current_user_id();
    if ($client_id == $current_id) {
        $admin = true;
    }

?>
    <div class="session-info">

        <div class="row">
            <div class="col-12 col-lg-6 col-xl-8 p-0 pr-lg-5">

                <!-- Overview -->
                <p class="subtitle m-0 mb-4">OVERVIEW</p>
                <div><?php echo $overview ?></div>

                <!-- Empty box -->
                <?php if ($empty_box): ?>
                    <p class="subtitle m-0 mb-4"></p>
                    <div><?php echo $empty_box ?></div>
                <?php endif ?>

                <!-- What went well -->
                <?php if ($went_well): ?>
                    <p class="subtitle m-0 mb-4">WHAT WENT WELL</p>
                    <div><?php echo $went_well ?></div>
                <?php endif ?>

                <!-- What needs more work -->
                <?php if ($more_work): ?>
                    <p class="subtitle m-0 mb-4">WHAT NEEDS MORE WORK</p>
                    <div><?php echo $more_work ?></div>
                <?php endif; ?>

                <!-- Conclusions -->
                <p class="subtitle m-0 mb-4">CONCLUSIONS</p>
                <div><?php echo $conclusions ?></div>
            
            </div>

            <div class="col-12 col-lg-6 col-xl-4 pl-lg-4 p-0">

                <!-- Trainers -->
                <p class="subtitle m-0 mb-4 mt-3">YOUR TRAINERS</p>
                <?php foreach ($trainers as $trainer): 
                    $image = get_field('picture', $trainer);
                    $name =  get_the_title($trainer); 
                    $role =  get_field('role', $trainer); ?>

                    <div class="row p-0 mt-2">
                        <div class="col-4 col-md-2 col-lg-4 p-0">
                            <img class="my-2 my-md mx-auto mx-md-0 d-block avatar rounded-img" src="<?php echo $image ?> "/>    
                        </div>
                            
                        <div class="col-8">
                            <div class="h-100 d-flex align-items-center">
                                <div class="w-100 text-left">
                                    <p class="name m-0"><?php echo $name ?></p>
                                    <p class="m-0"><?php echo $role ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                                                
                <?php endforeach;?>

                <!-- Your approval -->
                <?php 
                    $class_request = "";
                    $class_approve = "";
            
                    if ($status == "Pending" ) {
                        $text_request = "Request changes";
                        $text_approve = "Approve";
                        $icon_request = "fas fa-times-circle";
                    }
                    else if ( $status == "Awaiting feedback") {
                        $class_request = "disable";
                        $text_approve = "Approve";
                        $text_request = "Changes requested";
                        $icon_request = "far fa-clock";
                    }
                    else {
                        $class_request = "disable";
                        $class_approve = "disable";
                        $text_approve = "Approved";
                        $text_request = "Request changes";
                        $icon_request = "fas fa-times-circle";
                    }
                ?>

                <?php if ($admin && $allow_approve ): ?> 
                    <div class="approval">

                        <p class="subtitle mt-4">Your approval</p>
                        <p>Select approve to share this agenda with your delegates. 
                            Alternatively click request changes to provide feedback on any amends required.  </p>

                        <div class="d-flex align-items-center my-3 approve <?php echo $class_approve ?>" 
                            data-id="<?php echo $feedback_id?>"
                            data-type="Feedback"
                            action="<?php echo admin_url('admin-ajax.php'); ?>" >

                            <i class="fas fa-check-circle"></i>
                            <span><?php echo $text_approve ?></span>

                        </div>

                        <div class="d-flex align-items-center my-3 request <?php echo $class_request ?>" 
                            data-id="<?php echo $feedback_id?>" 
                            data-item="<?php echo $link?>" 
                            data-type="Feedback"
                            action="<?php echo admin_url('admin-ajax.php'); ?>"  >

                            <i class="<?php echo $icon_request ?>"></i>
                            <span><?php  echo $text_request?></span>

                        </div>
                    </div>
                <?php endif ?>

            </div>
        </div>
            
        </div>
    <?php ?>