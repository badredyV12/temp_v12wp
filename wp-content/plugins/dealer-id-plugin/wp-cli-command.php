<?php
if (class_exists('WP_CLI')) {
    class Dealer_ID_Update_Command extends WP_CLI_Command
    {
        /**
         * Update the Dealer ID Plugin to a specific version.
         *
         * ## OPTIONS
         *
         * <version>
         * : The version to update the plugin to.
         *
         * ## EXAMPLES
         *
         * wp v12 plugin update dealer-id-plugin 1.2
         *
         * @param array $args Command arguments.
         */
        public function update($args)
        {
            // Ensure that the version argument is provided.
            if (empty($args[0])) {
                WP_CLI::error("Please provide the target version as an argument.");
            }

            $version = $args[0];
            $update_url = 'https://v12wp.com/plugins/dealer-id-plugin_v' . $version . '.zip'; // Updated URL format

            // Download the ZIP file.
            $download = download_url($update_url);
            if (is_wp_error($download)) {
                WP_CLI::error("Error downloading the update: " . $download->get_error_message());
            }

            // Extract the contents using ZipArchive.
            $zip = new ZipArchive();
            $extract_path = WP_CONTENT_DIR . '/plugins/';
            $extracted = $zip->open($download);

            if ($extracted === true) {
                $zip->extractTo($extract_path);
                $zip->close();
            } else {
                WP_CLI::error("Error extracting the update.");
            }

            // Clean up downloaded file.
            unlink($download);

            // Display success message.
            WP_CLI::success('Plugin updated successfully to version ' . $version);
        }
    }

    WP_CLI::add_command('v12 plugin update dealer-id-plugin', 'Dealer_ID_Update_Command');
}
