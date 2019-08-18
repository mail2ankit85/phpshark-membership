<?php
global $pages;


$pages = [
    'unsubscribe' => 'unsubscribe',
    'login'=> 'login',
    'register' => 'register',
    'confirmation' => 'confirmation',
    'forgot-password' => 'forgot-password',
    'profile' => 'profile',
    'notification' => 'notification',
    'api' => 'api',
    'thanks' => 'thank-you',
    'account' => 'account',
    'logout'  => 'logout',
    'reset' => 'reset',
    'member-reset' => 'member-reset',
    'confirmation-resend' => 'confirmation-resend',
    /**
     * START OF CUSTOMER SECTION
     */
    'admin' => 'admin-area',
    'respond' => 'response',
    'ask' => 'ask-me',
    'member-subscription' => 'subscription',
    'password-change' => 'password-change'
];

function getRoutingURLs(){
    global $pages;
    $url_path =  phpshark_domain();
    $url_path .= trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');

    switch($url_path){
        case site_url('membership/api'):
            phpshark_membership_plugin_get_page('api');
            break;
        case site_url('unsubscribe'):
            phpshark_membership_plugin_get_page('unsubscribe');
            break;
        case site_url('login'):
            phpshark_membership_plugin_get_page('login');
            break;
        case site_url('register'):
            phpshark_membership_plugin_get_page('register');
            break;
        case site_url('confirmation'):
            phpshark_membership_plugin_get_page('confirmation');
            break;
        case site_url('password/forgot'):
            phpshark_membership_plugin_get_page('forgot-password');
            break;
        case site_url('password/reset'):
            phpshark_membership_plugin_get_page('reset');
            break;
        case site_url('member/password/reset'):
            phpshark_membership_plugin_get_page('reset');
            break;
        case site_url('logout'):
            phpshark_membership_plugin_get_page('logout');
            break;
        case site_url('thanks'):
            phpshark_membership_plugin_get_page('thanks');
            break;
        case site_url('member/profile'):
            phpshark_membership_plugin_get_page('profile');
            break;
        case site_url('account'):
            phpshark_membership_plugin_get_page('account');
            break;
        case site_url('member/admin'):
            phpshark_membership_plugin_get_page('admin');
            break;
        case site_url('confirmation/resend'):
            phpshark_membership_plugin_get_page('confirmation-resend');
            break;
        /**
         * START OF CUSTOMER SECTION
         */
        case site_url('respond/query'):
            phpshark_membership_plugin_get_page('respond');
            break;
        case site_url('send/query'):
            phpshark_membership_plugin_get_page('ask');
            break;
        case site_url('member/subscribe'):
            phpshark_membership_plugin_get_page('member-subscription');
            break;
        case site_url('member/password/change'):
            phpshark_membership_plugin_get_page('password-change');
            break;
        /**
         * END OF CUSTOMER SECTION
         */
        default:
            return;
    }
}

// Add your templates to this array.
$this->templates = [
    'unsubscribe.php' => 'Unsubscribe Page [Membership-Plugin]',
    'login.php' => 'Login Page [Membership-Plugin]',
    'register.php' => 'Register Page [Membership-Plugin]',
    'admin-area.php' => 'Admin Area [Membership-Plugin]',
    'confirmation.php' => 'Confirmation Page [Membership-Plugin]',
    'forgot-password.php' => 'Forgot Password Page [Membership-Plugin]',
    'profile.php' => 'Profile Page [Membership-Plugin]',
    'api.php' => 'API source Page [Membership-Plugin]',
    'thank-you.php' => 'Thank You Page [Membership-Plugin]',
    'account.php' => 'Acccount Access Page [Membership-Plugin]',
    'logout.php' => 'Logout Page [Membership-Plugin]',
    'reset.php' => 'Reset Page [Membership-Plugin]',
    'confirmation-resend.php' => 'Confirmation Resent Page [Membership-Plugin]',

    /***
     * Add your customization and other admin pages here
     * and assign them to the front end.
     */
    'ask-me.php' => 'Contact Page [Membership-Plugin]',
    'subscription.php' => 'Subscription Page [Membership-Plugin]',
    'password-change.php' => 'Password Change Page [Membership-Plugin]',
];
