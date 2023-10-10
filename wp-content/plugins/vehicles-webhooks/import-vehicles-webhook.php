<?php

global $v_bg_process;
$v_bg_process = new Vehicle_Background_Process();

// Import dealer vehicles
function import_vehicles_webhook_callback($request="")
{   
    global $v_bg_process;

    // Stop process
    $v_bg_process->stop_process();

    $dealer_id = get_option('dealer_id');
    if($dealer_id){
        $paginate = 1;
        $res = import_vhs($paginate,$dealer_id);
        return $res;
    }else{
        return new WP_Error('Error', 'Something went wrong.', array('status' => 500));
    }
}

// Import vehicles
function import_vhs($page,$dealer_id){
    try {
        global $v_bg_process;
        $api_url = $_ENV['INVENTORY_API_URL']."/get-vehicle?page=$page";
        $params = array(
            'dealer_id' => $dealer_id,
            'api_token' => $_ENV['INVENTORY_API_TOKEN']
        );
        $api_url_with_params = add_query_arg($params, $api_url);
        $response = wp_remote_get($api_url_with_params, array('timeout' =>1000));
        // Check if the request was successful and the response code is 200 (OK)
        if(is_wp_error($response)){
            $error='Error: ' . $response->get_error_message();
            error_log("INVENTORY_API : ".$error);
            return $error;
        }
        else{
            $postsData = json_decode($response['body'], true);
            $postsMeta = $postsData['meta'];
            $postsData = $postsData['data'];
            $code = $response['response']['code'];
            if($code == 401){
                return 'Unauthorized: You need valid credentials to access this resource.';
            }else if($code == 200){
                $v_bg_process->push_to_queue($postsData);
                $last_page = isset($postsMeta) ? $postsMeta['last_page'] : 1;
                $total = isset($postsMeta) ? $postsMeta['total'] : 1;
                if($last_page>$page){
                    error_log("===> Push page $page from $total.");
                    $page=$page+1;
                    import_vhs($page,$dealer_id);
                }
                $v_bg_process->save()->dispatch();
                error_log("****** Start import vehicles process! *******");
                return "Import process done.";
                    
            }else{
                return "Import vehicles something went wrong! $code";
            }
        }
    } catch (Exception $e) {
        error_log("Error :=> ".$e->getMessage());
    }
}

// Create import vehicles command
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('import-vhs', 'import_vehicles_webhook_callback');
}