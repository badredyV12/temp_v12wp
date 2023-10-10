<?php

global $photo_bg_process;
$photo_bg_process = new Photo_Background_Process();

// Format data
function format_vehicle_photos_data($formatData,$vehicle_id) {
    global $overlay_settings;
    try {
        $data = array();
        $data['photo_path']= $formatData['url'];

        // Update a vehicle & overlay params
        $overlayParams = ["user_id"=>$formatData['dealer_id'],"photos"=>$formatData['photos'],"app_env"=>$_ENV['APP_ENV']];
        if (is_array($overlay_settings))
        $overlayParams = array_merge($overlayParams,$overlay_settings);
        
        $generate_overlay = generate_overlay($formatData['v_id'],$overlayParams);
        $data['photo_photos'] = json_encode($generate_overlay);
     
        // Create a new data structer to update a vehicle 
        $newData = array(
            'ID' => $vehicle_id,
            'post_type' => 'vehicles',
            'meta_input' => $data
        );
        return $newData;
    } catch (Exception $e) {
        return new WP_Error('error', $e->getMessage(), array('status' => 500));
    }
}

function save_vehicle_photos_webhook_callback($request)
{
    global $overlay_settings;
    global $photo_bg_process;
    
	$overlay_settings = get_overlay_settings();
    // Get JSON data from the request body
    $postData = $request->get_json_params(); 
    $postData = reset($postData);
    // Check if JSON data is provided
    if (empty($postData)) {
        return new WP_Error('missing_data', 'Missing JSON data', array('status' => 400));
    }
    $response = array();
    // Check if a vehicle exist or not
    $existing_vehicle = is_vehicle_exist($postData['v_id']);
    $existing_vehicle = reset($existing_vehicle) ?? "";
    $vehicle_id = (isset($existing_vehicle->ID) && !empty($existing_vehicle->ID)) ? $existing_vehicle->ID : "";
    $v_id = $postData['v_id'];
    if ($vehicle_id && $existing_vehicle){
        // Formating and validate input data
        $formatData = format_vehicle_photos_data($postData,$vehicle_id);
        $photo_bg_process->push_to_queue($formatData);
        $photo_bg_process->save()->dispatch();
        error_log("****** Start import photos process! *******");
        $res["message"] = "The vehicle $v_id photos updated successfully.";
        return $res;
    }else{
        $response["message"] = "The vehicle $v_id not found.";
    }
    error_log(json_encode($response));
    return new WP_REST_Response($response, 200);
}
