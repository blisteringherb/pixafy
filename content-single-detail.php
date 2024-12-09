<?php
/**
 * @package pixafy
 */

/**
 * This template is loaded when discussion topics are loaded to the page.
 */

$posttags = get_the_tags();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="pix-playbook_article_detail_wrapper">

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<div class="entry-meta">
				<?php pixafy_posted_on(); ?>
			</div>
			<?php if ($posttags) : ?>
				<ul class="entry-meta pix-entry_data_list">
					<?php
						$comma = ', ';
						foreach($posttags as $key => $tag) {
							$key++;
							if ($key !== count($posttags)){
					    		echo '<li class="pix-playbook_article_tag" id="'.$tag->term_id.'"><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . $comma . '</a></li>';
					    	} else {
					    		echo '<li class="pix-playbook_article_tag" id="'.$tag->term_id.'"><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>';
					    	}
					    	
						}
					?>
				</ul>
			<?php endif; ?>
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

	</div>
</article>

