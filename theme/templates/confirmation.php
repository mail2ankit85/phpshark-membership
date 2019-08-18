<?php 
/**
* Template Name: Account Page
*
* @package WordPress
* @subpackage fixopr
*/

$ind = null;

if($_GET && $_GET['con'] == "true"):
    
    $email = $_GET['email'];
    $key = $_GET['key'];

    phpshark_membership_confirm_user($email,$key);
    if( $_POST && $_POST['password'] === $_POST['repeat-password'] ){
        if( !phpshark_membership_insert_user($_POST, $email) ){
            $ind = false;
        }else{
            $ind = true;
            wp_safe_redirect(site_url('login'));
        }
    }
endif;

get_header(); 

    $template = new phpshark_twig_template();
    echo $template->phpshark_template_render('confirmation.html', [
        'ind' => $ind
    ]);

get_footer();