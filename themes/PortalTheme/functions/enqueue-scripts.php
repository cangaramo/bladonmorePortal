<?php
function enqueue_theme_scripts() {

//CSS

wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/fontawesome/css/all.css');
wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
wp_enqueue_style( 'main', get_template_directory_uri() . '/style.css', '', '1.19');
wp_enqueue_style( 'typekit', 'https://use.typekit.net/rxd1qvx.css');
wp_enqueue_style( 'cookie-consent', '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css'); 
wp_enqueue_style( 'font-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700');


//JS

wp_deregister_script( 'jquery' );
wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js');
wp_register_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery'));
wp_register_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'));
wp_register_script('custom-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.1');
wp_register_script('status-js', get_template_directory_uri() . '/js/status.js', array('jquery'), '1.1');

wp_register_script('cookie-js','//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js', array('jquery'));

wp_enqueue_script('jquery');
wp_enqueue_script('popper-js');
wp_enqueue_script('bootstrap-js');
wp_enqueue_script('custom-js');
wp_enqueue_script('cookie-js');


}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );

?>