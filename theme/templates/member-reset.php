<?php 
$key = '';
$email = '';

if($_GET){
    if( is_user_logged_in() ){
        wp_destroy_current_session();
    }

    if($_GET['action'] == 'rp'):
        $key = $_GET['key'];
        $login = $_GET['login'];
    endif;
}

get_header();





get_footer();