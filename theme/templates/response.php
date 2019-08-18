<?php 
/**
* Template Name: Response Page
*
* @package WordPress
* @subpackage fixopr
*/

if(! current_user_can('administrator') ){
    get_admin_template_part('access','denied');
    exit;
}

$error = '';
$post = '';
if( !empty($_GET) && isset($_GET['question']) && $_GET['question'] !== '' ){
    $id = (int)$_GET['question'];
    $post = phpshark_membership_get_user_queries($id);
    $post = $post[0];

    if(!empty($_POST)){
        if(phpshark_membership_update_response($_POST)):
            if ( wp_safe_redirect( site_url('member/admin') ) ) {
                exit;
            };
        else:
            $error = 'X';
        endif; 
    }
}else{
    $error = 'X';
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
                        <?php if($error == 'X'): ?> 
                            <div class="row">
                                <div class="col-md-12 d-flex flex-column">
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Error!</strong> Something went wrong on this message. Please go back and try again. 
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form id="contact-form" class="card p-5 my-5" method="post">
                            <input class="d-none" name="msg_ID" value="<?php echo $post->msg_ID ?>" />

                            <div class="form-row">
                                <div class="form-group col-md-8 offset-md-2">
                                    <label for="select-post-field">Subject<span class="mandatory">*</span>:</label>
                                    <input id="select-post-field" class="form-control" name="subject_text"
                                    value="<?php if(isset($post->subject_text)){echo nl2br($post->subject_text);}?>"/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-8 offset-md-2">
                                    <label for="description">Description<span class="mandatory">*</span>:</label>
<textarea class="form-control" rows="10" name="description">
<?php if(isset($post->description)){echo nl2br($post->description);}?>
</textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-8 offset-md-2">
                                    <label for="response">Response<span class="mandatory">*</span>:</label>
<textarea class="form-control" rows="10" name="response">
<?php if(isset($post->response)){echo nl2br($post->response);}?>
</textarea>
                                </div>
                            </div>

                            <div class="form-row mt-5">
                                <div class="form-group col-md-12 d-flex justify-content-center">
                                    <button class="btn btn-primary">Respond</button>
                                </div>
                            </div>  
                        </form>
                    </div>
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