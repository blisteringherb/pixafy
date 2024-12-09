<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package pixafy
 */
?>

<?php get_sidebar('footer'); ?>
<!-- Footer Terminal Section Starts-->
<?php 
    $footer_credits = esc_attr( get_theme_mod('footer_credits') ); 

    $social_facebook = esc_url( get_theme_mod('social_facebook') );
    $social_twitter = esc_url( get_theme_mod('social_twitter') );
    $social_google_plus = esc_url( get_theme_mod('social_google_plus') );
    $social_youtube = esc_url( get_theme_mod('social_youtube') );
    $social_instagram = esc_url( get_theme_mod('social_instagram') );
    $social_rss = esc_url( get_theme_mod('social_rss') );
    $social_pinterest = esc_url( get_theme_mod('social_pinterest') );
    $social_linkedin = esc_url( get_theme_mod('social_linkedin') );
    $social_email = esc_url( get_theme_mod('social_email') );
  ?>
<div class="pix-footer">
  <div class="pix-container">
    <div class="row">
      <div class="col-md-6 copyright-col pix-footer-col">
        <div class="footer-copyright">

          <?php if ( isset($footer_credits) && $footer_credits !='' ): ?>
            <p><?php echo $footer_credits; ?></p>
          <?php else :  ?>
    				<p><?php _e('Powered By ', 'pixafy'); ?><a href="<?php echo esc_url( __( 'http://www.infotuts.com', 'pixafy' ) ); ?>"><?php _e('InfoTuts.com', 'pixafy'); ?></a>
              <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'pixafy' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'pixafy' ), 'WordPress' ); ?></a></p>
          <?php endif ; ?>

        </div>
      </div>
      <div class="col-md-6 sm-links-col pix-footer-col">
        <div class="footer-menu-social">
          <ul>
          <?php if ( isset($social_email) & $social_email != '') { ?>
              <li>
                  <div class="circle email">
                      <a href="mailto:<?php echo $social_email; ?>" alt="Email">
                          <i class="fa fa-envelope-o">
                              <span>Email</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>

          <?php if ( isset($social_rss) && $social_rss != '') { ?>
              <li>
                  <div class="circle RSS">
                      <a target="_blank" rel="noopener" href="<?php echo $social_rss; ?>" alt="RSS">
                          <i class="fa fa-rss">
                              <span>RSS</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>

          <?php if ( isset($social_google_plus) && $social_google_plus != '') { ?>
              <li>
                  <div class="circle google">
                      <a target="_blank" rel="noopener" href="<?php echo $social_google_plus; ?>" alt="google+">
                          <i class="fa fa-google-plus">
                              <span>Google+</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>

          <?php if ( isset($social_pinterest) && $social_pinterest != '') { ?>
              <li>
                  <div class="circle pinterest">
                      <a target="_blank" rel="noopener" href="<?php echo $social_pinterest; ?>" alt="pinterest">
                          <i class="fa fa-pinterest">
                              <span>Pinterest</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>

          <?php if ( isset($social_linkedin) & $social_linkedin != '') { ?>
              <li>
                  <div class="circle linkedin">
                      <a target="_blank" rel="noopener" href="<?php echo $social_linkedin; ?>" alt="linkedin">
                          <i class="fa fa-linkedin">
                              <span>Linkedin</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>

          <?php if ( isset($social_twitter) && $social_twitter != '') { ?>
              <li>
                  <div class="circle twitter">
                      <a target="_blank" rel="noopener" href="<?php echo $social_twitter; ?>" alt="twitter">
                          <i class="fa fa-twitter">
                              <span>Twitter</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>

          <?php if ( isset($social_facebook) && $social_facebook != '') { ?>
              <li>
                  <div class="circle facebook">
                      <a target="_blank" rel="noopener" href="<?php echo $social_facebook; ?>" alt="facebook">
                          <i class="fa fa-facebook">
                              <span>Facebook</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>

          <?php if ( isset($social_instagram) && $social_instagram != '') { ?>
              <li>
                  <div class="circle instagram">
                      <a target="_blank" rel="noopener" href="<?php echo $social_instagram; ?>" alt="Instagram">
                          <i class="fa fa-instagram">
                              <span>Instagram</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>

          <?php if ( isset($social_youtube) && $social_youtube != '') { ?>
              <li>
                  <div class="circle youtube">
                      <a target="_blank" rel="noopener" href="<?php echo $social_youtube; ?>" alt="YouTube">
                          <i class="fa fa-youtube">
                              <span>YouTube</span>
                          </i>
                      </a>
                  </div>
              </li>
          <?php } else {} ?>
          </ul>
        </div>
        <div class="pix-clearfix"></div>
      </div>
    </div>
  </div>
</div>
<!-- Footer Terminal Section Ends-->
    <script type="text/javascript">
      var stylesheet_directory_uri = "<?php echo get_stylesheet_directory_uri(); ?>";
    </script>
  	<?php wp_footer(); ?>
  </body>
</html>
