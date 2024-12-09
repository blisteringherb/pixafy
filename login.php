<?php
add_filter( 'wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2 );

function wti_loginout_menu_link( $items, $args ) {
    if ($args->theme_location == 'primary') {
        if (is_user_logged_in()) {
            $items .= '<li class="menu-item navmenu-item-hide-right-border"><a href="'. wp_logout_url(home_url()) .'">'. __("Logout") .'</a></li>';
        }else if(isset($_SESSION['team_member'])){
            $items .= '<li class="menu-item navmenu-item-hide-right-border"><a href="/team-member/logout">'. __("Logout") .'</a></li>';
        }
    }
    return $items;
}
function pixafy_school_member_login_form($attr){
    $schools=get_users('orderby=nicename&role=register_complete_and_paid');
    $schooldropdown='';
    foreach ( $schools as $school ) {
        $schooldropdown.='<option value="'.$school->id.'">'.$school->nickname.'</option>';
    }
    return ((isset($_POST['school_name']) && isset($_POST['user_email_username'])) ?"<p class=\"wppb-error\">".$attr['failedmessage']."</p>":'').'<form name="team_member_login" id="wpaloginform" method="post">
              <p><input placeholder="Email" type="email" name="user_email_username" id="user_email_username" class="input" size="25"></p>
              <p><select name="school_name"><option value="">Please Select School</option>'.$schooldropdown.'
        
</select></p>

<p class="login-submit">
				<input type="submit" id="wppb-submit" class="button button-primary" value="Log In">
			</p>
</form>';
}
add_shortcode('pixafy-school-member-login-form', 'pixafy_school_member_login_form');
function pixafy_login_team_member() {
    // Check if the form was submitted with school_name and user_email_username
    if (isset($_POST['school_name']) && isset($_POST['user_email_username'])) {
        // Retrieve the team members for the selected school (using user meta)
        $team_members = get_user_meta((int)$_POST['school_name'], 'team_members', true);

        if (!empty($team_members)) {
            foreach ($team_members as $team_member) {
                // Check if the email matches and the team member is active
                if ($team_member['email'] == $_POST['user_email_username'] && $team_member['active']) {
                    // Store team member details in a cookie (encoded as JSON)
                    $team_member['school_id'] = $_POST['school_name'];
                    setcookie('team_member', json_encode($team_member), time() + (86400 * 30), "/"); // Expires in 30 days

                    // Redirect based on GET parameter or to a default page
                    if (isset($_GET['redirect'])) {
                        wp_safe_redirect('/' . urlencode($_GET['redirect']));
                    } else {
                        wp_safe_redirect('/coming-soon');
                    }
                    exit();
                }
            }
        }
    } elseif ($_SERVER['REQUEST_URI'] == '/team-member/logout') {
        // Unset the cookie to log out the user
        setcookie('team_member', '', time() - 3600, "/"); // Expire the cookie immediately
        wp_safe_redirect('/');
        exit();
    }
}
add_action('init', 'pixafy_login_team_member');

function pixafy_redirect_partial_registration( $user_login, $user ) {
    global $wpdb;
    $roles=get_user_meta($user->ID, $wpdb->prefix."capabilities", true);
    $querystring= isset($_POST['wppb_request_url']) ? parse_url($_POST['wppb_request_url'], PHP_URL_QUERY) : '';
    parse_str($querystring, $queryarray);
    if(is_array($roles) && !isset($roles['register_complete_and_paid']) && !isset($roles['administrator'])){
//        header('Location: /confirmation');
//        exit();
    }else if(isset($_GET['redirect']) || isset($queryarray['redirect'])){
        $redirect='';
        if(isset($_GET['redirect'])){
            $redirect=urlencode($_GET['redirect']);
        }else if(isset($queryarray['redirect'])){
            $redirect=urlencode($queryarray['redirect']);
        }
        header("Location: /$redirect");
        exit();
    }else if(isset($_POST['redirect_to'])){
        header('Location: '.$_POST['redirect_to']);
        exit();
    }
}
add_action('wp_login', 'pixafy_redirect_partial_registration', 10, 2);

function change_lost_password_link( $LostPassURL){
    $LostPassURL =home_url('recover-password','relative');
    return $LostPassURL;
}
add_filter('wppb_pre_login_url_filter','change_lost_password_link', 2);
add_filter( 'lostpassword_url',  'change_lost_password_link', 10);

function pixafy_remove_cookies() {
    if (isset($_COOKIE['user_id'])) {
        unset($_COOKIE['user_id']);
        setcookie('user_id', ' ', time() - 3600,COOKIEPATH,COOKIE_DOMAIN);
    }
}
add_action('wp_logout', 'pixafy_remove_cookies');

