  <?php
    $title_agenda = get_the_title($agenda_id); 
    $link = get_the_permalink($agenda_id);
    $date = get_field('agenda_date', $agenda_id);
    $end_time = get_field('end_time', $agenda_id);
    $start_time = get_field('start_time', $agenda_id);
    $address = get_field('address', $agenda_id)['address'];
    $current_id = get_the_ID();
    $delegates = get_field('delegates', $agenda_id);

    /* Compare date */
    $date_session = new DateTime($date);
    $date_session = $date_session->format('Y-m-d');
    $date_now = date('Y-m-d');
?>
    <div  class="list-item right" onclick="location.href='<?php echo $link ?>';">

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
                        <div class="h-100 d-flex align-items-lg-center">
                            <p class="mt-1">
                                <i class="far fa-clock"></i>
                                <span><?php echo $start_time ?></span> - <span><?php echo $end_time ?></span>
                            </p>
                        </div>
                    </div>

                    <!-- Complete -->
                    <div class="col-12 col-lg-3 p-0">
                        <div class="h-100 d-flex align-items-center">
                            <p class="mt-1 completed">Session</p>
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

            <!-- Arrow  -->
            <div class="col-1 p-0 d-flex align-items-center">
                <div class="arrow-right" ></div>
            </div>

        </div>

    </div>

<?php ?>

