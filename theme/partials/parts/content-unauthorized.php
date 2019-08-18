<section class="no-results not-found d-flex flex-column align-items-center">
	<header class="page-header d-flex flex-column align-items-center">
		<h4 class="page-title">
		<?php esc_html_e( 'You are not authorized to access this page!', 'fixopr-theme' ); ?>
		</h4>
	</header><!-- .page-header -->

	<div class="page-content d-flex flex-column align-items-center">
        <img class="mb-5" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4Igp3aWR0aD0iNjQiIGhlaWdodD0iNjQiCnZpZXdCb3g9IjAgMCAxMjggMTI4IgpzdHlsZT0iIGZpbGw6IzAwMDAwMDsiPjxwYXRoIGZpbGw9IiNFOTc4NjciIGQ9Ik02NCAxNi4yOTk5OTk5OTk5OTk5OTdBNDIgNDIgMCAxIDAgNjQgMTAwLjNBNDIgNDIgMCAxIDAgNjQgMTYuMjk5OTk5OTk5OTk5OTk3WiI+PC9wYXRoPjxwYXRoIGZpbGw9IiNGRkYiIGQ9Ik02NCAxNi4yOTk5OTk5OTk5OTk5OTdBNDIgNDIgMCAxIDAgNjQgMTAwLjNBNDIgNDIgMCAxIDAgNjQgMTYuMjk5OTk5OTk5OTk5OTk3WiI+PC9wYXRoPjxwYXRoIGZpbGw9IiNGMzc3NzgiIGQ9Ik02NCAyNi43OTk5OTk5OTk5OTk5OTdBMzEuNSAzMS41IDAgMSAwIDY0IDg5LjhBMzEuNSAzMS41IDAgMSAwIDY0IDI2Ljc5OTk5OTk5OTk5OTk5N1oiPjwvcGF0aD48cGF0aCBmaWxsPSIjNDU0QjU0IiBkPSJNNjQsMTAzLjNjLTI0LjgsMC00NS0yMC4yLTQ1LTQ1czIwLjItNDUsNDUtNDVjMjQuOCwwLDQ1LDIwLjIsNDUsNDVTODguOCwxMDMuMyw2NCwxMDMuM3ogTTY0LDE5LjNjLTIxLjUsMC0zOSwxNy41LTM5LDM5czE3LjUsMzksMzksMzlzMzktMTcuNSwzOS0zOVM4NS41LDE5LjMsNjQsMTkuM3oiPjwvcGF0aD48cGF0aCBmaWxsPSIjRkZGIiBkPSJNODAuNyw2My4zSDQ3LjNjLTIuOCwwLTUtMi4yLTUtNXMyLjItNSw1LTVoMzMuNGMyLjgsMCw1LDIuMiw1LDVTODMuNSw2My4zLDgwLjcsNjMuM3oiPjwvcGF0aD48Zz48cGF0aCBmaWxsPSIjNDU0QjU0IiBkPSJNNjQsMTIyLjVjLTEuNywwLTMtMS4zLTMtM3YtMTkuMmMwLTEuNywxLjMtMywzLTNjMS43LDAsMywxLjMsMywzdjE5LjJDNjcsMTIxLjIsNjUuNywxMjIuNSw2NCwxMjIuNXoiPjwvcGF0aD48L2c+PC9zdmc+">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'fixopr-theme' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fixopr-theme' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fixopr-theme' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
