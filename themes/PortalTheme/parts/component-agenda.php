<?php

    $user = wp_get_current_user();
    $user_role = (array) $user->roles; 
    $role = $user_role[0];

    if ($role == "client") {
        require('query-get_agendas_admin.php');
    }
    else if ($role == "delegate") {
        require('query-get_agendas.php');
    }
?>

<!-- AGENDA -->			
<div class="container small-padding min-650">

    <!-- Title -->
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-8 order-2 order-lg-1 mt-4 mt-lg-5">
                <h1>Sessions</h1>
        </div>
         <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2 ">
            <?php require('part-team_top.php'); ?>
        </div>
    </div>

    <!-- Sessions list -->
    <div class="mt-4">
        <hr class="m-0">
        <?php 
                
        if (!empty($upcoming_agendas)):
            foreach ($upcoming_agendas as $index=>$agenda):
                $agenda_id = $agenda->ID;  ?>
                                
                <div class="openAgenda p-0 px-3 px-lg-4 py-3" href="#<?php echo $agenda_id ?>" aria-expanded="false" >
                    <?php require('part-agenda_item.php'); ?>
                </div>
                <div class="collapse infoAgenda p-0 px-3 px-lg-4 py-2" id="<?php echo $agenda_id ?>" action="<?php echo admin_url('admin-ajax.php'); ?>"  >
                    <div class="content" style="min-height: 60vh" ></div>
                </div>

                <hr class="m-0">

            <?php endforeach;  

        else: ?>
            <p class="no-sessions">No upcoming sessions</p>
        <?php endif; ?>

    </div>

</div>
