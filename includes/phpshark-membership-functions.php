<?php 
global $partials;
global $parts;
$partials = PHPS_PLUGBASE.PHPS_THEME.PHPS_PARTIALS;
$parts = PHPS_PLUGBASE.PHPS_THEME.PHPS_PARTIALS.PHPS_PARTS;

function load_page($slug){
    global $partials;
    $template_file = $partials.$slug.'.php';
    if(file_exists($template_file)){
        load_template( $template_file );
    }else{
        return;
    }
}

function load_part($name, $slug = null){
    global $parts;
    if($slug !== null){
        $template_file = $parts.$name."-{$slug}.php";
    }else{
        $template_file = $parts.$name.".php";
    }

    if(file_exists($template_file)){
        include_once($template_file);
    }else{
        return;
    }
}

function phpshark_membership_plugin_get_page($name){
    global $pages;
    $public_src = PHPS_PLUGBASE . PHPS_THEME . PHPS_TEMPLATES;
    if(isset($pages[$name]) == true && file_exists($public_src.$pages[$name].'.php')){
            include_once $public_src.$pages[$name].'.php';
            exit; 
    }else{
        return;
    }
}

function get_admin_header($slug = 'header'){
    load_page($slug);
    return;
}

function get_admin_footer($slug = 'footer'){
    load_page($slug);
    return;
}

function get_admin_sidebar($slug = 'sidebar'){
    load_page($slug);
    return;
}

function get_admin_404($slug = '404'){
    load_page($slug);
    return;
}

function get_admin_template_part($name, $slug = null){
    load_part($name,$slug);
    return;
}

//Save Msg Header
function phpshark_membership_save_message_header($array){
    //Check if user exist in wpml_msg_header.
    global $wpdb;
    $query1 = "SELECT * FROM {$wpdb->prefix}msg_header WHERE email = %s";
    
    $r_exist = $wpdb->get_results($wpdb->prepare($query1, $array['email']));

    if(count($r_exist) < 1){
        // $token =  wp_generate_password();
        $token = phpshark_hashToken();

        $table = "{$wpdb->prefix}msg_header";
        $data = [
            "email"=>$array['email'], 
            "firstname"=>$array['firstname'], 
            "lastname"=>$array['lastname'],
            "phone"=>$array['phone'],
            "token"=>$token,
        ];
        $format = ['%s', '%s', '%s', '%s', '%s'];
        phpshark_membership_message_send_confirmation_mail($array, $token);
        $wpdb->insert($table,$data,$format);	
        return true;
    }else{
        return false;
    }
}

//Save Msg item
function phpshark_membership_save_message_item($array){
    //if member information exit but not confirmed 
    global $wpdb;
    $post = $array['post'];
    $subject = $array['subject'];
    $email = $array['email'];
    $description = $array['description'];

    $subject_txt = "[{$subject}]: {$post}";
    $table = "{$wpdb->prefix}msg_item";
    $data = [
        "email"=>$email, 
        "subject_text"=>$subject_txt, 
        "description"=>$description,
    ];
    $format = ['%s', '%s', '%s'];
    return $wpdb->insert($table,$data,$format);
}

function phpshark_membership_update_response($data){
    //if member information exit but not confirmed 
    global $wpdb;
    $id = (int)$data['msg_ID'];
    $table = "{$wpdb->prefix}msg_item";
    $data  =  [
        "response"=> $data['response'],
        "description" => $data['description']
    ];
    $where = [
        'msg_ID' => $id,
    ];
    $format = null;
    $where_format = ['%d'];
    $wpdb->update($table,$data,$where,$format,$where_format);
    return true;
}

//Remove Token from the user
function phpshark_membership_remove_token_from_user($email){
    global $wpdb;
    $table = "{$wpdb->prefix}msg_header";
    $data  =  [
        "token"=>''
    ];
    $where = [
        'email' => $email,
    ];
    $format = null;
    $where_format = ['%s'];
    $wpdb->update($table,$data,$where,$format,$where_format);
    return true;
} 

//Confirm User
function phpshark_membership_confirm_add_confirmation_check($email){
    global $wpdb;
    $table = "{$wpdb->prefix}msg_header";
    $data  =  [
        "confirmed"=>'X'
    ];
    $where = [
        'email'=> $email,
    ];
    $format = null;
    $where_format = ['%s'];
    $wpdb->update($table,$data,$where,$format,$where_format);
    return true;
}

function phpshark_membership_check_user_membership($data){
    //if member information exit but not confirmed 
    $result = new stdClass(); 
    global $wpdb;
    $query1 = "SELECT * FROM {$wpdb->prefix}msg_header WHERE email = %s";
    $r_exist = $wpdb->get_results($wpdb->prepare($query1,$data['email']));
    if(count($r_exist) > 0){
        $result->valid = false;
    }else{
        $result->valid = true;
    }
    return $result;
}

