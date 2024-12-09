<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package pixafy
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php pixafy_the_breadcrumb(); ?>
	<?php /* ?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php */?>

	<div class="entry-content pix-entry_content">
		<?php if(get_field('assessment_total_question_tracker') || get_field('assessment_total_questions_answered_tracker')):  ?>
			<span class="pix-assessment_counter_header">
				<?php echo do_shortcode('['.get_field('assessment_total_questions_answered_tracker').']'); ?>/<?php echo do_shortcode('['.get_field('assessment_total_question_tracker').']'); ?>
			</span>
		<?php endif; ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'pixafy' ),
				'after'  => '</div>',
			) );
		?>
	</div>

	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit', 'pixafy' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
