<?php 
/**
* Template Name: Confirmation Resend Page
*
* @package WordPress
* @subpackage fixopr
*/

$ind = null;
if($_POST){
    $email = sanitize_text_field( $_POST['email'] );
    $result = phpshark_membership_confirmation_resend($_POST);
    if ($result->valid) {
        $ind = true;
    } else {
        $ind = false;
    }
}

get_header(); 

    $template = new phpshark_twig_template();
    echo $template->phpshark_template_render('confirmation-resend.html', [
        'ind' => $ind,
        'forgot_url' => site_url('password/forgot')
    ]);

get_footer();