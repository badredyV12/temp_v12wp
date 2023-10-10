<?php

use V12software\InventoryBuilder\Photos;

//  Include Photos
include_once(plugin_dir_path(__FILE__) . 'Photos.php');

// Generate overlay
function generate_overlay($v_id,$data){
    $photos = new Photos();
    $res=$photos->build($v_id,$data);
    return $res;
}

// Clear overlay settings from redis
function clear_overlay_settings_webhook_callback(){
    global $use_redis;
    global $redis;
    try {
        $user_id = get_option('dealer_id');
        error_log("Start clear overlay settings for dealer $user_id.");

        $hExist=$redis->hExists($user_id,"overlay_settings");

        $msg = "";
        if($use_redis && $user_id && $hExist){
            $res = $redis->hdel($user_id,"overlay_settings");
            if($res)
                $msg = "The overlay_settings has been deleted.";
            else
                $msg = "The overlay_settings not deleted.";
        }else{
            $msg = "Something went wrong!";
        }
        return $msg;
    } catch (Exception $e) {
        error_log("Redis error ==> ".$e->getMessage());
    }
}

// Get overlay settings
function get_overlay_settings(){
    global $use_redis;
    global $redis;
    $api = $_ENV['OVERLAY_API_URL'];
    $token = $_ENV['OVERLAY_API_TOKEN'];
    $user_id = get_option('dealer_id');
    $overlay_settings="";
    error_log("Get overlay called ".$user_id);
    try {
        if($use_redis){
            if($redis->hExists($user_id, 'overlay_settings')){
                error_log("Start get overlay settings from redis for dealer $user_id.");
                $overlay_settings = $redis->HGET($user_id, 'overlay_settings');
                error_log("Overlay has been getted from redis => ".json_encode($overlay_settings));
                return json_decode($overlay_settings,true);
            }
        }
        if($overlay_settings==""){
            error_log("Start get overlay settings from db for dealer $user_id.");
            // Prepare API
            $token ="Bearer ".$token;
            $args = array(
                'headers' => array(
                    'Authorization' => $token,
                    'Content-Type' => 'application/json',
                ),
            );
            $api_url = $api.'/get_overlay_images';
            $params = array(
                'user_id' => $user_id,
                'classified_id' => 1
            );
            // Get overlay settings from CRM
            $api_url_with_params = add_query_arg($params, $api_url);
            $response = wp_remote_get($api_url_with_params,$args);
            if(is_wp_error($response)){
                $error='GET OVERLAY: ' . $response->get_error_message();
                error_log($error);
                return $error;
            }else{
                $code = $response['response']['code'];
                if($code == 401){
                    $error='Unauthorized: You need valid credentials to access this resource.';
                    error_log($error);
                    return $error;
                }
                else if($code == 200){
                    $overlay_settings = json_decode($response['body'], true);
                    $overlay_settings = $overlay_settings['result'];

                    // Save overlay settings in redis when i get it
                    if($use_redis && !empty($overlay_settings)){
                        $redis->HSET($user_id, 'overlay_settings',json_encode($overlay_settings));
                    }
                    error_log("Overlay settings has been getted & setted in redis.");
                    return $overlay_settings;
                }else{
                    $error="Get overlay something went wrong!";
                    error_log($error);
                    return $error;
                }
            }
        }
        return [];
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function get_overlay_settings_webhook_callback(){
    return get_overlay_settings();
}