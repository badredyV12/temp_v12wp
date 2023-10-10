<?php
global $v_type;

// Vehicle type
$v_type=array(1 =>"cars & trucks",
            2 =>"commercial trucks",
            3 =>"motorcycles",
            4 =>"power boats",
            5 =>"rvs campers",
            6 =>"sail boats",
            7 =>"trailers",
            8 =>"atv golf cart",
            9 =>"vans"
        );
// Check if var is serialized or not
function isSerialized($data) {
    // Try to unserialize the data
    $unserializedData = @unserialize($data);

    // Check if unserialization was successful and the result is not equal to the original data
    return ($unserializedData !== false) && ($unserializedData != $data);
}

// Remove all empty fields
function array_filter_recursive($array) {
    foreach ($array as &$value) {
        if (is_array($value)) {
            $value = array_filter_recursive($value);
        }
    }

    return array_filter($array, function ($value) {
        return !is_null($value);
    });
}

// Check if a vehicle exit or not
function is_vehicle_exist($id) {
    $exist = get_posts(array(
        'post_type' => 'vehicles',
        'meta_key' => 'id',
        'meta_value' => $id,
        'posts_per_page' => 1,
        'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'trash', 'auto-draft', 'inherit'),
    ));
    return $exist;
}

// Format data
function format_vehicle_data($data,$vehicle_id) {
    global $overlay_settings;
    global $v_type;

    try {
        $exceptFeilds = array(
            "created_at",
            "updated_at",
            "queued_pickup_time",
            "queued_photo_download",
            "below",
            "average",
            "above",
            "vin_audit",
            "price_export",
            "price_export_type",
            "fbmp_price",
            "ebayclassifieds_category",
            "bought_from",
            "service_contract"
        );
        $v_title="";
        $status="publish";
        // Formating all fields
        $formatData = array();
        $data = (array) $data;
        if(!isset($data['listing_status'])){
            if(count($data)){
                $has_internet_specials = false;
                foreach ($data as $postDataKey => $postDataValue) {
                    if($postDataKey=="type")
                        $formatData['display_type']=$v_type[$postDataValue];
                   
                    if(!in_array($postDataKey,$exceptFeilds)){
                        if((in_array(gettype($postDataValue),["object","array"]))){
                            $subItem = (array) $postDataValue;
                            if(count($subItem))
                            foreach ($subItem as $subItemKey => $subItemValue) {
                                    if($subItemKey=="photos"){
                                        // Update a vehicle & overlay params
                                        $photos = [];
                                        if(!is_null($subItemValue)){
                                            $photos = isSerialized($subItemValue) ? $subItemValue : [];
                                        }
                                        $overlayParams = ["user_id"=>$data['user_id'],"photos"=>$photos,"app_env"=>$_ENV['APP_ENV']];
                                        if (is_array($overlay_settings))
                                            $overlayParams = array_merge($overlayParams,$overlay_settings);
                                        $v_id = isset($data['id']) ? $data['id'] : $data['pricing']['v_id'];
                                        $generate_overlay=generate_overlay($v_id,$overlayParams);
                                        $subItemValue = json_encode($generate_overlay);
                                    }
                                    // If this vehicle has a special price
                                    if($subItemKey == "internet_specials")
                                        $has_internet_specials = $subItemValue;
                                    if($subItemKey == "featured_price" && is_numeric($subItemValue))
                                        $formatData["display_special_price"] = $has_internet_specials ? "$".number_format($subItemValue) : "";
                                    if($subItemKey == "msrp" && is_numeric($subItemValue))
                                        $formatData["pricing_show_msrp"] = "$".number_format($subItemValue);
                                        
                                    if($subItemKey == "transmission")
                                        $subItemValue = match ($subItemValue) {
                                            "A" => "Automatic",
                                            "M" => "Manual",
                                            default => "-"
                                        };
                                    $formatData[$postDataKey."_".$subItemKey] = $subItemValue;
                                }
                        }else{
                            if($vehicle_id && in_array($postDataKey,["id","user_id"])){
                                $formatData[$postDataKey] = null;
                            }else{
                                // Format price & mileage
                                if(in_array($postDataKey,["price","mileage"]) && is_numeric($postDataValue)){
                                    $formatData["display_".$postDataKey] = $postDataKey=="price" ? "$".number_format($postDataValue) : number_format($postDataValue); 
                                    if($postDataKey=="price"){
                                        $price = $postDataValue;
                                        $monthlyPayment = ($price * (4 / 1200) * pow((1 + (4 / 1200)), 72)) / (pow((1 + (4 / 1200)), 72) - 1);
                                        if(is_numeric($monthlyPayment))
                                            $formatData["monthly_payment"] = "$".number_format($monthlyPayment);
                                    }
                                }
                                // Condition
                                if($postDataKey == "v_condition")
                                    $postDataValue = match ((integer) $postDataValue) {
                                        476030 => "certified",
                                        47603 => "certified_used",
                                        10425 => "new",
                                        10426 => "used",
                                        10427 => "traded",
                                        default => "Not set",
                                    };
                                $formatData[$postDataKey] = $postDataValue;
                            }
                        }
                    }
                }
            }
            $v_title=$formatData['year'] . ' ' . $formatData['make'] . ' ' . $formatData['model'] . ' ' . $formatData['stock'];
            $status = $formatData['published'] ? "publish" : "pending";
        }
        else{
            if(isset($data['status']) && !empty($data['status'])){
                    $status = $data['status'];
            }
            elseif(isset($data['price']) && !empty($data['price'])){
                $price = $data['price'];
                $formatData['price'] = $price;
                if(is_numeric($price))
                    $formatData['display_price'] = "$".number_format($price);
                $monthlyPayment = ($price * (4 / 1200) * pow((1 + (4 / 1200)), 72)) / (pow((1 + (4 / 1200)), 72) - 1);
                if(is_numeric($monthlyPayment))
                    $formatData["monthly_payment"] = "$".number_format($monthlyPayment);
            }
            elseif(isset($data['msrp']) && !empty($data['msrp']) && is_numeric($data['msrp'])){
                $formatData['pricing_msrp'] = $data['msrp'];
                $formatData['pricing_show_msrp'] = "$".number_format($data['msrp']);
            }
            elseif(isset($data['display_msrp']) && !empty($data['display_msrp'])){
                $formatData['pricing_display_msrp'] = $data['display_msrp'];
            }
            elseif(isset($data['featured_price']) && !empty($data['featured_price']) && is_numeric($data['featured_price'])){
                $formatData['display_special_price'] = "$".number_format($data['featured_price']);
            }
            elseif(isset($data['internet_specials']) && !empty($data['internet_specials']) && is_numeric($data['internet_specials'])){
                $formatData['other_information_internet_specials'] = "$".number_format($data['internet_specials']);
            }
            elseif(isset($data['pending']) && !empty($data['pending'])){
                $status = $data['pending'] ? "pending" : "publish" ;
            } 
            if(isset($data['published'])){
                $status = $data['published'] ? "publish" : "pending" ;
            } 
            if(isset($data['sold'])){
                $formatData['sold'] = $data['sold'] ? "1" : "0" ;
            } 
            error_log("The listing_status => ".$data['listing_status']." status => ".$status." Data => ".json_encode($data));
        }
        // Create a new data structer to save it 
        $newData = array(
            'ID' => $vehicle_id ?? null,
            'post_title' => $v_title,
            'post_status' => $status,
            'post_type' => 'vehicles',
            'meta_input' => $formatData
        );

        if(empty(trim($v_title)))
            unset($newData["post_title"]);
        return $newData;
    } catch (Exception $e) {
        return new WP_Error('error', $e->getMessage(), array('status' => 500));
    }
}
// Save Or Update vehicle
function save_vehicle($postData){
    try {
        $response = array();
        // Check if a vehicle exist or not
        if(gettype($postData)=="String"){
            $postData = json_decode($postData);
        }   
        $existing_vehicle = is_vehicle_exist($postData['id']);
        // Get first item
        $existing_vehicle = reset($existing_vehicle) ?? "";
        $vehicle_id = (isset($existing_vehicle->ID) && !empty($existing_vehicle->ID)) ? $existing_vehicle->ID : "";

        // Formating and validate input data
        $formatData = format_vehicle_data($postData,$vehicle_id);

        // Remove all empty fields
        $newData = array_filter_recursive($formatData);
        if (!$vehicle_id) {
            // Add a new vehicle

            $res = wp_insert_post($newData,true);
            if (is_wp_error($res)) {
                $error='Error: ' . $res->get_error_message();
                error_log("ADD POST - ".$error);
                return $error;
            } else {
                $response['message'] = "The vehicle $vehicle_id added successfully.";
            }
        } else {
            // Update a vehicle
            $res = wp_update_post($newData,true);
            if (is_wp_error($res)) {
                $error='Error: ' . $res->get_error_message();
                error_log("UPDAT POST - ".$error);
                return $error;
            } else {
                $response['message'] = "The vehicle $vehicle_id updated successfully.";
            }
        }
        error_log(json_encode($response));
        return new WP_REST_Response($response, 200);
    } catch (Exception $e) {
        echo "Error:".$e->getMessage();
    }
}

