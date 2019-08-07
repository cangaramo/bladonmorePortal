<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-102304743-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-102304743-3');
    </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KCJXW75');</script>
    <!-- End Google Tag Manager -->


    <title><?php wp_title(); ?></title>

    <?php wp_head();?>
</head>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KCJXW75"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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

    //Hide menu in login
    if (is_page("Login")) {
        $style = "d-none";
    }
?>
<header class="<?php echo $style ?>">
    <div style="position:relative">
        <div class="w-100 alert m-0 alert-confirmation" role="alert">
            <div class="h-100 d-flex align-items-center">
                <span>This sessions has been approved. The details will now be shared with your delegates.</span>
                
            </div>
        </div>
    </div>
<!--header-->
    <div class="d-block d-lg-none container small-padding">
        <nav class="navbar navbar-expand-lg  p-0 pt-3 pb-3">

            <a href="<?php echo home_url(); ?>"><img style="height:20px" src="<?php echo get_bloginfo('template_directory'); ?>/images/black-logo.png"></a>

            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar top-bar"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>	
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav w-100 d-flex justify-content-end">

                    <ul class="p-0 pt-3">


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

                        $dropdown = false;
                        foreach ($menuitems as $menusubitem):
                            $parentsubitem = $menusubitem->menu_item_parent;
                            if ($parentsubitem == $id ):
                                $dropdown = true;
                            endif; 
                        endforeach; 

                        //Current page
                        $post_type = get_post_type();

                        if ($post_type == 'agendas'){
                            $page = 'Agenda';
                        }
                        else if ($post_type == 'feedback'){
                            $page = 'Feedback';
                        }
                        else if ($post_type == 'videos'){
                            $page = 'Videos';
                        }
                        else {
                            $page =  get_the_title();
                        }

                        //Questionnaire
                        $user_id = 'user_'. get_current_user_id() ;
                        $hide_questionnaire = get_field("hide_questionnaire", $user_id);
                        
                        if ( $title == 'Fill in Questionnaire' && $hide_questionnaire ): ?>
                            <li class="link d-none">
                                <i class="fas fa-square-full"></i>
                                <a class="nav-item nav-link" href="<?php echo $url?>"><?php echo $title ?></a>
                            </li>
                        <?php elseif ($dropdown) : ?>
                            <li class="title d-none d-lg-block">
                                <a class="nav-item nav-link" href="<?php echo $url?>"><?php echo $title ?></a>
                            </li>
                        <?php elseif ($page == $title): ?>
                            <li class="link">
                                <i class="fas fa-square-full"></i>
                                <a class="nav-item nav-link active" href="<?php echo $url?>"><?php echo $title ?></a>
                            </li>
                        <?php else: ?>
                            <li class="link">
                                <i class="fas fa-square-full"></i>
                                <a class="nav-item nav-link" href="<?php echo $url?>"><?php echo $title ?></a>
                            </li>
                        <?php endif;
                    ?>
                        

                    <?php endforeach ?>

                    </ul>
                    
                </div>
            </div>

        </nav>

    </div>

</header>
    
