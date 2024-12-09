<?php
/**
 * Pixafy functions and definitions.
 *
 * @package pixafy
 */

// Includes of function files for better organization
include_once("functions/confirmation.php");
include_once("functions/utilizes.php");
include_once("functions/team_page.php");
include_once("functions/discussion_board.php");
include_once("functions/login.php");
include_once("functions/dashboard.php");
include_once("functions/assessments.php");
include_once("functions/playbook.php");
include_once("functions/strategic_plan.php");


if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

/**
 * Theme setup.
 */
function pixafy_setup() {
	// Load theme textdomain.
	load_theme_textdomain( 'pixafy', get_template_directory() . '/languages' );

	// Add RSS feed links.
	add_theme_support( 'automatic-feed-links' );

	// Enable document title management.
	add_theme_support( 'title-tag' );

	// Enable post thumbnails.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'pixafy_post_thumbnail_loop', 700, 380, true );

	// Enable WooCommerce support.
	add_theme_support( 'woocommerce' );

	// Register navigation menus.
	register_nav_menus( array(
		'primary'                  => __( 'Primary Menu', 'pixafy' ),
		'assessments-menu'         => __( 'Assessments Menu', 'pixafy' ),
		'assessments-feedback-menu' => __( 'Assessments Feedback Menu', 'pixafy' ),
	) );

	// Switch to HTML5 markup for forms and comments.
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Custom background support.
	add_theme_support( 'custom-background', apply_filters( 'pixafy_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );
}
add_action( 'after_setup_theme', 'pixafy_setup' );

/**
 * Navigation for primary menu.
 */
function pixafy_nav() {
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'menu_class'     => 'sf-menu',
		'fallback_cb'    => 'pixafy_nav_fallback',
	) );
}

/**
 * Fallback for primary menu.
 */
function pixafy_nav_fallback() {
	echo '<ul class="sf-menu">';
	wp_list_pages( array( 'title_li' => '', 'show_home' => true, 'sort_column' => 'menu_order' ) );
	echo '</ul>';
}

/**
 * Mobile navigation.
 */
function pixafy_mobile_nav() {
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'menu_id'        => 'menu',
		'fallback_cb'    => 'pixafy_mobile_nav_fallback',
	) );
}

/**
 * Fallback for mobile navigation.
 */
function pixafy_mobile_nav_fallback() {
	echo '<ul id="menu">';
	wp_list_pages( array( 'title_li' => '', 'show_home' => true, 'sort_column' => 'menu_order' ) );
	echo '</ul>';
}

/**
 * Register widget areas.
 */
