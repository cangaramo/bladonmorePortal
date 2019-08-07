<?php ?>
    <footer>
    
      <div class="container small-padding pt-5 pb-5">

         <div class="row">

            <div class="col-12 col-lg-6 color:white">

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
            <div class="col-12 col-lg-6">
               <div class="float-left float-lg-right d-block pt-4 pt-lg-0">
                  <img style="height:38px" src="<?php echo get_bloginfo('template_directory'); ?>/images/BM_logo.png">
               </div>
            </div>
            
         </div>

       

      </div>

    </footer>

    <?php wp_footer(); ?>
    
</body>
</html>
