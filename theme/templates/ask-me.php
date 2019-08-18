<?php 
/**
* Template Name: Contact Page
*
* @package WordPress
* @subpackage fixopr
*/

if( current_user_can('administrator') ){
    get_admin_template_part('access','denied');
    exit;
}

$usr = wp_get_current_user();
if(!empty($_POST)){
    phpshark_membership_save_message_item($_POST);
    wp_safe_redirect(site_url('member/admin'));
    exit;
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

                    <form id="contact-form" class="card p-5 my-5" method="post">
                            <input type="email" name="email" class="d-none" value="<?php echo $usr->user_email; ?>" />
                        
                            <div class="form-row">
                                <div class="form-group col-md-8 offset-md-2">
                                    <label for="subject">Subject<span class="mandatory">*</span>:</label>
                                    <select id="subject" class="form-control" name="subject" 
                                    value="<?php if(isset($_POST['subject'])){echo $_POST['subject'];}?>" >
                                        <option value="post_comment">Post Comment</option>
                                        <option value="Question">Question & Answer</option>
                                        <option value="enquiry">Enquiry</option>
                                        <option value="submit-article">Submit Article</option>
                                        <option value="submit-article">Feedback & Sugesstions</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-8 offset-md-2">
                                    <label for="select-post-field">Post Reference<span class="mandatory">*</span>:</label>
                                    <input id="select-post-field" class="form-control" name="post"
                                    value="<?php if(isset($_POST['post'])){echo $_POST['post'];}?>"/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-8 offset-md-2">
                                    <label for="description">Description<span class="mandatory">*</span>:</label>
<textarea class="form-control" rows="10" name="description">
<?php if(isset($_POST['description'])){echo $_POST['description'];}?>
</textarea>
                                </div>
                            </div>

                            <div class="form-row mt-5">
                                <div class="form-group col-md-12 d-flex justify-content-center">
                                    <button class="btn btn-primary" >Send Query</button>
                                </div>
                            </div>  
                        </form>
                    </div>
                <?php else: ?>
                    <?php  get_admin_template_part('content','unauthorized'); ?>
                <?php endif; ?>
                </div>
            </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer() ?>