<?php
/*
 * Plugin Name:V12 Vehicle Webhooks
 * Description: Provides a webhook to add / update / delete 'vehicles' posts by 'pwa_id' and 'dealer_id'.
 * Version: 1.0
 * Author: Badr eddine rahali
 */


// Include bg vehicle 
include_once(plugin_dir_path(__FILE__) . 'vehicle-bg-process.php');

// Include overlays
include_once(plugin_dir_path(__FILE__) . 'overlay/index.php');

// Include the vehicle endpoints
include_once(plugin_dir_path(__FILE__) . 'endpoints-webhook.php');

// Include delete vehicle
include_once(plugin_dir_path(__FILE__) . 'delete-vehicle-webhook.php');

// Include save vehicle
include_once(plugin_dir_path(__FILE__) . 'save-vehicle-webhook.php');

// Include save vehicle photos
include_once(plugin_dir_path(__FILE__) . 'save-vehicle-photos-webhook.php');

// Include import vehicles
include_once(plugin_dir_path(__FILE__) . 'import-vehicles-webhook.php');
