<?php
/**
 * Plugin Name: Dealer ID Plugin
 * Description: Adds a dealer_id record to wp_options.
 * Version: 1.3
 * Author: Badredy
 */

// Prevent direct access to the plugin file.
defined('ABSPATH') or die('No direct access allowed.');

// Get the plugin version from the header comment.
$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$current_version = $plugin_data['Version'];

// Add a custom record for "dealer_id" in the wp_options table on plugin activation.
function dealer_id_plugin_activation()
{
    $dealer_id = 100110; // Replace this with the actual dealer ID value.
    add_option('dealer_id', $dealer_id);
}
register_activation_hook(__FILE__, 'dealer_id_plugin_activation');

// Remove the custom record from the wp_options table on plugin deactivation.
function dealer_id_plugin_deactivation()
{
    delete_option('dealer_id');
}
register_deactivation_hook(__FILE__, 'dealer_id_plugin_deactivation');

// Check for updates and display notification.
function display_update_notification()
{
    global $current_version;

    $new_version = '1.3'; // Fetch this from your API

    if (version_compare($current_version, $new_version, '<')) {
        $update_command = 'wp plugin update dealer-id-plugin --version=' . $new_version;
        $message = 'A new version (' . $new_version . ') of the Dealer ID Plugin is available. '
            . 'Run the following WP-CLI command to update: ' . $update_command;

        echo '<div class="notice notice-info is-dismissible"><p>' . esc_html($message) . '</p></div>';
    }
}
add_action('admin_notices', 'display_update_notification');

// Create a custom WP-CLI command for updating the plugin.
if (defined('WP_CLI') && WP_CLI) {
    require_once plugin_dir_path(__FILE__) . 'wp-cli-command.php';
}
