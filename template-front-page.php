<?php
/*
  Template Name: Front Page
 */
?>
<?php
/**
 * 
 * @pages: [
 * home page
 * ]
 *  
 */
?>
<?php
  // Begin template rendering
  get_header();
?>

<?php
  // @admin_theme_customize: Homepage - Featured Banner Module (Default)  
  $animation_option = esc_attr( get_theme_mod('animation_option', 'on') );
  $top_featured_image = esc_url( get_theme_mod('top_featured_image') );
  $top_featured_title = esc_attr( get_theme_mod('top_featured_title') ); 
  $top_featured_description = esc_attr( get_theme_mod('top_featured_description') );
  $top_featured_button_text = esc_attr( get_theme_mod('top_featured_button_text') );
  $top_featured_button_link = esc_url( get_theme_mod('top_featured_button_link') );


  if (get_field('disable_homepage_parallax')){
    $disableParallax = 'no-fixed';
  }

  $isOffsetVert = false;
  if (get_field('vertical_offset_banner_position')) {
    $isOffsetVert = true;
    $offsetValueVert = 'background-position-y:' . get_field('vertical_offset_banner_position') . 'px;';
  }
  $isOffsetHor = false;
  if (get_field('horizontal_offset_banner_position')) {
    $isOffsetHor = true;
    $offsetValueHor = 'background-position-x:' . get_field('horizontal_offset_banner_position') . 'px;';    
  }
?>
<?php if(isset($_GET['success_register'])): ?>
    <p class="wppb-success"><?php echo get_post_meta(get_the_ID(), 'successful_register_message',true); ?></p>
<?php endif; ?>
<?php if ( isset($top_featured_image) && $top_featured_image != '' ): ?>
  <?php if(is_ssl()) {
      $top_featured_image = preg_replace('/^(https?:|)\/\//', 'https://', $top_featured_image);
    }
  ?>
<section class="top-featured-wrapper hero-section parallax-section-1 pix-home_banner_module<?php echo ' ' . $disableParallax; ?>" 
style="background-image:url(<?php echo $top_featured_image ?>); <?php echo $isOffsetHor ? $offsetValueHor : '' ?> <?php echo $isOffsetVert ? $offsetValueVert : '' ?>">
<?php else: ?>
<section class="top-featured-wrapper hero-section parallax-section-1 pix-home_banner_module<?php echo ' ' . $disableParallax; ?>" 
style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/DSC_1152.jpg); <?php echo $isOffsetHor ? $offsetValueHor : '' ?> <?php echo $isOffsetVert ? $offsetValueVert : '' ?>">
<?php endif; ?>  
  <div class="mask">
    <div class="pix-container">
      <div class="row">
        <div class="featured-text">

          <?php if ( isset($top_featured_title) && $top_featured_title!='' ): ?>
          <h2 class="wow fadeInUp" data-wow-duration="1s"><?php echo $top_featured_title; ?></h2>
          <?php else: ?>
          <h2 class="wow fadeInUp" data-wow-duration="1s"><?php _e('Learn more', 'pixafy'); ?></h2>
          <?php endif; ?>

          <?php if ( isset($top_featured_description) && $top_featured_description !='' ): ?>
          <h2 class="wow fadeInUp description" data-wow-duration="1.5s"><?php echo $top_featured_description; ?></h2>
          <?php else: ?>
          <h2 class="wow fadeInUp description" data-wow-duration="1.5s"> <?php _e('about JED Campus.', 'pixafy'); ?></h2>          
          <?php endif; ?>

          <?php if ( isset($top_featured_button_text) && $top_featured_button_text !='' ): ?>
          <a class="pix-home_banner_link wow fadeInUp" data-wow-duration="1s" href="<?php echo $top_featured_button_link; ?>"><?php echo $top_featured_button_text; ?></a>
          <?php else: ?>
          <a class="pix-home_banner_link wow fadeInUp" data-wow-duration="1s" href="#"><?php _e('Learn more about us.', 'pixafy'); ?></a>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</section>

<?php
  // @admin_acf_plugin: Page – Branded Content Module
  if (get_field('enable_branded_content_module')):
    $content = get_field('content');
?>
  <section id="pix-branded_content_module_section" class="pix-branded_content_module_section">
    <article class="pix-article">
      <div class="pix-content_block"><?php echo $content; ?></div>
    </article>
  </section>
<?php endif; ?>

