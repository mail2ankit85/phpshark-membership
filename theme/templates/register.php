<?php
/**
* Template Name: Register Page
*
* @package WordPress
* @subpackage fixopr
*/

$ind = null;
if($_POST ){
    $ind = phpshark_membership_register_perform($_POST);
}

get_header();

    $template = new phpshark_twig_template();
    echo $template->phpshark_template_render('register.html', [
        'ind' => $ind,
        'resend_url' => site_url('confirmation/resend')
    ]);


get_footer();
