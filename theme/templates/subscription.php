<?php 
/**
* Template Name: Subscription Page
*
* @package WordPress
* @subpackage fixopr
*/
$usr = wp_get_current_user();
if(!empty($_POST)){
    if( isset( $_POST['subscribe'] ) ){
        phpshark_membership_subscribe_by_config($_POST);
    }else{
        phpshark_membership_unsubscribe_config($_POST);
    }
}
$status = phpshark_membership_get_subscription_status($usr->user_email);

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
                        <form id="member-subscription-form" method="post" action=""> 
                            <div class="card">
                                <input class="d-none" type="email" name="email" value="<?php echo $usr->user_email;  ?>"/>

                                <div class="form-row mt-3">
                                    <div class="form-group col-md-6 offset-md-3 d-flex justify-content-center">
                                        <label for="description">
                                            <input type="checkbox" class="form-check-input" name="subscribe" 
                                            <?php if($status === true){echo 'checked';}?>>Subscribe to newsletters<span classs="mandatory">*</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-row mt-5">
                                    <div class="form-group col-md-6 offset-md-3 d-flex justify-content-center">
                                        <button class="btn btn-primary" >Update</button>
                                    </div>
                                </div>  
                            </div>
                        </form>
                    </div>
            <?php else: ?>

            <div class="row"> 
                <div class="col-md-12">
                    <?php  get_admin_template_part('content','unauthorized'); ?>
                </div>
            </div>
        
            <?php endif; ?>

        </div>

        </div>

        </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer() ?>