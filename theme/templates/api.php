<?php 
/**
* Template Name: API source Page
*
* @package WordPress
* @subpackage fixopr
*/

if(isset($_GET['source'])):
    $source = $_GET['source'];
    switch($source){
        case 'check-email-id':
                echo json_encode(phpshark_membership_check_user_membership($_POST));
                break;
        case 'get-required-field':
                echo json_encode(phpshark_membership_get_required_fields($_POST));
                break;
        case 'check-username':
                echo json_encode(phpshark_membership_check_username($_POST));
                break;
        case 'resend-confirmation-link':
                echo json_encode(phpshark_membership_confirmation_resend($_POST));
                break;
        case 'subscribe':
                echo json_encode(phpshark_membership_should_subscribe($_POST));
                break;
        case 'drop-field-posts':
                echo json_encode(phpshark_membership_get_drop_field_source());
                break;
    }
else:
    get_header();
?>
<div class="container my-5" id="main-content">
    <main id="main" class="site-main" role="main">

        <?php 
            get_template_part( 'template-parts/content','none' );
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php 
    get_footer();
    endif;
?>



