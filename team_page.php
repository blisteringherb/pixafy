<?php
$tmp_current_user_id = get_current_user_id();
function pixafy_team_members_add_submission($contact_form){
    global $tmp_current_user_id;
    if($contact_form->title=='Add Team Member Form' && $tmp_current_user_id > 0){
        $contact_form->skip_mail=true;
        $taskmember=array(
            'guid'=>uniqid(),
            'firstname'=>$_POST['first-name'],
            'lastname'=>$_POST['last-name'],
            'title'=>$_POST['title'],
            'email'=>$_POST['email'],
            'department'=>$_POST['department'],
            'active'=>true
        );
        $taskmembers=get_user_meta($tmp_current_user_id, "team_members", true);
        if(!is_array($taskmembers)){
            $taskmembers=array();
        }
        $taskmembers[]=$taskmember;
        update_user_meta($tmp_current_user_id, "team_members", $taskmembers);
    }
}
add_action('wpcf7_before_send_mail', 'pixafy_team_members_add_submission', 20, 3 );

function pixafy_team_members_edit_submission($contact_form){
    global $tmp_current_user_id;
    if($contact_form->title=='Edit Team Member Form' && $tmp_current_user_id > 0){
        $contact_form->skip_mail=true;
        $taskmembers=get_user_meta($tmp_current_user_id, "team_members", true);
        if(is_array($taskmembers)) {
            foreach($taskmembers as $key=>$member){
                if($member['guid']==$_POST['guid']){
                    $member['firstname']=$_POST['first-name'];
                    $member['lastname']=$_POST['last-name'];
                    $member['title']=$_POST['title'];
                    $member['email']=$_POST['email'];
                    $member['department']=$_POST['department'];
                    $taskmembers[$key]=$member;
                    break;
                }
            }
            update_user_meta($tmp_current_user_id, "team_members", $taskmembers);
        }
    }
}
add_action('wpcf7_before_send_mail', 'pixafy_team_members_edit_submission', 20, 3 );
function pixafy_team_members_shortcode($attr){
    $html=generateTeamMembersTableHeader();
    $users=getTeamMembersByStatus();
    if (!empty($users)) {
        foreach ($users as $user) {
            $html.=generateTableRowForUser($user);
        }
    }
    return $html.'</table>';
}
add_shortcode('pixafy-list-team-members', 'pixafy_team_members_shortcode');
function pixafy_inactive_team_members_shortcode($attr){
    $html=generateInactiveTeamMembersTableHeader(true);
    $users=getTeamMembersByStatus(true);
    if (!empty($users)) {
        foreach ($users as $user) {
            $html.=generateTableRowForUser($user,true);
        }
    }
    return $html.'</table>';
}
add_shortcode('pixafy-list-inactive-team-members', 'pixafy_inactive_team_members_shortcode');

//
function generateMobileRowForUser($user, $onlyinactive=false) {

    $jsonObj = htmlspecialchars(json_encode($user, ENT_QUOTES));
    $html='<div class="pix-dashboard_mobile_table_row"><div class="pix-row_odd">'.$user['firstname'].' '.$user['lastname'] .'</div><div class="pix-row_even">'.$user['email'].'</div><div class="pix-row_odd">'.$user['title'].'</div><div class="pix-row_even">'.$user['department'].'</div><div class="pix-row_even"><div class="edit_team_member fa fa-edit">'.(!$onlyinactive? '':'').'<input type="hidden" name="user-object" value="'.$jsonObj.'" />'.'</div></div><div class="pix-row_odd"><div class="disable_team_member '.($user['active']? 'fa fa-check':'fa fa-close ').'">'.($user['active']? '':'').'<input type="hidden" name="user-object" value="'.$jsonObj.'" />'.'</div></div></div>';
    return $html;
}
function pixafy_team_members_mobile_shortcode($attr){
    $html= '<div class="pix-dashboard_team_members_mobile">';
    $users=getTeamMembersByStatus();
    if (!empty($users)) {
        foreach ($users as $user) {
            $html.=generateMobileRowForUser($user);
        }
    }
    return $html.'</div>';
}
add_shortcode('pixafy-list-team-members-mobile', 'pixafy_team_members_mobile_shortcode');
function pixafy_inactive_team_members_mobile_shortcode($attr){
    $html= '<div class="pix-dashboard_inactive_team_members_mobile">';
    $users=getTeamMembersByStatus(true);
    if (!empty($users)) {
        foreach ($users as $user) {
            $html.=generateMobileRowForUser($user,true);
        }
    }
    return $html.'</div>';
}
add_shortcode('pixafy-list-inactive-team-members-mobile', 'pixafy_inactive_team_members_mobile_shortcode');
//