<?php
  // @admin_acf_plugin: Homepage - Two Column Grid Module
  if (get_field('enable_branded_content_module')):
    $content = get_field('content');
?>
  <section id="pix-two_column_image_module_section" class="pix-two_column_image_module_section">
    <div class="pix-half_container left_container">
      <div class="pix-half_container_image">
        <img src="<?php echo the_field('left_column_image'); ?>" alt="" title="">
      </div>
      <div class="pix-half_container_title">
        <a class="pix-half_container_title_link" href="<?php echo the_field('left_column_content_link'); ?>"><?php echo the_field('left_column_title'); ?></a>
        <div class="pix-half_container_subcopy"><?php echo the_field('left_column_subcopy'); ?></div>
      </div>
    </div>
    <div class="pix-half_container right_container">
      <div class="pix-half_container_image">
        <img src="<?php echo the_field('right_column_image'); ?>" alt="" title="">
      </div>
      <div class="pix-half_container_title">
        <a class="pix-half_container_title_link" href="<?php echo the_field('right_column_content_link'); ?>"><?php echo the_field('right_column_title'); ?></a>
        <div class="pix-half_container_subcopy"><?php echo the_field('right_column_subcopy'); ?></div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
  // @admin_theme_customize: Homepage - 3 Column Featured Content Module
  $first_icon_threecolumn = esc_attr( get_theme_mod('first_icon_threecolumn') );
  $first_title_threecolumn = esc_attr( get_theme_mod('first_title_threecolumn') );
  $first_description_threecolumn = esc_attr( get_theme_mod('first_description_threecolumn') );
  $first_link_text_threecolumn = esc_attr( get_theme_mod('first_link_text_threecolumn') );
  $first_link_anchor_threecolumn = esc_url( get_theme_mod('first_link_anchor_threecolumn') );
?>

