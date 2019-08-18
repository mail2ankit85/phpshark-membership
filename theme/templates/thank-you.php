<?php
/**
* Template Name: Thank You Page
*
* @package WordPress
* @subpackage fixopr
*/
    get_header();

    $card_heading = getAdminSettingsOption(
        'app\admin\Pages',
        'thank-you',
        'card_heading',
        'Thank you for visiting'
    );

    $card_body = getAdminSettingsOption(
        'app\admin\Pages',
        'thank-you',
        'card_body',
        'Hope to see you back very soon!
        I hope you find my content informative.
        Please care to leave a feed back sometimes'
    );
?>

<div id="primary" class="content-area">
		<main id="main" class="site-main">

        <div class="container mb-5">
            <div class="card">
                <div class="card-heading">
                    <h5><?php echo $card_heading; ?></h5>
                </div>
                <div class="card-body">
                    <p class="lead"><?php echo $card_body; ?></p>
                </div>
            </div>
        </div>

        </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer() ?>
