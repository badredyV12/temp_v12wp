<?php

// Register the REST API endpoint
function save_dealer_infos_webhook_endpoint() {
    register_rest_route('dealer-infos/v1', '/save', array(
        'methods' => 'POST',
        'callback' => 'save_dealer_infos_callback',
        'permission_callback' => '__return_true',
    ));
}
add_action("rest_api_init", "save_dealer_infos_webhook_endpoint");
// Callback function for saving dealer information
function save_dealer_infos_callback($request) {
    // Ensure that the request contains the necessary parameters
    $params = $request->get_json_params();

    // Retrieve the existing custom_data option
    $custom_data = get_option('custom_data', array());

    // Check if there are any parameters in the JSON payload
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            // Sanitize the key and value
            $key = sanitize_text_field($key);
            $value = sanitize_text_field($value);

            // Check if the key already exists in custom_data
            $key_index = array_search($key, $custom_data['key']);

            if ($key_index !== false) {
                // If the key exists, update its value
                $custom_data['value'][$key_index] = $value;
            } else {
                // If the key doesn't exist, add it
                $custom_data['key'][] = $key;
                $custom_data['value'][] = $value;
            }
        }

        // Update the 'custom_data' option
        update_option('custom_data', $custom_data);

        // Return a response indicating success
        return array(
            'success' => true,
            'message' => 'Dealer information saved or updated successfully.',
        );
    } else {
        // Return an error response if no parameters are found in the JSON payload
        return array(
            'success' => false,
            'message' => 'No data parameters found in the request.',
        );
    }
}
add_action("rest_api_init","save_dealer_infos_webhook_endpoint");
// Define the custom WP-CLI command
// Define the custom WP-CLI command
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    class Custom_CLI_Command extends WP_CLI_Command {

        /**
         * Insert or update a key-value pair in the custom_data option.
         *
         * ## OPTIONS
         *
         * <key>
         * : The key to insert or update.
         *
         * <value>
         * : The value to set for the key.
         *
         * ## EXAMPLES
         *
         * wp set-dealer-info set_key_value name badr
         *
         * @param array $args Command arguments.
         */
        function set_key_value($args) {
            list($key, $value) = $args;

            $key = sanitize_text_field($key);
            $value = sanitize_text_field($value);

            // Retrieve the existing custom_data option
            $custom_data = get_option('custom_data', array('key' => array(), 'value' => array()));

            $key_index = array_search($key, $custom_data['key']);

            if ($key_index !== false) {
                $custom_data['value'][$key_index] = $value;
            } else {
                $custom_data['key'][] = $key;
                $custom_data['value'][] = $value;
            }

            // Update the 'custom_data' option
            update_option('custom_data', $custom_data);

            WP_CLI::success("Key '$key' set to '$value' in 'custom_data' option.");
        }
    }

    // Register the custom command
    WP_CLI::add_command('set-dealer-info', 'Custom_CLI_Command');
}
