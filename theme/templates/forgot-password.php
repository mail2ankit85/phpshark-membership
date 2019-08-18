<?php 
/**
* Template Name: Forgot Password Page
*
* @package WordPress
* @subpackage fixopr
*/

$ind = null;
if($_POST){
    $user_login = sanitize_text_field( $_POST['username-email'] );
    if (phpshark_membership_retrieve_password($user_login)) {
        $ind = true;
    } else {
        $ind = false;
    }
}

get_header(); 

    $template = new phpshark_twig_template();
    echo $template->phpshark_template_render('forgot.html', [
        'ind' => $ind
    ]);

get_footer();