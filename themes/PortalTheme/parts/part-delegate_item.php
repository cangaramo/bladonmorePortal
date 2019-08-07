<div class="list-item row">
    
    <div class="col-3 col-lg-1 p-0">
        <?php if ( !empty($initials) ): ?>
            <div class="avatar d-flex align-items-center justify-content-center">
                 <span><?php echo $initials ?> </span>
            </div>
         <?php endif; ?>
    </div>

    <div class="col-8 col-lg-10 p-0">
        <div class="h-100 d-flex align-items-center">
            <?php echo $first_name . " " . $last_name ?>
        </div>
    </div>

    <div class="col-1 col-lg-1 p-0">
        <div class="h-100 d-flex align-items-center">
            <img height="25" width="25" src="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-down.png"
                down="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-down.png"
                up="<?php echo get_bloginfo('template_directory'); ?>/images/arrow-up.png" />
        </div>
    </div>

</div>