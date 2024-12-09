<?php
/**
 * @package pixafy
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="pix-school_listing_item">
	<div class="pix-jed_school_member_wrapper">
		<header class="entry-header">
			<?php echo the_post_thumbnail(); ?>
		</header>
		<footer>
			<?php echo the_title(); ?>
		</footer>
	</div>
</article>