function phpshark_membership_message_send_confirmation_mail($data, $token){
    //Send Mail to my ID
    $to = $data['email'] ;
    $token = $token;

    $subject =  "[CONFIRMATION REQUIRED]: Welcome to The Northern Rhino IT Blog!";  
    $message  =  "Please click on the confirmation ";
    $message .= "<a href='https://thenorthernrhino.in/confirmation?con=true&&email={$to}&&token={$token}'>link</a> "; 
    $message .= "You are just a click away and we can have some awesome tech discussions right here!"; 
    $message .= "<br/>"; 
    $message .= "<br/>";  	
    $message .= "<br/>"; 
    $message .= "Regards,<br/>";
    $message .= "Ankit Kumar";  
    phpshark_membership_send_mail($to, $subject, $message);
}

function phpshark_membership_confirm_user($email,$token){
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}msg_header WHERE email = %s AND token = %s";
    $r_confirm = $wpdb->get_results($wpdb->prepare($query, $email, $token));
    if(count($r_confirm) > 0){
        phpshark_membership_confirm_add_confirmation_check($email);
        phpshark_membership_remove_token_from_user($email);
        return true;
    }else{
        return false;
    }
}

function phpshark_membership_send_contact_notification($data){
    $subject = $data['subject'];
    $post = $data['post'];
    $description = $data['description'];
    $email = $data['email'];

    //Send Mail to my ID
    $to = 'mail2ankit85@gmail.com' ;
    $subject =  "[{$subject}]: {$post}";  
    $message =  $description; 
    $message .=  '<br/>'; 
    $message .=  '<br/>'; 
    $message .=  $email;
    phpshark_membership_send_mail($to, $subject, $message);
}

function phpshark_membership_send_mail($to, $subject, $message, $headers = '', $attachments = []){
    wp_mail($to, $subject, $message, $headers, $attachments);
}

/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 * @param string $user_login User Login or Email
 * @return bool true on success false on error
 */
function phpshark_membership_retrieve_password($user_login) {
    global $wpdb, $current_site;

    if ( empty( $user_login) ) {
        return false;
    } else if ( strpos( $user_login, '@' ) ) {
        $user_data = get_user_by( 'email', trim( $user_login ) );
        if ( empty( $user_data ) )
           return false;
    } else {
        $login = trim($user_login);
        $user_data = get_user_by('login', $login);
    }

    do_action('lostpassword_post');

    if ( !$user_data ) return false;

    // redefining user_login ensures we return the right case in the email
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;

    do_action('retreive_password', $user_login);  // Misspelled and deprecated
    do_action('retrieve_password', $user_login);

    $allow = apply_filters('allow_password_reset', true, $user_data->ID);

    if ( ! $allow )
        return false;
    else if ( is_wp_error($allow) )
        return false;

    $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
    if ( empty($key) ) {
        // Generate something random for a key...
        $key = wp_generate_password(20, false);
        do_action('retrieve_password_key', $user_login, $key);
        // Now insert the new md5 key into the db
        $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
    }
    $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
    $message .= network_home_url( '/' ) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
    $message .= '<' . network_site_url("password/reset?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

    if ( is_multisite() )
        $blogname = $GLOBALS['current_site']->site_name;
    else
        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
        // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $title = sprintf( __('[%s] Password Reset'), $blogname );

    $title = apply_filters('retrieve_password_title', $title);
    $message = apply_filters('retrieve_password_message', $message, $key);

    if ( $message && !wp_mail($user_email, $title, $message) )
        wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') );

    return true;
}

function phpshark_membership_insert_user($data,$email){
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}msg_header WHERE email = %s AND confirmed = 'X'";
    $reg =  $wpdb->get_results($wpdb->prepare($query, $email));

    if(count($reg) > 0){
        $user_data = array(
            'ID' => '',
            'user_pass' => $data['password'],
            'user_login' => $data['username'],
            'user_nicename' => $reg[0]->firstname,
            'user_url' => '',
            'user_email' => $email,
            'display_name' => "{$reg[0]->firstname} {$reg[0]->lastname}",
            'nickname' => $reg[0]->firstname,
            'first_name' => $reg[0]->firstname,
            'last_name' => $reg[0]->lastname,
            'user_registered' => '2010-05-15 05:55:55',
            'role' => get_option('default_role') // Use default role or another role, e.g. 'editor'
        );
        $user_id = wp_insert_user( $user_data );
        if(is_wp_error($user_id)){
            return false;
        }else{
            return true;
        }
        return true;
    }else{
        return false;
    }
}

function phpshark_membership_check_reset_key_isvalid($email, $key){
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}users WHERE user_email = %s AND user_activation_key = %s";
    $result = $wpdb->get_results($wpdb->prepare($sql, $email, $key));
    if(count($result) > 0){
        return true;
    }else{
        return false;
    }
}

