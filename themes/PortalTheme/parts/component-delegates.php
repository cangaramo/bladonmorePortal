<!-- DASHBOARD -->			
<div class="container small-padding min-650">

    <!-- Title -->
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-8 order-2 order-lg-1 mt-4 mt-lg-5">
                <h1>Delegates</h1>
        </div>
         <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2 ">
            <?php require('part-team_top.php'); ?>
        </div>
    </div>

    <?php require('query-get_delegates.php'); ?>

    <!-- DELEGATES LIST -->
    <div class="mt-4">

        <hr class="m-0">

        <?php 
        if (!empty($delegates)):
            foreach ($delegates as $delegate):  
                $user_id = $delegate->ID;
                $user_info = get_userdata($user_id);
                $last_name = $user_info->last_name;
                $first_name =  $user_info->first_name;
                $initials =  $first_name[0] . $last_name[0]; ?>     

                <div class="openDelegate p-0 px-3 px-lg-4 py-3" data-toggle="collapse" href="#<?php echo $user_id?>"aria-expanded="false" >
                    <?php require('part-delegate_item.php'); ?>
                </div>

                <div class="collapse p-0 px-3 px-lg-4 py-2 infoDelegate" id="<?php echo $user_id?>">

                    Sessions 
                    <?php 
                        $user_delegate = $user_id;
                        require('query-get_agendas.php');
                        if (!empty($upcoming_agendas)):
                            foreach ($upcoming_agendas as $agenda):
                                $agenda_id = $agenda->ID;  ?>

                                <div class="p-0 py-3" href="#<?php echo $agenda_id ?>" aria-expanded="false" >
                                    <?php require('part-agenda_item_small.php'); ?>
                                </div>
                
                            <?php endforeach;  
                        else: ?>
                            <p class="no-sessions">No upcoming sessions</p>
                        
                        <?php endif; ?>

                </div> 

                <hr class="m-0">

            <?php endforeach;  

        else: ?>
            <p class="no-sessions">No delegates</p>
        <?php endif; ?>

    </div>

</div>
