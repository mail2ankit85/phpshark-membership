<?php

if ( is_user_logged_in() ) {
    // your code for logged in user 
    wp_logout();
    wp_safe_redirect(site_url('login'));
    exit;
 } 