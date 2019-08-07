<div class="gray-bg">
			
    <div class="container small-padding min-600">

        <!-- Title -->
        <div class="row">
            <div class="col-12 col-lg-6 col-xl-7 order-2 order-lg-1 p-0 mt-3 mt-lg-5 ">
                <h1>How can we help?</h1>
            </div>
            <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2 p-0">
                <?php require('part-team_top.php'); ?>
            </div>

            <div class="col-1 order-3">
            </div>
        </div>

        <div id="contact" class="mt-4">
               
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-7 p-0 pr-3 pr-lg-5 ">
                    <?php gravity_form( 4, $display_title = false, $display_description = true); ?>
                </div> 
                <div class="col-12 col-lg-6 col-xl-5 p-0">
                    <?php gravity_form( 5, $display_title = false, $display_description = true); ?> 
                </div> 
            </div>

        </div>

    </div>
    
</div>