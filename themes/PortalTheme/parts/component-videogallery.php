<?php 
    
    $user = wp_get_current_user();
    $user_role = (array) $user->roles; 
    $role = $user_role[0];

    if ($role == "client") {
        require('query-get_videos_admin.php');
    }
    else if ($role == "delegate") {
        require('query-get_videos.php');
    }

?>

<div class="container small-padding min-600">

    <!-- Title -->
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-8 mt-5 order-2 order-lg-1">
                <h1>Video gallery</h1>
        </div>
         <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2">
            <?php require('part-team_top.php'); ?>
        </div>
    </div>


    <!-- Sessions -->
    <div class="mt-4">

        <hr class="m-0">
        
        <?php 
        if (!empty($completed_videos)):
            foreach ($completed_videos as $index=>$video):
                $video_id = $video->ID; ?>

                <div class="openVideo px-4 py-3" href="#<?php echo $video_id ?>" aria-expanded="false"  >
                    <?php require('part-video_item.php'); ?>
                </div>
                <div class="collapse infoVideo px-4 py-3" id="<?php echo $video_id ?>" action="<?php echo admin_url('admin-ajax.php'); ?>" >
                    <div class="content" style="min-height: 30vh" ></div>
                </div>

                <hr class="m-0">

            <?php endforeach;  

        else: ?>
            <p class="no-sessions">No videos</p>
        <?php endif;
        ?>

    </div>
      
</div>
    


<script>



</script>
