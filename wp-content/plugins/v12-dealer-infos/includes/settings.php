<?php
// Define and register a settings section and fields
function v12_dealer_info_settings() {
    register_setting('v12-dealer-info-group', 'custom_data');
    add_settings_section('v12-dealer-info-section', 'Custom Data', 'v12_dealer_info_section_callback', 'v12-dealer-info');
}

add_action('admin_init', 'v12_dealer_info_settings');

// Callback function for the settings section
function v12_dealer_info_section_callback() {
    echo '<p>Define your custom key-value pairs below:</p>';
}