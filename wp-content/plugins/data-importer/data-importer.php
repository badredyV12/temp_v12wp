<?php
/**
 * Plugin Name: Data Importer
 * Version: 1.0
 * Author: Badr eddine rahali
 * Description: Import demo data, pages, and posts.
 */


// Include necessary files
require_once(plugin_dir_path(__FILE__) . 'includes/page-creator.php');
require_once(plugin_dir_path(__FILE__) . 'includes/data-importer.php');

//  Import Functionality
function my_demo_import_demo_data(): bool
{
    //create_demo_pages(); // Call the page creation function
    $dealer_id = get_option('dealer_id');
    if (empty($dealer_id)) {
        if (defined('WP_CLI') && WP_CLI) {
            $error_message = "Importing failed: Dealer ID is missing.";
            WP_CLI::error($error_message, $exit = true);
        }
    }
    import_demo_data(); // Call the data import function
    return true;
}

// Create an Import Settings Page
add_action('admin_menu', 'my_demo_importer_add_settings_page');

function my_demo_importer_add_settings_page()
{
    add_menu_page(
        'Demo Importer',
        'Demo Importer',
        'manage_options',
        'data-importer-settings',
        'my_demo_importer_settings_page'
    );
}

function my_demo_importer_settings_page()
{
    ?>
    <div class="wrap">
        <h1>Demo Importer V12</h1>
        <form method="post">
            <?php wp_nonce_field('data-importer-nonce', 'data-importer-nonce'); ?>
            <input type="submit" name="import_demo_data" class="button" value="Import Demo Data">
        </form>
    </div>
    <?php
}

//  Implement the Import Logic
add_action('admin_init', 'my_demo_importer_handle_import');

function my_demo_importer_handle_import()
{
    if (isset($_POST['import_demo_data']) && check_admin_referer('data-importer-nonce', 'data-importer-nonce')) {
        my_demo_import_demo_data();
    }
}

if (defined('WP_CLI') && WP_CLI) {
    class My_Demo_Import_Command
    {
        public function import_demo_data()
        {
            if (my_demo_import_demo_data()) {
                WP_CLI::success('Demo data imported successfully.');
            } else {
                WP_CLI::error("Importing failed", $exit = true);
            }
        }
    }
    WP_CLI::add_command('my-demo-import-command', 'My_Demo_Import_Command');
}
