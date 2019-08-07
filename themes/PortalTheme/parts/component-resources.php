<?php 
    $copy = $values['body_copy'];
    $resources = $values['resources'];
?>

<div class="bg">
			
    <div class="container small-padding min-650">
    
        <fieldset>
            <legend>Dashboard</legend>

            <div class="p-1 p-md-3">

                <div class="row">

                    <div class="col-12 col-lg-6">
                        <?php echo $copy; ?>
                    </div>

                    <div class="col-12 col-lg-6 resources">
                        <h3>Resources</h3>

                        <div class="row">
                            
                            <div class="col-12 col-xl-6 mb-4 p-0 p-lg-3">
                                <p class="title"><?php echo $resources[0]['title']?></p>
                                <img width="100%" src="<?php echo $resources[0]['image']?>" />
                                <div class="d-flex justify-content-center mt-3">
                                    <img height="25" width="25" src="<?php echo get_bloginfo('template_directory'); ?>/images/download.png" >
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <a class="download" href="<?php echo $resources[0]['file'] ?>">Download</a>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6 p-0 p-lg-3">
                                <p class="title"><?php echo $resources[1]['title']?></p>
                                <img width="100%" src="<?php echo $resources[1]['image']?>" />
                                <div class="d-flex justify-content-center mt-3">
                                    <img height="25" width="25" src="<?php echo get_bloginfo('template_directory'); ?>/images/download.png" >
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <a class="download" href="<?php echo $resources[1]['file'] ?>">Download</a>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div> 
                   

        </fieldset>
        
    </div>
    
</div>