function pixafy_widgets_init() {
	$sidebars = array(
		'sidebar-1' => __( 'Sidebar', 'pixafy' ),
		'sidebar-2' => __( 'First footer widget', 'pixafy' ),
		'sidebar-3' => __( 'Second footer widget', 'pixafy' ),
		'sidebar-4' => __( 'Third footer widget', 'pixafy' ),
		'sidebar-5' => __( 'Fourth footer widget', 'pixafy' ),
		'sidebar-6' => __( 'Dashboard Sidebar', 'pixafy' ),
		'sidebar-7' => __( 'Sidebar Social Media', 'pixafy' ),
		'sidebar-9' => __( 'School Listing Category Banner Module', 'pixafy' ),
		'sidebar-10' => __( '404 Image', 'pixafy' ),
		'sidebar-11' => __( 'Terms of Conditions', 'pixafy' ),
		'sidebar-12' => __( 'Registration Payment Table', 'pixafy' ),
		'sidebar-13' => __( 'Registration Payment Copy', 'pixafy' ),
		'sidebar-14' => __( 'Baseline Assessment Closing Statement', 'pixafy' ),
		'sidebar-15' => __( 'Post Assessment Closing Statement', 'pixafy' ),
	);

	foreach ( $sidebars as $id => $name ) {
		register_sidebar( array(
			'name'          => $name,
			'id'            => $id,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'pixafy_widgets_init' );

/**
 * Enqueue styles.
 */
function pixafy_styles() {
	wp_enqueue_style( 'pixafy-font-droid-serif', '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' );
	wp_enqueue_style( 'pixafy-font-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400italic,700,300,600,400' );
	wp_enqueue_style( 'pixafy-legacy-styles', get_template_directory_uri() . '/css/legacy_min/styles.min.css' );
	wp_enqueue_style( 'pixafy-styles', get_template_directory_uri() . '/css/min/styles.min.css' );
	wp_enqueue_style( 'print-styles', get_template_directory_uri() . '/css/min/print.min.css', array(), null, 'print' );

	if ( is_page_template( 'template-fullwidth.php' ) ) {
		wp_enqueue_style( 'framework-script', get_template_directory_uri() . '/css/modules/timeline.css' );
	}

	if ( is_page_template( array( 'template-two-column-dashboard-strat-plan.php', 'template-two-column-dashboard-strat-detail.php' ) ) ) {
		wp_enqueue_style( 'framework-script', get_template_directory_uri() . '/css/modules/datepicker.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'pixafy_styles' );

/**
 * Enqueue scripts.
 */
function pixafy_scripts() {
	wp_enqueue_script( 'pixafy-legacy-script', get_template_directory_uri() . '/js/legacy_min/scripts.min.js' );
	wp_enqueue_script( 'pixafy-script', get_template_directory_uri() . '/js/min/scripts.min.js', array(), time(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_page_template( 'template-two-column-dashboard.php' ) ) {
		wp_enqueue_script( 'modal-script', get_template_directory_uri() . '/js/modules/team_members.js' );
	}

	if ( is_page_template( array( 'template-two-column-dashboard-strat-plan.php', 'template-two-column-dashboard-strat-detail.php' ) ) ) {
		wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.11.0/jquery-ui.js' );
		wp_enqueue_script( 'update-strategy-script', get_template_directory_uri() . '/js/modules/strat-plan-form.js' );
	}
}
add_action( 'wp_enqueue_scripts', 'pixafy_scripts' );

/**
 * Breadcrumb functionality.
 */
function pixafy_the_breadcrumb() {
    // Settings
    $separator  = '&gt;';
    $id         = 'breadcrumbs';
    $class      = 'breadcrumbs';
    $home_title = __( 'Homepage', 'pixafy' );

    if ( ! is_front_page() ) {
        echo '<ul id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '">';
        echo '<li><a href="' . esc_url( home_url() ) . '">' . esc_html( $home_title ) . '</a></li>';
        echo '<li>' . esc_html( $separator ) . '</li>';

        if ( is_single() ) {
            $category = get_the_category();
            if ( $category ) {
                echo '<li><a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '">' . esc_html( $category[0]->cat_name ) . '</a></li>';
                echo '<li>' . esc_html( $separator ) . '</li>';
            }
            echo '<li>' . esc_html( get_the_title() ) . '</li>';
        } elseif ( is_category() ) {
            echo '<li>' . esc_html( single_cat_title( '', false ) ) . '</li>';
        } elseif ( is_page() ) {
            if ( $post->post_parent ) {
                $anc = get_post_ancestors( $post->ID );
                $anc = array_reverse( $anc );
                foreach ( $anc as $ancestor ) {
                    echo '<li><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a></li>';
                    echo '<li>' . esc_html( $separator ) . '</li>';
                }
            }
            echo '<li>' . esc_html( get_the_title() ) . '</li>';
        } elseif ( is_tag() ) {
            echo '<li>' . esc_html( single_tag_title( '', false ) ) . '</li>';
        } elseif ( is_day() ) {
            echo '<li><a href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '">' . esc_html( get_the_time('Y') ) . ' ' . __( 'Archives', 'pixafy' ) . '</a></li>';
            echo '<li>' . esc_html( $separator ) . '</li>';
            echo '<li><a href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ) . '">' . esc_html( get_the_time('M') ) . '</a></li>';
            echo '<li>' . esc_html( $separator ) . '</li>';
            echo '<li>' . esc_html( get_the_time('jS') ) . '</li>';
        } elseif ( is_month() ) {
            echo '<li><a href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '">' . esc_html( get_the_time('Y') ) . '</a></li>';
            echo '<li>' . esc_html( $separator ) . '</li>';
            echo '<li>' . esc_html( get_the_time('M') ) . '</li>';
        } elseif ( is_year() ) {
            echo '<li>' . esc_html( get_the_time('Y') ) . '</li>';
        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata( $author );
            echo '<li>' . esc_html( $userdata->display_name ) . '</li>';
        } elseif ( get_query_var( 'paged' ) ) {
            echo '<li>' . __( 'Page', 'pixafy' ) . ' ' . esc_html( get_query_var( 'paged' ) ) . '</li>';
        } elseif ( is_search() ) {
            echo '<li>' . __( 'Search results for:', 'pixafy' ) . ' ' . esc_html( get_search_query() ) . '</li>';
        } elseif ( is_404() ) {
            echo '<li>' . __( 'Error 404', 'pixafy' ) . '</li>';
        }

        echo '</ul>';
    }
}

/**
 * Share bar functionality.
 */
function pixafy_share_bar() {
    ?>
    <div class="bar">
        <div class="share">
            <!-- Twitter -->
            <a class="share-twitter" onclick="window.open('http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>','twitter','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank" rel="noopener"><i class="fa fa-twitter-square"></i></a>

            <!-- Facebook -->
            <a class="share-facebook" onclick="window.open('http://www.facebook.com/share.php?u=<?php the_permalink(); ?>','facebook','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank" rel="noopener"><i class="fa fa-facebook-official"></i></a>

            <!-- LinkedIn -->
            <a onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&source=<?php the_permalink(); ?>','linkedin','width=600,height=400'); return false;" title="Share on LinkedIn" target="_blank" rel="noopener"><i class="fa fa-linkedin-square"></i></a>
        </div>
    </div>
    <?php
}

/**
 * Custom theme color settings.
 */
function custom_theme_color(){
    $custom_theme_color = get_theme_mod( 'custom_theme_color', '#40BC69' );

    if ( $custom_theme_color !== '#40BC69' && $custom_theme_color !== '' ) {
        ?>
        <style type="text/css">
            a, .logo a:hover, .featured-text h2 a:hover, .trefoil-box a, .sfooter-box a, p.form-submit input[type='submit'], .search-form .search-submit, .user_comment i.fa, .slick-prev, .slick-next {
                color: <?php echo esc_attr( $custom_theme_color ); ?>;
            }
            .sf-menu a:hover, .current-menu-item a, .nav-previous a, .nav-next a {
                background: <?php echo esc_attr( $custom_theme_color ); ?>;
            }
            .sfooter-box h4, p.form-submit input[type='submit'], .user_detail, .thanks p {
                border-color: <?php echo esc_attr( $custom_theme_color ); ?>;
            }
        </style>
        <?php
    }
}
add_action( 'wp_head', 'custom_theme_color' );

/**
 * Adjust the brightness of a color.
 *
 * @param string $hex    Hex color code.
 * @param int    $steps  Steps to adjust the brightness (range -255 to 255).
 * @return string        Adjusted hex color code.
 */
function adjustBrightness($hex, $steps) {
    $steps = max(-255, min(255, $steps)); // Limit steps to between -255 and 255.

    // Normalize into a six-character long hex string.
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // Split into three parts: R, G, and B.
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color = hexdec($color); // Convert to decimal.
        $color = max(0, min(255, $color + $steps)); // Adjust color.
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code.
    }

    return $return;
}

/**
 * Inject custom CSS set in the theme customizer.
 */
function custom_css() {
    $custom_css = esc_attr(get_theme_mod('custom_css'));
    if (!empty($custom_css)) {
        echo '<style type="text/css">' . $custom_css . '</style>';
    }
}
add_action('wp_head', 'custom_css');

/**
 * Meta Data Option.
 */
function meta_data_option() {
    echo get_theme_mod('meta_data_option');
}
add_action('wp_head', 'meta_data_option');

/**
 * Footer code option.
 */
function footer_code_option() {
    echo get_theme_mod('footer_code_option');
}
add_action('wp_footer', 'footer_code_option');

/**
 * Remove WP version from enqueued scripts and styles.
 */
function pixafy_remove_wp_ver_css_js($src) {
    if (strpos($src, 'ver=' . get_bloginfo('version'))) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'pixafy_remove_wp_ver_css_js', 9999);
add_filter('script_loader_src', 'pixafy_remove_wp_ver_css_js', 9999);

function update_contact_methods($contactmethods) {
    $methods_to_remove = ['aim', 'jabber', 'yim', 'googleplus', 'facebook', 'twitter', 'url'];
    
    foreach ($methods_to_remove as $method) {
        unset($contactmethods[$method]);
    }
    
    return $contactmethods;
}

class T5_Hide_Profile_Bio_Box {
    /**
     * Called on 'personal_options'.
     *
     * @return void
     */
    public static function start() {
        $action = ( IS_PROFILE_PAGE ? 'show' : 'edit' ) . '_user_profile';
        add_action( $action, array( __CLASS__, 'stop' ) );
        ob_start();
    }

    /**
     * Strips the bio box from the buffered content.
     *
     * @return void
     */
    public static function stop() {
        $html = ob_get_contents();
        ob_end_clean();

        // Remove the headline
        $headline = __( IS_PROFILE_PAGE ? 'About Yourself' : 'About the user' );
        $html = str_replace( '<h2>' . $headline . '</h2>', '', $html );

        // Remove the table rows
        $html = preg_replace('/(<tr class="user-url-wrap">)([\s\S]*)(<\/tr>)/msU', '', $html); // Website
        $html = preg_replace('/(<tr class="user-description-wrap">)([\s\S]*)(<\/tr>)/msU', '', $html); // Bio Description
        $html = preg_replace('/(<tr class="user-profile-picture">)([\s\S]*)(<\/tr>)/msU', '', $html); // User Profile Picture

        print $html;
    }
}
add_action( 'personal_options', array( 'T5_Hide_Profile_Bio_Box', 'start' ) );

function initialize_wow_js() {
    $animation_option = esc_attr(get_theme_mod('animation_option', 'on'));
    
    if (!is_admin() && $animation_option == 'on') { ?>
        <script type="text/javascript">
            new WOW().init(); // Initialization of wow effects (animation)
        </script>
    <?php }
}
add_action('wp_footer', 'initialize_wow_js');


function create_post_type() {
    register_post_type('jed_school_member', array(
        'labels' => array(
            'name' => __('School Members'),
            'singular_name' => __('School Member'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('category', 'post_tag'),
    ));
}
add_action('init', 'create_post_type');

function sidebar_shortcode($atts, $content = "null") {
    extract(shortcode_atts(array('name' => ''), $atts));

    ob_start();
    get_sidebar($name);
    $sidebar = ob_get_contents();
    ob_end_clean();

    return $sidebar;
}
add_shortcode('get_sidebar', 'sidebar_shortcode');

/**
 * Extend discussion board
 */

 function myprefix_change_ctdb_titles($titles) {
    $titles = array(
        'topic'     => __('Topic', 'discussion-board'),
        'replies'   => __('Comments', 'discussion-board'),
        'started'   => __('Date Opened', 'discussion-board'),
        'voices'    => __('Schools Talking', 'discussion-board'),
        'freshness' => __('Last Activity', 'discussion-board'),
    );

    return $titles;
}
add_filter('ctdb_topic_titles', 'myprefix_change_ctdb_titles');

function is_webinar() {
    return (isset($_SERVER['HTTP_REFERER']) && stripos($_SERVER['HTTP_REFERER'], "dashboard-webinar") !== 0);
}

function check_webinar_viewed() {
    $key = 'webinar_viewed';
    $userId = is_user_logged_in() ? get_current_user_id() : 0;
    
    if (is_webinar() && $userId && !get_user_meta($userId, $key, true)) {
        $webinarPostKey = 'school_viewed_webinar';

        if (isset($_POST[$webinarPostKey])) {
            $user = wp_get_current_user();
            $to = get_option("admin_email");
            $subject = "Webinar View";
            $message = "User {$user->user_login} has viewed the webinar.";
            
            if ($to) {
                wp_mail($to, $subject, $message);
            } else {
                error_log("ERROR: NO EMAIL FOUND");
            }

            update_user_meta($userId, $key, true);
        }
    }
}
add_action('init', 'check_webinar_viewed');

add_action('wpcf7_before_send_mail', 'pix_before_send_email');
function pix_before_send_email($contact_form) {
    global $wpdb;
    if ($contact_form->id() == 187) {
        $wpdb->query(
            $wpdb->prepare(
                'INSERT INTO ' . $wpdb->prefix . 'pix_contact_form (`first_name`, `last_name`, `telephone`, `email`, `subject`, `inquiry`) VALUES (%s,%s,%s,%s,%s,%s)', 
                $_POST['first-name'], 
                $_POST['last-name'], 
                $_POST['telephone'], 
                $_POST['email'], 
                $_POST['subject'], 
                $_POST['inquiry-summary']
            )
        );
    }
}

add_action('wp_footer', 'on_cf7_mail_sent');

function on_cf7_mail_sent() {
    ?>
    <script type="text/javascript">
        document.addEventListener('wpcf7mailsent', function(event) {
            if (event.detail.contactFormId == '167') {
                var modal = new PixModal();
                modal.modalFormCallback(event.detail.inputs);
            }
        }, false);
    </script>
    <?php
}


