
<!-- ---------------Post starts ---------------- -->
<article id="post-<?php the_ID(); ?>" class="post blog-page-post">
    <div class="post-heading">
        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
    </div>
    <div class="post-meta">
        <ul>
            <li class="meta-admin"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
            <li class="meta-date"><?php
                $archive_year = get_the_time('Y');
                $archive_month = get_the_time('m');
                $archive_day = get_the_time('d');
                ?>
            <i class="fa fa-clock-o"></i> <a href="<?php the_permalink() ?>"> <?php echo esc_html( get_the_date('j M Y') ) ?></a></li>
            <li class="meta-cat"><i class="fa fa-folder-open"></i>  <?php the_category(', '); ?></li>
            <?php if( has_tag() ) { ?>
                <li class="meta-tag"><i class="fa fa-tag"></i> <?php the_tags(''); ?></li>
            <?php } ?>
            <li class="meta-comm"><i class="fa fa-comment"></i> <?php comments_popup_link(); ?></li>
        </ul>
    </div>
    <div class="thumb clear">
        <?php if ( has_post_thumbnail() ) { ?>
            <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('pixafy_post_thumbnail_loop'); ?>  </a>
            <?php
        } else {
          }
        ?>  
    </div>
    <div class="post-content clear">
        <?php the_excerpt(); ?>
        <?php wp_link_pages(); ?>
        <a href="<?php the_permalink() ?>" class="wpanch"><?php echo sprintf(
            esc_html__( 'Continue reading..%s', 'pixafy' ),
            the_title( '<span class="screen-reader-text">', '</span>', false )
           ) ; ?>
        </a>
    </div>
</article>