<section id="pix-three_col_icon_grid_module_section" class="pix-three_col_icon_grid_module_section">
  <div class="pix-section_wrapper">

    <div class="col-md-4 pix-three_col_wrapper">
      <div class="trefoil-box first text-center wow fadeInUp" data-wow-duration="1s">

      <?php if ( isset($first_icon_threecolumn) && $first_icon_threecolumn !='' ): ?>
        <a class="f-icon" href="<?php echo $first_link_anchor_threecolumn; ?>"><i class="fa <?php echo $first_icon_threecolumn; ?>"></i></i></a>
      <?php else: ?>
        <a class="f-icon" href="#"><i class="fa fa-mobile"></i></i></a>
      <?php endif; ?>

        <?php if ( isset($first_title_threecolumn) && $first_title_threecolumn !='' ): ?>
        <h3><?php echo $first_title_threecolumn; ?></h3>
        <?php else: ?>
        <h3><?php _e('Responsive', 'pixafy'); ?></h3>
        <?php endif; ?>

        <?php if ( isset($first_description_threecolumn) && !empty($first_description_threecolumn) ): ?>
        <p><?php var_dump($first_description_threecolumn); ?></p>
        <?php endif; ?>

        <?php if ( isset($first_link_text_threecolumn) && $first_link_text_threecolumn!='' ): ?>  
          <a class="trefoil-anchor" href="<?php echo $first_link_anchor_threecolumn; ?>"><?php echo $first_link_text_threecolumn; ?></a>
        <?php endif; ?>

      </div>
    </div>

    <?php 
      $second_icon_threecolumn = esc_attr( get_theme_mod('second_icon_threecolumn') );
      $second_title_threecolumn = esc_attr( get_theme_mod('second_title_threecolumn') );
      $second_description_threecolumn = esc_attr( get_theme_mod('second_description_threecolumn') );
      $second_link_text_threecolumn = esc_attr( get_theme_mod('second_link_text_threecolumn') );
      $second_link_anchor_threecolumn = esc_url( get_theme_mod('second_link_anchor_threecolumn') );
    ?>
    <div class="col-md-4 pix-three_col_wrapper">
      <div class="trefoil-box second text-center wow fadeInUp" data-wow-duration="1.5s">

      <?php if ( isset($second_icon_threecolumn) && $second_icon_threecolumn !='' ): ?>
        <a class="f-icon" href="<?php echo $second_link_anchor_threecolumn; ?>"><i class="fa <?php echo $second_icon_threecolumn; ?>"></i></i></a>
      <?php else: ?>
        <a class="f-icon" href="#"><i class="fa fa-eye"></i></i></a>
      <?php endif; ?>

        <?php if ( isset($second_icon_threecolumn) && $second_title_threecolumn!='' ): ?>
        <h3><?php echo $second_title_threecolumn; ?></h3>
        <?php else: ?>
        <h3><?php _e('Beautiful', 'pixafy'); ?></h3>
        <?php endif; ?>

        <?php if ( isset($second_icon_threecolumn) && $second_description_threecolumn!='' ): ?>
        <p><?php echo $second_description_threecolumn; ?></p>
        <?php endif; ?>

        <?php if ( isset($second_icon_threecolumn) && $second_link_text_threecolumn!='' ): ?>  
          <a class="trefoil-anchor" href="<?php echo $second_link_anchor_threecolumn; ?>"><?php echo $second_link_text_threecolumn; ?></a>
        <?php endif; ?>

      </div>
    </div>


    <?php 
      $third_icon_threecolumn = esc_attr( get_theme_mod('third_icon_threecolumn') );
      $third_title_threecolumn = esc_attr( get_theme_mod('third_title_threecolumn') );
      $third_description_threecolumn = esc_attr( get_theme_mod('third_description_threecolumn') );
      $third_link_text_threecolumn = esc_attr( get_theme_mod('third_link_text_threecolumn') );
      $third_link_anchor_threecolumn = (is_user_logged_in() || isset($_SESSION['team_member']))? esc_url( get_theme_mod('third_link_anchor_threecolumn_logged_in')) : esc_url( get_theme_mod('third_link_anchor_threecolumn_logged_out'));
    ?>
    <div class="col-md-4 pix-three_col_wrapper pix-last_col">
      <div class="trefoil-box third text-center wow fadeInUp" data-wow-duration="2s">

        <?php if ( isset($third_icon_threecolumn) && $third_icon_threecolumn!='' ): ?>
          <a class="f-icon" href="<?php echo $third_link_anchor_threecolumn; ?>"><i class="fa <?php echo $third_icon_threecolumn; ?>"></i></i></a>
        <?php else: ?>
          <a class="f-icon" href="#"><i class="fa fa-magic"></i></i></a>
        <?php endif; ?>

          <?php if ( isset($third_title_threecolumn) && $third_title_threecolumn!='' ): ?>
          <h3><?php echo $third_title_threecolumn; ?></h3>
          <?php else: ?>
          <h3><?php _e('Optimized', 'pixafy'); ?></h3>
          <?php endif; ?>

          <?php if ( isset($third_description_threecolumn) && $third_description_threecolumn!='' ): ?>
          <p><?php echo $third_description_threecolumn; ?></p>
          <?php endif; ?>

          <?php if ( isset($third_link_text_threecolumn) && $third_link_text_threecolumn!='' ): ?>  
            <a class="trefoil-anchor" href="<?php echo $third_link_anchor_threecolumn; ?>"><?php echo $third_link_text_threecolumn; ?></a>
          <?php endif; ?>

        </div>
    </div>

    <div class="pix-clearfix"></div>
  </div>
</section>


<?php
  // @admin_home_page: Content Subscription Form
?>
<section id="pix-subscription_form_section" class="pix-subscription_form_section">
  <?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part( 'content', 'page' ); ?>

  <?php endwhile; // end of the loop. ?>
</section>

<?php
  // @admin_theme_customize: Homepage - Blog Loop Module
  // DISABLED - NOT NEEDED IN DESIGN
  
  /*$no_of_blogs = esc_attr( get_theme_mod('no_of_blogs') );
	if( $no_of_blogs > 0){
?>
<!-- Blog Section Starts -->
<div class="bog-container hero-section">
  <div class="container">
    <div class="row">

<?php
  ($no_of_blogs = esc_attr( get_theme_mod('no_of_blogs') );
  $args = array('showposts' => $no_of_blogs);
  $the_query = new WP_Query( $args ); 
  if ( $the_query->have_posts() ) : 
  while ( $the_query->have_posts() ) : $the_query->the_post(); 
?>
      <div class="col-md-4 wow fadeInUp" data-wow-duration="1s">
        <div class="post-thumbnail">
          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php echo get_the_post_thumbnail( $post->ID, array( 360, 250), array( 'class' => 'thumb-entry' ) ); ?>
          </a>
        </div>
        <div class="blogs-inner-wrapper">

          <div class="blog-meta">
            <?php 
              $archive_year  = get_the_time('Y'); 
              $archive_month = get_the_time('m'); 
              $archive_day   = get_the_time('d'); 
            ?>
            <ul>
              <li class="author"><i class="fa fa-user"></i><?php the_author_posts_link() ?></li>
              <li class="time"><i class="fa fa-clock-o"></i><a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"><?php echo get_the_time('M d, Y') ?></a></li>
            </ul>
          </div><!-- blog-meta -->


          <div class="blog-title">
            <h3 class="front-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
          </div><!-- blog-title -->
        </div><!-- blogs-inner-wrapper -->
      </div><!-- col-md-4 -->
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
<?php else: ?>
<?php endif; ?>
    </div><!-- row -->
  </div><!-- container -->
</div><!-- bog-container -->
<?php } */?>


