<?php 
/**
* Template Name: Forgot Password Page
*
* @package WordPress
* @subpackage fixopr
*/

$ind = null;
if(!empty($_POST)){
    $usr = wp_get_current_user();
    if( wp_check_password( $_POST['old-password'], $usr->data->user_pass, $usr->ID ) ){
        if( $_POST['password'] !== $_POST['repeat-password'] ){
            $ind = false;
        }else{
            reset_password( $usr, $_POST['password'] );
        }
        $ind = true;
    }else{
        $ind = false;
    }
}
get_header(); 

    $template = new phpshark_twig_template();
    echo $template->phpshark_template_render('password-change.html', [
        'ind' => $ind,
        'logged' => is_user_logged_in(),
        'base' => site_url(),
    ]);

get_footer();

