<?php


// Saving  muli or single vehicle
function save_vehicle_webhook_endpoint(){
    register_rest_route('vehicle-webhook/v1', '/save-vehicle', array(
        'methods' => 'POST',
        'callback' => 'save_vehicle_webhook_callback',
        'permission_callback' => '__return_true',
    ));
}

// Saving  muli or single vehicle
function get_vehicle_webhook_endpoint(){
    register_rest_route('vehicle-webhook/v1', '/get-vehicle', array(
        'methods' => 'POST',
        'callback' => 'get_vehicle_webhook_callback',
        'permission_callback' => '__return_true',
    ));
}
// Delete vehicle
function vehicle_webhook_endpoint() {
    register_rest_route('vehicle-webhook/v1', '/delete-vehicle', array(
        'methods' => 'DELETE',
        'callback' => 'vehicle_webhook_callback',
        'permission_callback' => '__return_true',
    ));
}

// Save vehicle photos
function save_vehicle_photos_webhook_endpoint(){
    register_rest_route('vehicle-webhook/v1', '/save-vehicle-photos', array(
        'methods' => 'POST',
        'callback' => 'save_vehicle_photos_webhook_callback',
        'permission_callback' => '__return_true',
    ));
}
// Clear overlay settings
function clear_overlay_settings_webhook_endpoint(){
    register_rest_route('vehicle-webhook/v1', '/clear-overlay-settings', array(
        'methods' => 'POST',
        'callback' => 'clear_overlay_settings_webhook_callback',
        'permission_callback' => '__return_true',
    ));
}

// Import vehicles
function import_vehicles_webhook_endpoint(){
    register_rest_route('vehicle-webhook/v1', '/import-vehicles', array(
        'methods' => 'POST',
        'callback' => 'import_vehicles_webhook_callback',
        'permission_callback' => '__return_true',
    ));
}
// Import vehicles
function queue_worker_endpoint(){
    register_rest_route('vehicle-webhook/v1', '/start-import-vehicles', array(
        'methods' => 'POST',
        'callback' => 'import_vehicles_webhook_callback',
        'permission_callback' => '__return_true',
    ));
}
// Get overlay settings
function get_overlay_settings_endpoint(){
    register_rest_route('vehicle-webhook/v1', '/get-overlay-settings', array(
        'methods' => 'POST',
        'callback' => "get_overlay_settings_webhook_callback",
        'permission_callback' => '__return_true',
    ));
}


// Compose all actions
function compose_actions(){
    queue_worker_endpoint();
    vehicle_webhook_endpoint();
    get_vehicle_webhook_endpoint();
    get_overlay_settings_endpoint();
    save_vehicle_webhook_endpoint();
    import_vehicles_webhook_endpoint();
    save_vehicle_photos_webhook_endpoint();
    clear_overlay_settings_webhook_endpoint();
}

// Init rest apis
add_action('rest_api_init', 'compose_actions');