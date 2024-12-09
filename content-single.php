<?php
/**
 * @package pixafy
 */

/**
 * This template is loaded when discussion topics are loaded to the page.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php pixafy_the_breadcrumb(); ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta">
			<?php pixafy_posted_on(); ?>
		</div>
	</header>

	<div class="entry-content pix-entry_single_content">
		
		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'pixafy' ),
				'after'  => '</div>',
			) );
		?>
	</div>

<!-- 	<footer class="entry-footer">
		<?php //pixafy_entry_footer(); ?>
	</footer> -->

</article>

