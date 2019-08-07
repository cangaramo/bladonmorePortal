<?php 

    if( get_current_user_id()== 0 ): 
                
        $siteurl = home_url();
        $url = $siteurl . "/login";
        wp_redirect( $url );
        exit;

    endif;

    require('parts/query-get_feedbacks.php');
?>

<?php get_header(); ?>
			
	<main>

    <div class="row p-0">

        <div class="d-none d-lg-flex col-3 p-0">
            <?php get_sidebar(); ?>
        </div>

        <div class="col-12 col-lg-9 p-0">

            <?php 
				$feedback_id = get_the_ID();
				$session = get_field('session', $feedback_id);
				$session_id = $session->ID;
                $date = get_field('agenda_date', $session_id);
            ?>

            <div class="container small-padding min-600 mb-5">

                <!-- Title -->
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-8 mt-5 order-2 order-lg-1">
                            <h1><?php echo $date ?></h1>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2">
                        <?php require('parts/part-team_top.php'); ?>
                    </div>
                </div>

                <!-- Sessions -->
                <div class="mt-4">

                    <div class="row">
                        <div class="col-12">
                            <?php require('parts/part-feedback_info.php'); ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>


	
	</main> <!-- end #content -->

<?php get_footer(); ?>