function generateTeamMembersTableHeader($inactive=false){
    $html='<table><thead><tr><td>Name</td><td>Email</td><td>Title</td><td>Department</td>'.(!$inactive ? '<td class="pix-table_text_align_header">Edit</td>':'').'<td class="pix-table_text_align_header">Make Inactive</td></tr></thead>';
    return $html;
}
function generateInactiveTeamMembersTableHeader($inactive = false) {
    $html='<table><thead><tr><td>Name</td><td>Email</td><td>Title</td><td>Department</td>'.(!$inactive ? '<td class="pix-table_text_align_header">Edit</td>':'').'<td class="pix-table_text_align_header">Reactivate</td></tr></thead>';
    return $html;
}
function getTeamMembersByStatus($onlyinactive=false){
    global $tmp_current_user_id;
    $currentteammembers=get_user_meta($tmp_current_user_id, "team_members", true);
    $teammembers=array();
    if(!empty($currentteammembers)) {
        foreach ($currentteammembers as $taskmember) {
            if ((!$onlyinactive && $taskmember['active']) || ($onlyinactive && !$taskmember['active'])) {
                $teammembers[] = $taskmember;
            }
        }
    }
    return $teammembers;
}
function generateTableRowForUser($user, $onlyinactive=false){
    //$jsonObj = str_replace('"', "'", json_encode($user));
    $jsonObj = htmlspecialchars(json_encode($user, ENT_QUOTES));
    $html='<tr><td>'.$user['firstname'].' '.$user['lastname'] .'</td><td>'.$user['email'].'</td><td>'.$user['title'].'</td><td>'.$user['department'].'</td>'.($user['active'] ? '<td class="pix-table_text_align_header"><div class="edit_team_member fa fa-edit">'.(!$onlyinactive? '':'').'<input type="hidden" name="user-object" value="'.$jsonObj.'" />'.'</div></td>' : '').'<td class="pix-table_text_align_header"><div class="disable_team_member '.($user['active']? 'fa fa-check':'fa fa-check').'">'.($user['active']? '':'').'<input type="hidden" name="user-object" value="'.$jsonObj.'" /><input type="hidden" name="_wpnonce" value="'.wp_create_nonce( 'wp_rest' ).'" />'.'</div></td></tr>';
    return $html;
}

function remove_team_member_endpoint( $data ) {
    global $tmp_current_user_id;
    if(isset($_GET['id']) && $tmp_current_user_id>0) {
        $teammembers=get_user_meta($tmp_current_user_id, "team_members", true);
        if(!empty($teammembers)){
            foreach($teammembers as $key=>$value){
                if($value['guid']==$_GET['id']){
                    unset($teammembers[$key]);
                    break;
                }
            }
            update_user_meta($tmp_current_user_id, "team_members", $teammembers);
        }
        return json_encode(array("status" => 200));
    }
    return json_encode(array("status" => 401));
}
//URL: wp-json/pixafy/remove_team_member
//parameters: id
add_action('rest_api_init',function (){
    register_rest_route( 'pixafy', '/remove_team_member',array(
        'methods' => 'GET',
        'callback' => 'remove_team_member_endpoint',
    ));
});

function change_status_team_member_endpoint( $data ) {
    global $tmp_current_user_id;
    if(isset($_GET['id']) && isset($_GET['status']) && $tmp_current_user_id>0) {
        $teammembers=get_user_meta($tmp_current_user_id, "team_members", true);
        if(!empty($teammembers)){
            foreach($teammembers as $key=>$value){
                if($value['guid']==trim($_GET['id'])){
                    $teammembers[$key]['active']=(trim($_GET['status'])=='active' ? true:false);
                    break;
                }
            }
            update_user_meta($tmp_current_user_id, "team_members", $teammembers);
        }
        //return json_encode(array("status" => 200));
        $location = $_SERVER['HTTP_REFERER'];
        wp_redirect($location);
        exit;
    }
    //return json_encode(array("status" => 401));
    $location = $_SERVER['HTTP_REFERER'];
    $redirect = add_query_arg('status', 'error', $location);
    wp_redirect($redirect);
    exit;
}
//URL: wp-json/pixafy/change_status_team_member
//parameters: id, status
add_action('rest_api_init',function (){
    register_rest_route( 'pixafy', '/change_status_team_member',array(
        'methods' => 'GET',
        'callback' => 'change_status_team_member_endpoint',
    ));
});