<?php ?>
    <footer>
    
        <div class="d-block d-lg-none">

            <div class="pt-3 d-flex text-center justify-content-center ">
                <a href="<?php echo home_url(); ?>"><img style="height:40px" src="<?php echo get_bloginfo('template_directory'); ?>/images/story-told.png"></a>
            </div>

            <?php 
            $user_id = get_current_user_id() ;
            $user_info = get_userdata($user_id);
            $last_name = $user_info->last_name;
            $first_name =  $user_info->first_name;
            $initials =  $first_name[0] . $last_name[0];

            if (  !empty($initials) ): ?>
                <div class="py-4 d-flex justify-content-center">
                    <div class="avatar d-flex justify-content-center align-items-center">
                        <span><?php echo $initials ?> </span>
                    </div>
                </div>

            <?php endif; ?>

            <div class="pb-3 d-flex flex-column text-center justify-content-center ">
                <?php
                $menu_name = 'footer'; 
                $locations = get_nav_menu_locations();
                $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
                $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

                foreach ($menuitems as $menuitem):
                    $parent = $menuitem->menu_item_parent;
                    $title = $menuitem->title;
                    $url = $menuitem->url;
                    $id = $menuitem->ID; ?>
                    
                    <a class="footer-link" href="<?php echo $url?>"><?php echo $title ?></a>

                <?php endforeach ?>
            </div>

        </div>

    </footer>

    <?php require('parts/modal-request_changes.php');  ?>
    <?php require('parts/modal-approve.php');  ?>

    <?php wp_footer(); ?>
    
</body>
</html>
