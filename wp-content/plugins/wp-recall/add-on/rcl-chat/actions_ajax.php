<?php

add_action('wp_ajax_rcl_chat_remove_contact','rcl_chat_remove_contact',10);
function rcl_chat_remove_contact(){
    global $user_ID;
    
    rcl_verify_ajax_nonce();
    
    $chat_id = intval($_POST['chat_id']);
    
    rcl_chat_update_user_status($chat_id,$user_ID,0);
    
    $res['success'] = true;
    echo json_encode($res);
    exit;
    
}

add_action('wp_ajax_nopriv_rcl_chat_get_new_messages','rcl_chat_get_new_messages',10);
add_action('wp_ajax_rcl_chat_get_new_messages','rcl_chat_get_new_messages',10);
function rcl_chat_get_new_messages(){
    global $user_ID;
    
    rcl_verify_ajax_nonce();
    
    $chat_token = $_POST['chat']['token'];
    $last_activity = $_POST['last_activity'];
    $chat_room = rcl_chat_token_decode($chat_token);
    
    if(!rcl_get_chat_by_room($chat_room)) 
        return false;
    
    $content = '';
    
    require_once 'class-rcl-chat.php';
    $chat = new Rcl_Chat(array('chat_room'=>$chat_room));
    
    if($last_activity){

        $chat->query['where'][] = "message_time > '$last_activity'";
        if($user_ID) $chat->query['where'][] = "user_id != '$user_ID'";

        $messages = $chat->get_messages();

        if($messages){

            krsort($messages);

            foreach($messages as $k=>$message){
                $content .= $chat->get_message_box($message);
            }
            
            $chat->read_chat($chat->chat_id);

        }

        $res['content'] = $content;

    }

    if($activity = $chat->get_current_activity()) 
            $res['users'] = $activity;    
    
    $res['success'] = true;    
    $res['current_time'] = current_time('mysql');

    echo json_encode($res);
    exit;
}

add_action('wp_ajax_rcl_get_chat_page','rcl_get_chat_page',10);
add_action('wp_ajax_nopriv_rcl_get_chat_page','rcl_get_chat_page',10);
function rcl_get_chat_page(){
    
    rcl_verify_ajax_nonce();
    
    $chat_page = intval($_POST['page']);
    $in_page = intval($_POST['in_page']);
    $important = intval($_POST['important']);
    $chat_token = $_POST['token'];
    $chat_room = rcl_chat_token_decode($chat_token);
    
    if(!rcl_get_chat_by_room($chat_room)) 
        return false;
    
    require_once 'class-rcl-chat.php';
    $chat = new Rcl_Chat(
                array(
                    'chat_room'=>$chat_room,
                    'paged'=>$chat_page,
                    'important'=>$important,
                    'in_page'=>$in_page
                )
            );
    
    $res['success'] = true;    
    $res['content'] = $chat->get_messages_box();

    echo json_encode($res);
    exit;
}

add_action('wp_ajax_rcl_chat_add_message','rcl_chat_add_message',10);
function rcl_chat_add_message(){
    global $user_ID;
    
    rcl_verify_ajax_nonce();
    
    $POST = $_POST['chat'];

    $chat_room = rcl_chat_token_decode($POST['token']);
    
    if(!rcl_get_chat_by_room($chat_room)) 
        return false;
    
    require_once 'class-rcl-chat.php';
    $chat = new Rcl_Chat(array('chat_room'=>$chat_room));

    $result = $chat->add_message($POST['message'],$POST['attachment']);
    
    if ( $result->errors ){
        $res['errors'] = $result->errors;    
        echo json_encode($res);
        exit;
    }

    if(isset($result['errors'])){
        echo json_encode($result);
        exit;
    }

    $res['success'] = true;    
    $res['content'] = $chat->get_message_box($result);

    echo json_encode($res);
    exit;
}

add_action('wp_ajax_rcl_get_chat_private_ajax','rcl_get_chat_private_ajax',10);
function rcl_get_chat_private_ajax(){
    
    rcl_verify_ajax_nonce();
    
    $user_id = intval($_POST['user_id']);
    
    $chatdata = rcl_get_chat_private($user_id,array('avatar_size'=>30,'userslist'=>0));
    
    $chat = '<div class="rcl-chat-panel">'
            . '<a href="'.rcl_format_url(get_author_posts_url($user_id),'chat').'"><i class="fa fa-search-plus" aria-hidden="true"></i></a>'
            . '<a href="#" onclick="rcl_chat_close(this);return false;"><i class="fa fa-times" aria-hidden="true"></i></a>'
            . '</div>';
    $chat .= $chatdata['content'];

    $result['success'] = true;
    $result['content'] = $chat;
    $result['chat_token'] = $chatdata['token'];
    
    echo json_encode($result);
    exit;
}

