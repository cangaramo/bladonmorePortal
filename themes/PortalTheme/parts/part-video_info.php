<?php
    $session = get_field('session', $video_id);

    //Session
    $session_id = $session->ID;
    $date = get_field('agenda_date', $session_id);
    $end_time = get_field('end_time', $session_id);
    $start_time = get_field('start_time', $session_id);
    $address = get_field('address', $session_id)['address']; 
    $trainers = get_field('trainers', $session_id);

    //Videos
    $videos = get_field('session_videos', $video_id);
?>
    <div class="session-info">

        <div class="row">

            <div class="col-12 col-lg-8">
                 <!-- Session videos -->
                    <div>
                        <?php 
                        foreach ($videos as $video):
                            
                            $vimeo_id =  $video['vimeo_id_video'];
                            $url = "https://player.vimeo.com/video/" . $vimeo_id;
                            if ($vimeo_id): ?>

                                <div class="mb-4" style="padding:56.25% 0 0 0;position:relative;">			
                                    <iframe src="<?php echo $url;?>" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                    </iframe>			
                                </div>				

                            <?php endif; 

                        endforeach;
                        ?>
                            
                    </div>

            </div>

            <div class="col-12 col-lg-4">
            </div>

        </div>              

       

    </div>
    <?php ?>