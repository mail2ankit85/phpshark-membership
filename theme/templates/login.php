<?php 
/**
* Template Name: Login Page
*
* @package WordPress
* @subpackage fixopr
*/


if(!empty($_POST)){
    phpshark_membership_login_perform($_POST);
}

get_header(); 

    $template = new phpshark_twig_template();
    echo $template->phpshark_template_render('login.html', [
        'get' => $_GET, 
        'forgot_url' => site_url('password/forgot')
    ]);

get_footer();