<?php
  // @admin_theme_customize: Homepage - Petron Carousel Module
  $first_client_image = esc_url( get_theme_mod('first_client_image') );
  $first_client_url = esc_url( get_theme_mod('first_client_url') );
  $second_client_image = esc_url( get_theme_mod('second_client_image') );
  $second_client_url = esc_url( get_theme_mod('second_client_url') );
  $third_client_image = esc_url( get_theme_mod('third_client_image') );
  $third_client_url = esc_url( get_theme_mod('third_client_url') );
  $fourth_client_image = esc_url( get_theme_mod('fourth_client_image') );
  $fourth_client_url = esc_url( get_theme_mod('fourth_client_url') );
  $fifth_client_image = esc_url( get_theme_mod('fifth_client_image') );
  $fifth_client_url = esc_url( get_theme_mod('fifth_client_url') );
  $sixth_client_image = esc_url( get_theme_mod('sixth_client_image') );
  $sixth_client_url = esc_url( get_theme_mod('sixth_client_url') );
  $our_client_heading = esc_attr( get_theme_mod('our_client_heading',__('Our Client', 'pixafy')) );
?>
<div class="petron">
  <section class="pix-container pix-partners_showcase_module_section">
    <div class="row">
      <div class="col-md-12 pix-fullwidth_col">
        <div class="petron-inner">
        <?php if ( isset($our_client_heading) && $our_client_heading!='' ): ?>
         <h3 class="wow fadeInUp" data-wow-duration="1s"><?php echo $our_client_heading; ?></h3> 
         <?php endif; ?>   
          <div class="publications wow fadeInUp" data-wow-duration="1.5s">
            <?php $default_img = get_template_directory_uri().'/images/DSC_1152.jpg'; ?>
            <?php if ( isset($first_client_image) && $first_client_image!='' ): ?>
              <div>
                <a target="_blank" rel="noopener" href='<?php echo $first_client_url; ?>'><img src='<?php echo $first_client_image; ?>'></a>
              </div>
            <?php endif; ?> 

            <?php if ( isset($second_client_image) && $second_client_image!='' ): ?>
              <div>
                <a target="_blank" rel="noopener" href='<?php echo $second_client_url; ?>'><img src='<?php echo $second_client_image; ?>'></a>
              </div>
            <?php endif; ?>

            <?php if ( isset($third_client_image) && $third_client_image!='' ): ?>
              <div>
                <a target="_blank" rel="noopener" href='<?php echo $third_client_url; ?>'><img src='<?php echo $third_client_image; ?>'></a>
              </div>
            <?php endif; ?>

            <?php if ( isset($fourth_client_image) && $fourth_client_image!='' ): ?>
              <div>
                <a target="_blank" rel="noopener" href='<?php echo $fourth_client_url; ?>'><img src='<?php echo $fourth_client_image; ?>'></a>
              </div>
            <?php endif; ?>

            <?php if ( isset($fifth_client_image) && $fifth_client_image!='' ): ?>
              <div>
                <a target="_blank" rel="noopener" href='<?php echo $fifth_client_url; ?>'><img src='<?php echo $fifth_client_image; ?>'></a>
              </div>
            <?php endif; ?>

            <?php if ( isset($sixth_client_image) && $sixth_client_image!='' ): ?>
              <div>
                <a target="_blank" rel="noopener" href='<?php echo $sixth_client_url; ?>'><img src='<?php echo $sixth_client_image; ?>'></a>
              </div>
            <?php endif; ?>           

          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
  get_footer();
  // End template rendering
?>