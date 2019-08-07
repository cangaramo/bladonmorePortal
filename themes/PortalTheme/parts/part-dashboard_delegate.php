<?php 
    //Saymore details 
    $user = 'user_'. get_current_user_id() ;
?>

<div class="white-bg">
			
    <div class="container small-padding">

        <!-- Title -->
        <div class="row">
            <div class="col-12 col-lg-7 order-2 order-lg-1 mt-3 mt-lg-5 p-0">
                <h1>Welcome</h1>
            </div>
            <div class="col-12 col-lg-4 order-1 order-lg-3 p-0">
                <?php require('part-team_top.php'); ?>
            </div>

            <div class="col-1 order-lg-3 order-lg-2">
            </div>
        </div>

        <div class="mt-4">
               
            <div class="row">
                <div class="col-12 col-lg-7 p-0 pr-lg-5 copy">
                    <p>This is your coaching portal. If your session is coming up you can look at your <a href="/agenda">agenda</a>. 
                    This will tell you the timings and location of the session, as well as an outline of how it will run. 
                    
                    <?php 
                    $user_id = 'user_'. get_current_user_id() ;
                    $hide_questionnaire = get_field("hide_questionnaire", $user_id);

                    if (!$hide_questionnaire): ?>
                        You will get even more out of your session if the coaches know a little more about you. 
                        So we’d be really grateful if you could fill in this <a href="/questionnaire">questionnaire</a> – it will take less than 5 minutes, we promise. 
                    <?php endif; ?>
                    
                    <br><br>
                    If you’ve already had your session, we hope you enjoyed it. You can watch your <a href="/videogallery">videos</a>, and read your <a href="/feedback">feedback note</a>. 
                    If you need us again or have any questions, you can always contact us. Kind regards The Bladonmore Team</p>
                </div> 
                <div class="col-12 col-lg-4 p-0">

                    <?php 
                    $saymore_user_id = get_field('app_user', $user);
                    $username = get_the_title($saymore_user_id);
                    $password = get_field('password', $saymore_user_id);
                    ?>
                   
                    <!-- saymore -->
                    <div class="saymore py-4 d-flex flex-column text-center justify-content-center">

                        <img class="phone mx-auto" style="width: 150px; height: 285px !important" src="<?php echo get_bloginfo('template_directory'); ?>/images/saymore.png"/>

                        <h2 class="mt-4 mb-1">SAYMORE</h2>
                        <p class="mb-3">The presentation app</p>

                        <div>
                            <span class="m-0" style="font-weight:bold">username</span>
                            <span class="m-0 pl-3"><?php echo $username ?></span>
                        </div>

                        <div>
                            <span class="m-0" style="font-weight:bold">password</span>
                            <span class="m-0 pl-3"><?php echo $password ?></span>
                        </div>

                        <div class="mt-4 d-flex justify-content-center">
                            <a href="https://itunes.apple.com/us/app/saymore-bladonmore/id1439891716?ls=1&mt=8"><img class="mr-1" height="30" src="<?php echo get_bloginfo('template_directory'); ?>/images/appstore.png"/></a>
                            <a href="https://play.google.com/store/apps/details?id=com.Bladonmore.Coaching"><img class="ml-1" height="30" src="<?php echo get_bloginfo('template_directory'); ?>/images/googleplay.png"/></a>
                        </div>

                    </div> <!-- saymore -->

                </div> 

             <div class="col-1">
            </div>
   
        </div>
    
    </div>
    
</div>