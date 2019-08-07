<?php 
    $copy = $values['copy'];
    $user = 'user_'. get_current_user_id() ;
?>

<div class="gray-bg">
			
    <div class="container small-padding min-600">

         <!-- Title -->
        <div class="row">
            <div class="col-12 col-lg-6 col-xl-8 order-2 order-lg-1 mt-4 mt-lg-5">
                    <h1>Questionnaires</h1>
            </div>
            <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2 "></div>
        </div>

        <!-- Questionnaires -->
        <div class="mt-4 mt-lg-5 list-questionnaires">

            <!-- Media -->
            <?php $types = get_field('type', $user);
            if( $types && in_array('media', $types) ): ?>
                <hr class="m-0">
                <div class="p-0 px-3 px-lg-4 py-4 openQuestionnaire" data-toggle="collapse" href="#questionnaire-media" >
                    <div  class="list-item right" >
                        <div class="row p-0">
                            <div class="col-11 p-0">
                                <span class="title mt-1">Media</span>
                            </div>
                            <div class="col-1 p-0 d-flex align-items-center">
                                <img height="25" width="25" src="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-down.png" 
                                    data-status = "closed"
                                    down="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-down.png"
                                    up="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-up.png" />
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="pt-1 px-2 pb-4 questionnaire collapse" id="questionnaire-media">
                <?php gravity_form( 2, $display_title = false, $display_description = true,  $ajax = true, $tabindex, $echo = true );?>
                </div>
            <?php endif ?>

            <!-- Presentation -->
            <?php if( $types && in_array('presentation', $types) ): ?>
                <hr class="m-0">
                <div class="p-0 px-3 px-lg-4 py-4 openQuestionnaire" data-toggle="collapse" href="#questionnaire-presentation" >
                    <div  class="list-item right" >
                        <div class="row p-0">
                            <div class="col-11 p-0">
                                <span class="title mt-1">Presentation</span>
                            </div>
                            <div class="col-1 p-0 d-flex align-items-center">
                                <img height="25" width="25" src="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-down.png" 
                                    data-status = "closed"
                                    down="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-down.png"
                                    up="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-up.png" />
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="pt-1 px-2 pb-4 questionnaire collapse" id="questionnaire-presentation">
                <?php gravity_form( 3, $display_title = false, $display_description = true, $ajax = true, $tabindex, $echo = true );?>
                </div>
            <?php endif ?>

            <!-- Writing -->
            <?php if( $types && in_array('writing', $types) ): ?>
                <hr class="m-0">
                <div class="p-0 px-3 px-lg-4 py-4 openQuestionnaire" data-toggle="collapse" href="#questionnaire-writing" >
                    <div  class="list-item right" >
                        <div class="row p-0">
                            <div class="col-11 p-0">
                                <span class="title mt-1">Writing workshop</span>
                            </div>
                            <div class="col-1 p-0 d-flex align-items-center">
                                <img height="25" width="25" src="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-down.png" 
                                    data-status = "closed"
                                    down="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-down.png"
                                    up="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-up.png" />
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="pt-2 px-2 pb-4 questionnaire collapse" id="questionnaire-writing">
                <?php gravity_form( 8, $display_title = false, $display_description = true, $ajax = true, $tabindex, $echo = true );?>
                </div>
            <?php endif ?>

        </div>

        <!-- if( get_field('type', $user) == 'Media' ): -->
            
    </div>
    
</div>