<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package pixafy
 */
?>

<!DOCTYPE html>
<html lang="en" <?php language_attributes(); ?>>

	<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
	
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?	id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MVNV77D');</script>
	<!-- End Google Tag Manager -->

	<?php wp_head(); ?>
		<script>
			var $ = jQuery.noConflict();
		</script>

		<?php
    global $is_IE;
    if($is_IE): ?>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
  <?php endif; ?>
	</head>
  <body id="pix-body" <?php body_class(); ?>>
	
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MVNV77D"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'pixafy' ); ?></a>
    <div class="nav-wrapper hero-section sticky">
      <div class="pix-container">
        <div class="row row-height">
          <div class="col-xs-3 col-sm-2 col-height logo-shield">
            <div class="pix-logo_wrapper">
              <div class="logo">
                <?php if ( get_theme_mod('logo') != '' ): ?> 
                  <a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'logo' ) ); ?>"></a>
                <?php else: ?>
                  <a href="<?php echo esc_url( home_url() ); ?>">
                  <p class="site-title"><?php bloginfo( 'name' ); ?></p>
                  <p class="site-desc"><?php bloginfo( 'description' ); ?></p>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-xs-9 col-sm-10 col-height text-left pix-header-right">
            <div class="center-vertically">
                <h4 class="jed-blue text-uppercase text-semibold get-help">Get Help Now</h4>
                <ul class="list-unstyled list-inline get-help">
                  <li>Text <span class="jed-blue">"START"</span> to <span class="jed-blue">741-741</span></li>
                  <li>or call <a href="tel:18002738255"><span class="jed-blue">1-800-273-TALK (8255)</span></a></li>
                </ul>
              </div>
            <nav class="menu-wrapper">
              <?php pixafy_nav(); ?>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div id="mobileMenu" class="pixafy-mobile-nav"><?php pixafy_mobile_nav(); ?></div>
<!-- Header Ends -->
