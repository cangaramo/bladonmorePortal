<?php
    $link = get_the_permalink($feedback_id);
    $session = get_field('session', $feedback_id);
    $session_id = $session->ID;
    $date = get_field('agenda_date', $session_id);
    $end_time = get_field('end_time', $session_id);
    $start_time = get_field('start_time', $session_id);
    $address = get_field('address', $session_id)['address']; 
    $current_id = get_the_ID();
    $delegates = get_field('delegates', $session_id);
?>

    <div class="list-item right" onclick="location.href='<?php echo $link ?>';">

        <div class="row p-0">
            
            <div class="col-11 p-0">
                
                <div class="row">

                    <!-- Date and location -->
                    <div class="col-12 col-lg-4 p-0">
                        <p class="mt-1">
                            <i class="far fa-calendar"></i>
                            <span class="title mt-1"><?php echo $date; ?></span>
                        </p>
                    </div>

                    <!-- Hours --> 
                    <div class="col-12 col-lg-5 p-0">
                        <div class="h-100 d-flex align-items-center">
                            <p class="mt-1">
                                <i class="far fa-clock"></i>
                                <span><?php echo $start_time ?></span> - <span><?php echo $end_time ?></span>
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 p-0">
                        <div class="h-100 d-flex align-items-center">
                            <p class="mt-2 completed">Feedback</p>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 p-0">
                        <p class="mt-2"><i class="fas fa-user-friends"></i>
                            <?php foreach ($delegates as $index=>$delegate):

                                $user_info = get_userdata($delegate);
                                $first_name =  $user_info->first_name;
                                $last_name = $user_info->last_name;
                                if ($index == 0){
                                    echo ($first_name . ' ' . $last_name);
                                }
                                else {
                                    echo (', ' . $first_name . ' ' . $last_name );
                                }
                                
                            endforeach; ?>

                        </p>
                    </div>
                </div>

            </div>

            <!-- Arrow mobile -->
            <div class="col-1 p-0 d-flex align-items-center">
                <div class="arrow-right" ></div>
            </div>
            
           
        </div>


    </div>

<?php ?>