function get_vehicle_webhook_callback($request){
    global $overlay_settings;
	$overlay_settings = get_overlay_settings();
    // Get JSON data from the request body
    $postData = $request->get_json_params();
     // Check if JSON data is provided
    if (empty($postData)) {
        return new WP_Error('missing_data', 'Missing JSON data', array('status' => 400));
    }
    if(isset($postData['v_id'])){
        $dealer_id = get_option('dealer_id');
        $v_id = $postData['v_id'];
        $api_url = $_ENV['INVENTORY_API_URL']."/get-vehicle/$dealer_id/$v_id";
        $params = array(
            'api_token' => $_ENV['INVENTORY_API_TOKEN']
        );
        $api_url_with_params = add_query_arg($params, $api_url);
        $response = wp_remote_get($api_url_with_params, array('timeout' =>1000));
        error_log("Call to Saved vehicle manualy.");
        // Check if the request was successful and the response code is 200 (OK)
        if(is_wp_error($response)){
            $error='Error: ' . $response->get_error_message();
            error_log("INVENTORY_API : ".$error);
            return $error;
        }
        else{
            $postData = json_decode($response['body'], true);
            error_log("Get Saved vehicle manualy  => ".json_encode($postData));
            if(isset($postData['data'])){
                $res = save_vehicle($postData['data']);
                return $res;
            }else{
                return new WP_Error('missing_data', 'Missing JSON data', array('status' => 400));
            }
        }
    }else{
        return new WP_Error('missing_data', 'Missing JSON data', array('status' => 400));
    }
}
function save_vehicle_webhook_callback($request)
{
    global $overlay_settings;
	$overlay_settings = get_overlay_settings();
    // Get JSON data from the request body
    $postData = $request->get_json_params(); 

    // Check if JSON data is provided
    if (empty($postData)) {
        return new WP_Error('missing_data', 'Missing JSON data', array('status' => 400));
    }
    $res = save_vehicle($postData);
    return $res;
}
