<?php
    $key = '';
    $email = '';
    $user_data = array();
    $invalid = null;
    $ind = null;

    if($_GET){
        if( is_user_logged_in() ){
            wp_destroy_current_session();
        }

        if($_GET['action'] == 'rp'):
            $key = $_GET['key'];
            $login = $_GET['login'];
        endif;

        if( get_user_by( 'email', $login )){
            $user_data = get_user_by( 'email', $login );
        }else{
            $user_data = get_user_by( 'login', $login );
        }

        if( !empty($user_data) ){
            if(phpshark_membership_check_reset_key_isvalid(
                $user_data->user_email,
                $user_data->user_activation_key)){
                $invalid = false;
            }else{
                $invalid = true;
            }
        }

        if( $_POST && ( $_POST['password'] === $_POST['repeat-password'] ) ){
            reset_password( $user_data, $_POST['password'] );
            wp_safe_redirect(site_url('login'));
            exit;
        }
    }

    $error_msg = getAdminSettingsOption(
        'app\admin\Pages',
        'reset',
        'error_msg',
        '<strong>Error!</strong> The Repeat Password does not seem to match!.'
    );

    $success_msg = getAdminSettingsOption(
        'app\admin\Pages',
        'thank-you',
        'success_msg',
        '<strong>Info!</strong> Good work.'
    );

get_header();
?>

<div id="primary" class="content-area">
		<main id="main" class="site-main">

        <div class="container mb-5">
            <div class="row card p-5">

                <div class="col-md-8 offset-md-2">


                <?php if($ind !== null && $ind === false): ?>

                    <div class="p-3">

                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo $error_msg;  ?>
                        </div>

                    </div>

                <?php endif; ?>

                <?php if ( $invalid !== null && $invalid === false ): ?>


                    <div class="form-heading my-3 p-2">
                        <h3 class="d-flex justify-content-center">Set Password</h3>
                        <h6 class="d-flex justify-content-center">Set a new password for your account</h6>
                    </div>

                    <hr/>

                    <?php get_admin_template_part('form','reset-1'); ?>

                <?php else: ?>

                    <?php get_template_part('template-parts/content','none'); ?>

                <?php endif; ?>

                </div>

            </div><!-- #row -->
        </div><!-- #container -->

        </main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
