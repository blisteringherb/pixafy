
<?php get_header(); ?>
<div class="post-wrapper hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                <?php 
                    if (have_posts() ) :
                    while (have_posts() ) : the_post();
                    get_template_part('loop','index');   
                    endwhile;   
                ?>
                    <div class="nav-previous blog_pagination alignleft"><?php next_posts_link( __('Older posts', 'pixafy') ); ?></div>
                    <div class="nav-next blog_pagination alignright"><?php previous_posts_link( __('Newer posts', 'pixafy') ); ?></div>
                <?php else:
                    ?>
                    <div>
                        <p>
                            <?php _e('Sorry no post matched your criteria', 'pixafy'); ?>
                        </p>
                    </div>
                <?php endif; ?>
                <!--End Loop-->
                </main><!-- #main -->
                </div><!-- #primary -->

            </div><!-- col-md-8 -->

            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div><!-- col-md-4 -->

        </div><!-- row -->
    </div><!-- container -->
</div><!-- post-wrapper -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
