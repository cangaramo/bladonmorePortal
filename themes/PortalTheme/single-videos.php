<?php 
    require('parts/part-get_videos.php');
?>

<?php get_header(); ?>
			
	<main>

		<div class="bg">
			
			<div class="container small-padding">
			
				<fieldset>
					<legend>Agenda</legend>
		
					<div class="row">
		
						<div class="col-3 p-0">
                            <div class="d-none d-lg-block">

                                <!-- List sessions -->
                                <h4 class="list-title">SESSIONS</h4>
            
                                <?php 
                                    if (!empty($completed_videos)):
                                        foreach ($completed_videos as $index=>$video):
                                            $video_id = $video->ID;
                                            require('parts/part-video_item.php');
                                        endforeach;  

                                    else: ?>
                                        <p class="no-sessions">No videos</p>
                                    <?php endif;
                                ?>
            
                            </div>
		
						</div>
		
						<div class="col-12 col-lg-9 p-0 bg-white">
							
                            <!-- Current videos -->
							<?php 
								$video_id = get_the_ID();
								require('parts/part-video_info.php');
							?>

						</div>
		
					</div>
		
				</fieldset>
				
			</div>
			
		</div>
	
	</main> 

<?php get_footer(); ?>
