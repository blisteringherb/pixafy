<?php
/**
 * @package pixafy
 */
?>
<?php 
	// echo '<pre>';
	// var_dump(get_the_post_thumbnail());
	// var_dump(get_the_excerpt());
	// echo '</pre>';
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="pix-playbook_article_thumb">
		<div class="pix-playbook_article_img">
			<?php echo the_post_thumbnail(); ?>
		</div>
		<header class="entry-header pix-playbook_article_thumb_header">
			<?php the_title( sprintf( '<h3 class="entry-title pix-playbook_article_thumb_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		</header>

		<footer class="entry-footer">
			<p><?php echo the_excerpt(); ?></p>
			<div class="entry-meta pix-playbook_article_timestamp hidden">
				<?php pixafy_posted_on(); ?>
			</div>
		</footer>
	</div>
</article>