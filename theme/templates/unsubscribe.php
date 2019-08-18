<?php
$msg = getAdminSettingsOption(
    'app\admin\Pages',
    'thank-you',
    'msg',
    'your email id has been unsubscribed!'
);

if( !empty($_GET) && isset($_GET['email']) ):
    phpshark_membership_unsubscribe($_GET);
    get_header();
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3 d-flex justify-content-center">
            <div class="card">
                <div class="card-body">
                    <p class="lead"><?php echo $msg; ?><p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
else:
    get_header();
    get_template_part('template-parts/content','none');
    get_footer();
endif;