add_action('wp_ajax_rcl_chat_message_important','rcl_chat_message_important');
function rcl_chat_message_important(){
    global $user_ID;
    
    rcl_verify_ajax_nonce();
    
    $message_id = intval($_POST['message_id']);
    
    $important = rcl_chat_get_message_meta($message_id,'important:'.$user_ID);
    
    if($important){
        rcl_chat_delete_message_meta($message_id,'important:'.$user_ID);
    }else{
        rcl_chat_add_message_meta($message_id,'important:'.$user_ID,1);
    }
    
    $result['success'] = true;
    $result['important'] = ($important)? 0: 1;
    
    echo json_encode($result);
    exit;
}

add_action('wp_ajax_rcl_chat_important_manager_shift','rcl_chat_important_manager_shift',10);
function rcl_chat_important_manager_shift(){
    global $user_ID;
    
    rcl_verify_ajax_nonce();
    
    $chat_token = $_POST['token'];
    $status_important = $_POST['status_important'];
    $chat_room = rcl_chat_token_decode($chat_token);
    
    if(!rcl_get_chat_by_room($chat_room)) 
        return false;
    
    require_once 'class-rcl-chat.php';
    $chat = new Rcl_Chat(array('chat_room'=>$chat_room,'important'=>$status_important));
    
    $res['success'] = true;   
    $res['content'] = $chat->get_messages_box();

    echo json_encode($res);
    exit;
}

add_action('wp_ajax_rcl_chat_delete_attachment','rcl_chat_delete_attachment');
function rcl_chat_delete_attachment(){
    global $user_ID;
    
    rcl_verify_ajax_nonce();
    
    $attachment_id = intval($_POST['attachment_id']);
    
    if(!$attachment_id) return false;
    
    if(!$post = get_post($attachment_id))
            return false;
    
    if($post->post_author!=$user_ID)
        return false;
    
    wp_delete_attachment($attachment_id);
    
    $result['success'] = true;
    echo json_encode($result);
    exit;
}

add_action('wp_ajax_rcl_chat_ajax_delete_message','rcl_chat_ajax_delete_message');
function rcl_chat_ajax_delete_message(){
    global $rcl_options,$current_user;
    
    rcl_verify_ajax_nonce();
    
    if(!$message_id = intval($_POST['message_id']))
            return false;
    
    $access = (isset($rcl_options['consol_access_rcl']))? $rcl_options['consol_access_rcl']: 7;

    if ( $current_user->user_level >= $access ){
        rcl_chat_delete_message($message_id);
    }
    
    $result['success'] = true;
    echo json_encode($result);
    exit;
}

add_action('wp_ajax_rcl_chat_upload', 'rcl_chat_upload');
function rcl_chat_upload(){
    global $user_ID,$wpdb,$rcl_options;

    rcl_verify_ajax_nonce();
    
    #допустимое расширение
    $valid_types = (isset($rcl_options['chat']['file_types'])&&$rcl_options['chat']['file_types'])? $rcl_options['chat']['file_types']: 'jpeg, jpg, png, zip, mp3';
    
    $valid_types = array_map('trim',explode(',',$valid_types));
    
    $timestamp = current_time('timestamp');
    
    $file = $_FILES['chat-upload'];

    $filetype = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'] );
    
    $type = $filetype['ext'];
    
    if (!in_array($type, $valid_types)){ 
        echo json_encode(array('error'=>__('Forbidden file extension. Allowed:','wp-recall').' '.implode(', ',$valid_types)));
        exit;
    }
    
    if($upload = wp_handle_upload( $file, array('test_form' => FALSE) )){
        
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        $attachment = array(
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
            'post_content' => '',
            'post_excerpt' => 'rcl_chat_attachment:unattached',
            'guid' => $upload['url'],
            'post_parent' => 0,
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $upload['file'] );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        
        $result['success'] = true;
        $result['attachment_id'] = $attach_id;
        $result['input_html'] = '<input type="hidden" name="chat[attachment]" value="'.$attach_id.'">';
        $result['icon_html'] = wp_get_attachment_image( $attach_id, array(100,100) ,true );
        
    }else{
        
        $result['error'] = true;
        
    }

    echo json_encode($result);
    exit;
}

