<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pixafy
 */
?>

<section class="no-results not-found pix-no_results">
	<header class="page-header">
		<h1 class="page-title search-title"><?php _e( 'Nothing Found', 'pixafy' ); ?></h1>
	</header><!-- .page-header -->

	<?php /*?>
	<article>
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'pixafy' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pixafy' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pixafy' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</article>
	<?php */?>
</section>
