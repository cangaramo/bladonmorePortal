<?php 
    $user = wp_get_current_user();
    $user_role = (array) $user->roles; 
    $role = $user_role[0];

    if ($role == "client") {
        $style = "menu-client";
        $menu = "client";
    }
    else  {
        $style = "";
        $menu = "delegate";
    }
?>
<div class="sidebar w-100 h-100 <?php echo $style ?>" style="position: relative;">

    <div class="h-100 pt-5" style="position: fixed; width:25%">

        <a class="px-5" href="<?php echo home_url(); ?>"><img style="height:25px" src="<?php echo get_bloginfo('template_directory'); ?>/images/black-logo.png"></a>

        <nav class="mt-4">
            <ul class="p-0">
            <?php 
            $menu_name = $menu;
            $locations = get_nav_menu_locations();
            $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
            $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

            foreach ($menuitems as $menuitem):

                $parent = $menuitem->menu_item_parent;
                $title = $menuitem->title;
                $url = $menuitem->url;
                $id = $menuitem->ID; 
                $page_id = $menuitem->object_id; 

                $dropdown = false;
                $class = "";

                foreach ($menuitems as $menusubitem):
                    $parentsubitem = $menusubitem->menu_item_parent;
                    if ($parentsubitem == $id ):
                        $dropdown = true;
                    endif; 
                endforeach; 

                /* Parent and children */
                if ($dropdown): ?>  

                    <div class="my-3">
                        <li class="title pl-5"><?php echo $title ?></li>

                        <?php 
                        foreach ($menuitems as $menusubitem):
                            $parentsubitem = $menusubitem->menu_item_parent;
                            $titlesubitem = $menusubitem->title;
                            $urlsubitem = $menusubitem->url;
                            $idsubitem = $menusubitem->object_id;
                            $page_id = $menusubitem->object_id; 
                                                        
                            if ($parentsubitem == $id ): 
                                
                                $current_page =  get_the_title();
                                $item_page = get_the_title($page_id);   
     
                                if ($item_page == $current_page) {
                                    $class = "active";
                                }
                                else {
                                    $class = "";
                                }

                                $user_id = 'user_'. get_current_user_id() ;
                                $hide_questionnaire = get_field("hide_questionnaire", $user_id);

                                if ($item_page == 'Questionnaire' && $hide_questionnaire):
                                    $class = $class . " d-none";
                                endif;
                            ?>

                                <li class="link pl-5 <?php echo $class ?> " >
                                    <i class="fas fa-square-full"></i>
                                    <a href="<?php echo $urlsubitem ?>"><?php echo $titlesubitem ?></a>
                                </li>
                            <?php endif; 

                          endforeach; ?>
                    </div>

                <?php 
                /* No parent */
                elseif ($parent == 0): 

                    $current_page =  get_the_title();
                    $item_page = get_the_title($page_id);   

                    if ($item_page == $current_page) {
                        $class = "active";
                    }
                    else {
                        $class = "";
                    }
                ?>

                    <li class="link pl-5 <?php echo $class ?>">
                        <i class="fas fa-square-full"></i>
                        <a href="<?php echo $url ?>"><?php echo $title ?></a>
                    </li>

                <?php endif; ?>

            <?php endforeach ; ?>

            </ul>
        </nav>

        <div class="footer-sidebar py-4 pl-5">

            <?php 
            $user_id = get_current_user_id() ;
            $user_info = get_userdata($user_id);
            $last_name = $user_info->last_name;
            $first_name =  $user_info->first_name;
            $initials =  $first_name[0] . $last_name[0];

            if (  !empty($initials) ): ?>
                <div class="avatar mb-3 d-flex align-items-center justify-content-center">
                    <span><?php echo $initials ?> </span>
                </div>

            <?php endif; ?>

            <div class="d-flex flex-column">
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


    </div>

</div>
<?php   ?>