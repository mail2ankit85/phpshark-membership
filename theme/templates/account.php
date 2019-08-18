<?php 
/**
* Template Name: Account Page
*
* @package    Phpshark_Membership
* @subpackage Phpshark_Membership/Theme
*/
 
$ind = null;
if(!empty($_POST) && $_POST['form'] === 'login'){
    phpshark_membership_login_perform($_POST);
}

if(!empty($_POST) && $_POST['form'] === 'register'){
    $ind = phpshark_membership_register_perform($_POST);
}

get_header(); 

$template = new phpshark_twig_template();
echo $template->phpshark_template_render('account.html', [
    'ind' => $ind
]);

get_footer();