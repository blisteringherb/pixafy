<?php
function pixafy_user_successfully_registered($http_request, $form_name, $user_id){
    setcookie('user_id', base64_encode($user_id), time()+3600);
    set_user_role('registered_inprogress', $user_id);
    echo '<script>
        var date = new Date();  
        date.setTime(date.getTime() + (1*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
        document.cookie = "user_id='.base64_encode($user_id).'"+ expires + "; path=/";
</script>';
}
add_action('wppb_register_success', 'pixafy_user_successfully_registered', 20, 3 );
function pixafy_user_listing_shortcode_confirmation($attr){
    if(function_exists("wppb_user_listing_shortcode")){
       if(isset($_COOKIE['user_id'])){
            $attr['id']=base64_decode($_COOKIE['user_id']);
        }
        return wppb_user_listing_shortcode($attr);
    }
}
add_shortcode('pixafy-list-users-confirmation', 'pixafy_user_listing_shortcode_confirmation');

function pixafy_terms_shortcode_confirmation($attr){
    $user_id=base64_decode($_COOKIE['user_id']);
    if(isset($_COOKIE['user_id']) && get_user_meta($user_id,'terms_initials',true)==''){
        return $attr['message'];
    }else{
        if(isset($_COOKIE['user_id'])){
            $attr['id']=base64_decode($_COOKIE['user_id']);
        }
        $attr['single']='';
        $attr['name']='confirmation-page-with-initials';
        return wppb_user_listing_shortcode($attr);
    }
}
add_shortcode('pixafy-terms', 'pixafy_terms_shortcode_confirmation');

add_action( 'profile_update', function( $user_id, $old_user_data )
    {
        if(isset($_POST['members_user_roles']) && is_array($_POST['members_user_roles'])) {
            $newroles = array_diff($_POST['members_user_roles'], $old_user_data->roles);
            if (in_array('register_complete_and_paid', $newroles)) {
                set_user_role('granted_resource_documents', $user_id);
                set_user_role('granted_team_members', $user_id);
                set_user_role('granted_webinar', $user_id);
                set_user_role('granted_playbook', $user_id);
            }
        }

    },99,2
);

add_action('wpcf7_before_send_mail', 'pixafy_update_role_after_submission_confirmation', 20, 3 );
function pixafy_update_role_after_submission_confirmation($contact_form){
    if($contact_form->title=='Confirmation Form' && $_COOKIE['user_id']){
        $contact_form->skip_mail=true;
        $user_id=base64_decode($_COOKIE['user_id']);
        set_user_role('registered_confirmation', $user_id);
        set_user_role('registered_all', $user_id);
        remove_user_role('registered_inprogress', $user_id);

    }
} 