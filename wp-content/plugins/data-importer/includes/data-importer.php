<?php
// data-importer.php

function import_demo_data()
{
    $dealer_id = get_option('dealer_id');
    $api_url = 'https://inventory.v12software.ai/api/internal/get-vehicle';  //prod
    $params = array(
       // 'dealer_id' => $dealer_id,
        'dealer_id' => 100131,
        'api_token' => 't23XrmF5X1FivApYdrzwtlHv3niDJcpH'
    );
    $api_url_with_params = add_query_arg($params, $api_url);
    $response = wp_remote_get($api_url_with_params, array('timeout' => 1000));
    // Check if the request was successful and the response code is 200 (OK)
    if (is_array($response) && !is_wp_error($response) && $response['response']['code'] === 200) {
        // Decode the JSON response
        $posts_data = json_decode($response['body'], true);
        $posts_data = $posts_data['data'];

        // Check if the data is an array and not empty
        if (is_array($posts_data) && !empty($posts_data)) {
            foreach ($posts_data as $post_data) {


                // Create a new post for each item in the $posts_data array
                $new_vehicle_id = wp_insert_post(array(
                    'post_title' =>
                        $post_data["year"] . " " . $post_data["make"] . " " . $post_data["model"] . " " . $post_data['stock'],
                    'post_status' => 'publish',
                    'post_type' => 'vehicles',
                    'meta_input' => array(
                        'id' => $post_data['id'],
                        'user_id' => $post_data['user_id'],
                        'type' => $post_data['type'],
                        'vin' => $post_data['vin'],
                        'stock' => $post_data['stock'],
                        'display_vin' => $post_data['display_vin'],
                        'year' => $post_data['year'],
                        'make_id' => $post_data['make_id'],
                        'make' => $post_data['make'],
                        'model_id' => $post_data['model_id'],
                        'model' => $post_data['model'],
                        'pending' => $post_data['pending'],
                        'desc_title' => $post_data['desc_title'],
                        'main_photo' => $post_data['main_photo'],
                        'photo_count' => $post_data['photo_count'],
                        'queued_pickup_time' => $post_data['queued_pickup_time'],
                        'queued_photo_download' => $post_data['queued_photo_download'],
                        'published' => $post_data['published'],
                        'sold' => $post_data['sold'],
                        'mileage' => $post_data['mileage'],
                        'odometer_units' => $post_data['odometer_units'],
                        //'v_condition' => $post_data['v_condition'],
                        'price' => $post_data['price'],
                        'price_type' => $post_data['price_type'],
                        'factory_color_id' => $post_data['factory_color_id'],
                        'factory_interior_id' => $post_data['factory_interior_id'],
                        'factory_color' => $post_data['factory_color'],
                        'factory_interior_color' => $post_data['factory_interior_color'],
                        'age_date' => $post_data['age_date'],
                        'active_in_website' => $post_data['active_in_website'],
                        'updated_by_dealer' => $post_data['updated_by_dealer'],
                        'created_at' => $post_data['created_at'],
                        'updated_at' => $post_data['updated_at'],
                        'photo_path' => $post_data['photo_path'],
                        'title' => $post_data['title'],
                        'price_caption' => $post_data['price_caption'],
                        'below' => $post_data['below'],
                        'average' => $post_data['average'],
                        'above' => $post_data['above'],
                        'vin_audit_v_id' => $post_data['vin_audit']['v_id'] ?? "",
                        'vin_audit_data' => $post_data['vin_audit']['data'] ?? "",
                        'vin_audit_created_at' => $post_data['vin_audit']['created_at'] ?? "",
                        'vin_audit_updated_at' => $post_data['vin_audit']['updated_at'] ?? "",
                        'sail_boat' => $post_data['sail_boat'],

                        'other_information_v_id' => $post_data['other_information']['v_id'] ?? "",
                        'other_information_title_suffix' => $post_data['other_information']['title_suffix'] ?? "",
                        'other_information_trim' => $post_data['other_information']['trim'] ?? "",
                        'other_information_engine' => $post_data['other_information']['engine'] ?? "",
                        //'other_information_transmission' => $post_data['other_information']['transmission'] ?? "",
                        'other_information_body_style_id' => $post_data['other_information']['body_style_id'] ?? "",
                        'other_information_body_style' => $post_data['other_information']['body_style'] ?? "",
                        'other_information_internet_specials' => $post_data['other_information']['internet_specials'] ?? "",
                        'other_information_pending' => $post_data['other_information']['pending'] ?? "",
                        'other_information_featured_inventory' => $post_data['other_information']['featured_inventory'] ?? "",
                        'other_information_featured_price' => $post_data['other_information']['featured_price'] ?? "",
                        'other_information_featured_text' => $post_data['other_information']['featured_text'] ?? "",
                        'other_information_featured_type' => $post_data['other_information']['featured_type'] ?? "",
                        'other_information_warranty' => $post_data['other_information']['warranty'] ?? "",
                        'other_information_show_cost' => $post_data['other_information']['show_cost'] ?? "",
                        'other_information_overlaid' => $post_data['other_information']['overlaid'] ?? "",
                        'other_information_fuel_type' => $post_data['other_information']['fuel_type'] ?? "",
                        'other_information_display_fuel' => $post_data['other_information']['display_fuel'] ?? "",
                        'other_information_drive_type' => $post_data['other_information']['drive_type'] ?? "",
                        'other_information_doors' => $post_data['other_information']['doors'] ?? "",
                        'other_information_updated_at' => $post_data['other_information']['updated_at'] ?? "",
                        'other_information_created_at' => $post_data['other_information']['created_at'] ?? "",
                        'other_information_report_auto_check' => $post_data['other_information']['report_auto_check'] ?? "",
                        'other_information_report_carfax' => $post_data['other_information']['report_carfax'] ?? "",
                        'other_information_report_one_owner' => $post_data['other_information']['report_one_owner'] ?? "",
                        'other_information_report_carfax_canada' => $post_data['other_information']['report_carfax_canada'] ?? "",
                        'other_information_report_custom' => $post_data['other_information']['report_custom'] ?? "",
                        'other_information_report_custom_link' => $post_data['other_information']['report_custom_link'] ?? "",
                        'other_information_title_disclose_on_website' => $post_data['other_information']['title_disclose_on_website'] ?? "",

                        'car_report_v_id' => $post_data['car_report']['v_id'] ?? "",
                        'car_report_auto_check' => $post_data['car_report']['auto_check'] ?? "",
                        'car_report_carfax' => $post_data['car_report']['carfax'] ?? "",
                        'car_report_one_owner' => $post_data['car_report']['one_owner'] ?? "",
                        'car_report_carfax_canada' => $post_data['car_report']['carfax_canada'] ?? "",
                        'car_report_custom' => $post_data['car_report']['custom'] ?? "",
                        'car_report_custom_link' => $post_data['car_report']['custom_link'] ?? "",
                        'car_report_created_at' => $post_data['car_report']['created_at'] ?? "",
                        'car_report_updated_at' => $post_data['car_report']['updated_at'] ?? "",

                        'photo_v_id' => $post_data['photo']['v_id'] ?? "",

                        //'photo_photos' => $post_data['photo']['photos'] ?? "",

                        'photo_created_at' => $post_data['photo']['created_at'] ?? "",
                        'photo_updated_at' => $post_data['photo']['updated_at'] ?? "",
                        'photo_url_photo' => $post_data['photo']['url_photo'] ?? "",
                        'miscellaneous' => $post_data['miscellaneous'],

                        'pricing_v_id' => $post_data['pricing']['v_id'] ?? "",
                        'pricing_msrp' => $post_data['pricing']['msrp'] ?? "",
                        'pricing_price_export' => $post_data['pricing']['price_export'] ?? "",
                        'pricing_price_export_type' => $post_data['pricing']['price_export_type'] ?? "",
                        'pricing_fbmp_price' => $post_data['pricing']['fbmp_price'] ?? "",
                        'pricing_display_msrp' => $post_data['pricing']['display_msrp'] ?? "",
                        'pricing_loan' => $post_data['pricing']['loan'] ?? "",
                        'pricing_display_loan' => $post_data['pricing']['display_loan'] ?? "",
                        'pricing_cl_price' => $post_data['pricing']['cl_price'] ?? "",
                        'pricing_ebayclassifieds_category' => $post_data['pricing']['ebayclassifieds_category'] ?? "",
                        'pricing_show_cash' => $post_data['pricing']['show_cash'] ?? "",
                        'pricing_price_downpayment' => $post_data['pricing']['price_downpayment'] ?? "",
                        'pricing_price_text' => $post_data['pricing']['price_text'] ?? "",
                        'pricing_display_payment' => $post_data['pricing']['display_payment'] ?? "",
                        'pricing_caption' => $post_data['pricing']['caption'] ?? "",
                        'pricing_created_at' => $post_data['pricing']['created_at'] ?? "",
                        'pricing_updated_at' => $post_data['pricing']['updated_at'] ?? "",

                        'vehicle_display_fuel' => $post_data['vehicle_display']['fuel'] ?? "",
                        'vehicle_display_transmission' => $post_data['vehicle_display']['transmission'] ?? "",
                        'vehicle_display_drive_type' => $post_data['vehicle_display']['drive_type'] ?? "",
                        'vehicle_display_fuel_type' => $post_data['vehicle_display']['fuel_type'] ?? "",
                        'vehicle_display_doors' => $post_data['vehicle_display']['doors'] ?? "",
                        'vehicle_display_engine' => $post_data['vehicle_display']['engine'] ?? "",
                        'vehicle_display_display_fuel' => $post_data['vehicle_display']['display_fuel'] ?? "",


                    ),
                ));
                //insert the main photo as featured image WP
                $featured_image_url = $post_data['photo_path'] . "/" . $post_data['main_photo'];
                add_featured_image($new_vehicle_id, $featured_image_url);

                //meta photo_photos (gallery)
                $imagesData = $post_data['photo']['photos'];
                $photo_path = $post_data['photo_path'];
                $gallery_images = array();
                $photos_array = unserialize($imagesData);
                foreach ($photos_array as $photo) {
                    if (isset($photo['photo'])) {
                        $image_filename = $photo['photo'];
                        $image_url = $photo_path . "/" . $image_filename;
                        $gallery_images[] = $image_url;
                    }
                }
                add_gallery_images($new_vehicle_id, $gallery_images);
                //transmission
                $transmission = $post_data['other_information']['transmission'] ?? '';
                if ($transmission === 'A') {
                    $wp_transmission = 'Automatic';
                } elseif ($transmission === 'M') {
                    $wp_transmission = 'Manual';
                } else {
                    $wp_transmission = 'Other';
                }
                update_post_meta($new_vehicle_id, 'other_information_transmission', $wp_transmission);


                //v_condition
                $condition = $post_data['v_condition'];
                switch ($condition) {
                    case "476030":
                        $condition = "certified";
                        break;
                    case "47603":
                        $condition = "certified_used";
                        break;
                    case "10425":
                        $condition = "new";
                        break;
                    case "10426":
                        $condition = "used";
                        break;
                    case "10427":
                        $condition = "traded";
                        break;

                    default:
                        $condition = "Not set";
                        break;
                }
                update_post_meta($new_vehicle_id, 'v_condition', $condition);

            }
        }
    }
}

function add_featured_image($post_id, $featured_image_url)
{
    $image_data = file_get_contents($featured_image_url);

    $filename = basename($featured_image_url);
    $upload_dir = wp_upload_dir();
    $upload_file = $upload_dir['path'] . '/' . $filename;

    file_put_contents($upload_file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $upload_file, $post_id);
    update_post_meta($post_id, '_thumbnail_id', $attach_id);
}

function add_gallery_images($post_id, $gallery_images)
{
    if (!empty($gallery_images)) {
        // Initialize an array to store attachment IDs
        $attachment_ids = array();

        // Loop through gallery images and process each one
        foreach ($gallery_images as $image_url) {
            $image_data = file_get_contents($image_url);

            $filename = basename($image_url);
            $upload_dir = wp_upload_dir();
            $upload_file = $upload_dir['path'] . '/' . $filename;

            file_put_contents($upload_file, $image_data);

            $wp_filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $upload_file, $post_id);
            $attachment_ids[] = $attach_id; // Store attachment ID
            update_post_meta($post_id, 'photo_photos', $attachment_ids);

        }
    }
}