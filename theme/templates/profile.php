<?php 
/**
* Template Name: Profile Page
*
* @package WordPress
* @subpackage fixopr
*/

if(! current_user_can('administrator') ){
    get_admin_template_part('access','denied');
    exit;
}

/* Get user info. */
global $current_user, $wp_roles;
/* Load the registration file. */
//require_once( ABSPATH . WPINC . '/registration.php' ); //deprecated since 3.1
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
    /* Update user information. */
    if ( !empty( $_POST['url'] ) )
        wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );
    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
        elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->ID )
            $error[] = __('This email is already used by another user.  try a different one.', 'profile');
        else{
            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
        }
    }

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['description'] ) )
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );

    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        // do_action('edit_user_profile_update', $current_user->ID);
        // wp_redirect( get_permalink() );
        // exit;
        wp_safe_redirect(site_url('member/profile'));
    }
}

get_header(); 
?>

<div id="primary" class="content-area">
		<main id="main" class="site-main">

        <div class="container mb-5">

        <div class="row"> 
            <?php 
                if ( is_user_logged_in() ) : ?>
                    <div class="col-md-3 mb-5">
                        <?php 
                            // your code for logged in user
                            get_admin_template_part('structure','menu');
                        ?>
                    </div>
                    <div class="col-md-9">
                            <div class="entry-content entry">
                                <?php if ( !is_user_logged_in() ) : ?>
                                        <p class="warning">
                                            <?php _e('You must be logged in to edit your profile.', 'profile'); ?>
                                        </p><!-- .warning -->
                                <?php else : ?>
                                    <?php if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>
                                    <form method="post" id="profile-form" action="<?php the_permalink(); ?>">
                                        <div class="form-username form-group">
                                            <label for="first-name" class="form-label"><?php _e('First Name', 'profile'); ?></label>
                                            <input class="text-input form-control" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                                        </div><!-- .form-username -->

                                        <div class="form-username form-group">
                                            <label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
                                            <input class="text-input form-control" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                                        </div><!-- .form-username --> 

                                        <div class="form-email form-group">
                                            <label for="email" class="form-label"><?php _e('E-mail *', 'profile'); ?></label>
                                            <input class="text-input form-control" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" disabled />
                                        </div><!-- .form-email -->

                                        <div class="form-url form-group">
                                            <label for="url" class="form-label"><?php _e('Website', 'profile'); ?></label>
                                            <input class="text-input form-control" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
                                        </div><!-- .form-url -->

                                        <div class="form-textarea form-group">
                                            <label for="description"><?php _e('Biographical Information', 'profile') ?></label>
                                            <textarea class="form-control" name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
                                        </div><!-- .form-textarea -->
                    
                                        <?php 
                                            //action hook for plugin and extra fields
                                            // do_action('edit_user_profile',$current_user); 
                                        ?>
                                        
                                        <p class="form-submit">
                                            <input name="updateuser" type="submit" id="updateuser" class="btn btn-primary mt-5 submit button" value="<?php _e('Update', 'profile'); ?>" />
                                            <?php wp_nonce_field( 'update-user' ) ?>
                                            <input name="action" type="hidden" id="action" value="update-user" />
                                        </p><!-- .form-submit -->
                                    </form><!-- #adduser -->
                                <?php endif; ?>
                            </div><!-- .entry-content -->
                        </div><!-- .hentry .post -->
                <div>                
            <?php else : ?>
                <div class="row"> 
                    <div class="col-md-12">
                        <?php 
                            // your code for logged out user 
                        get_admin_template_part('content','unauthorized');
                        ?>
                    </div>
                </div>
            <?php endif; ?>


            </div>
        </div>
        </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer() ?>