function phpshark_membership_check_username($data){
    $result = new stdClass();   
    if( !phpshark_membership_valid_email($data['username']) ){
        if( ! username_exists( $data['username'] ) ){
            $result->valid = false;
        }else{
            $result->valid = true;
        }
    }else{
        if( !email_exists( $data['username'] ) ){
            $result->valid = false;
        }else{
            $result->valid = true;
        }
    }
    return $result;
}

function phpshark_membership_valid_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function phpshark_membership_confirmation_resend($data){
    global $wpdb;
    $result = new stdClass(); 
    $sql = "SELECT * FROM {$wpdb->prefix}msg_header WHERE email = %s AND confirmed = ''";
    $db_result = $wpdb->get_results($wpdb->prepare($sql, $data['email']));
    if(count($db_result) > 0){
        $result->valid = true;
    }else{
        $result->valid = false;
    }
    return $result;
}

function phpshark_membership_login_check($redirect = 'login'){
    if( ! is_user_logged_in() ){
        wp_redirect(site_url($redirect));
        exit;
    }
}

function phpshark_membership_login_perform($data){
        //We shall SQL escape all inputs 
        $username = esc_sql($data['username']); 
        $password = esc_sql($data['password']); 

        $login_data = array(); 
        $login_data['user_login'] = $username; 
        $login_data['user_password'] = $password; 

        if(isset($_POST['rememberme'])){
            $remember = esc_sql($data['rememberme']); 
            if($remember) $remember = "true"; 
            else $remember = "false"; 
            $login_data['remember'] = $remember; 
        }

        $user_verify = wp_signon( $login_data ); 
        if ( !is_wp_error($user_verify) ) {         
            echo "<script type='text/javascript'>window.location.href='". home_url('member/admin') ."'</script>"; 
            exit(); 
        }
}

function phpshark_membership_register_perform($data){
    if( $data['email'] !== '' && $data['firstname'] && $data['lastname']){
        if(!phpshark_membership_save_message_header($data)){
            $ind = false;
        }else{
            $ind = true;
        }
    }else{
        $ind = false;
    }
    return $ind;
}

function phpshark_membership_subscribe($data){
    global $wpdb;
    $email = $data['subscription-email'];
    $table = "{$wpdb->prefix}subscription";
    $data = [
        "email"=>$email, 
    ];
    $format = ['%s'];
    return $wpdb->insert($table,$data,$format);
}

function phpshark_membership_subscribe_by_config($data){
    $data['subscription-email'] = $data['email'];
    phpshark_membership_subscribe($data);
}

function phpshark_membership_should_subscribe($data){
    global $wpdb;
    $result = new stdClass(); 
    $sql = "SELECT * FROM {$wpdb->prefix}subscription WHERE email = %s";
    $db_result = $wpdb->get_results($wpdb->prepare($sql, $data['subscription-email']));
    if(count($db_result) > 0){
        $result->valid = false;
    }else{
        $result->valid = true;
    }
    return $result;
}

function phpshark_membership_unsubscribe_config($data){
    $data['subscription-email'] = $data['email'];
    phpshark_membership_unsubscribe($data);
}

function phpshark_membership_unsubscribe($data){
    global $wpdb;
    $success = $wpdb->delete( "{$wpdb->prefix}subscription",
        array( 'email' => $data['subscription-email'] ),
        array( '%s' ) 
    );
}

function phpshark_membership_get_user_queries($id = null){
    global $wpdb;
    $db_result = null;
    $current_user = wp_get_current_user();
    if($id === null){
        if(current_user_can('administrator')){
            $sql = "SELECT * FROM {$wpdb->prefix}msg_item";
            $db_result = $wpdb->get_results($sql);
        }else{
            $sql = "SELECT * FROM {$wpdb->prefix}msg_item WHERE email = %s";
            $db_result = $wpdb->get_results($wpdb->prepare($sql, $current_user->user_email));
        }
    }else{
        $id = (int)$id;
        if(current_user_can('administrator')){
            $sql = "SELECT * FROM {$wpdb->prefix}msg_item WHERE msg_ID = %d";
            $db_result = $wpdb->get_results($wpdb->prepare($sql, $id));
        }else{
            $sql = "SELECT * FROM {$wpdb->prefix}msg_item WHERE email = %s AND msg_ID = %d";
            $db_result = $wpdb->get_results($wpdb->prepare($sql, $current_user->user_email,$id));
        }
    }
    return $db_result;
}

function phpshark_membership_get_subscription_status($email){
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}subscription WHERE email = %d";
    $db_result = $wpdb->get_results($wpdb->prepare($sql, $email));
    if(count($db_result) > 0){
        return true;
    }else{
        return false;
    }
}
