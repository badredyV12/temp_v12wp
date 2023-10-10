<?php
/**
 * Plugin Name: V12 Config Tweaks
 * Description: Adds custom configurations to wp-config.php.
 * Version:     1.0.0
 * Author:      Badr eddine rahali
 */

function v12_add_config_tweaks() {
    $wp_config_path = ABSPATH . 'wp-config.php';
    $custom_config = "
    
define( 'WP_DEBUG_LOG', true );
define( 'AUTOSAVE_INTERVAL', 86400 ); // Set autosave interval to 1x per year
define( 'EMPTY_TRASH_DAYS', 0 ); // Empty trash now: Zero days
define( 'WP_POST_REVISIONS', false ); // Do not save any revisions

";

    $wp_config_content = file_get_contents($wp_config_path);

    $start_comment = '/* Add any custom values between this line and the "stop editing" line. */';
    $end_comment = '/* That\'s all, stop editing! Happy publishing. */';

    $start_position = strpos($wp_config_content, $start_comment);
    $end_position = strpos($wp_config_content, $end_comment);

    if ($start_position !== false && $end_position !== false) {
        $insert_position = $start_position + strlen($start_comment);
        $new_wp_config_content = substr_replace($wp_config_content, $custom_config, $insert_position, $end_position - $insert_position);
        file_put_contents($wp_config_path, $new_wp_config_content);
    }
}

function v12_remove_config_tweaks() {
    $wp_config_path = ABSPATH . 'wp-config.php';
    $custom_config = "
    
define( 'WP_DEBUG_LOG', true );
define( 'AUTOSAVE_INTERVAL', 86400 ); // Set autosave interval to 1x per year
define( 'EMPTY_TRASH_DAYS', 0 ); // Empty trash now: Zero days
define( 'WP_POST_REVISIONS', false ); // Do not save any revisions

";

    $wp_config_content = file_get_contents($wp_config_path);

    // Remove the custom config tweaks if they exist
    $modified_config = str_replace($custom_config, '', $wp_config_content);

    // Write back the modified config to the file
    file_put_contents($wp_config_path, $modified_config);
}

//function v12_remove_plugin() {
//    v12_remove_config_tweaks();
//}

add_action('init', 'v12_add_config_tweaks');
register_deactivation_hook(__FILE__, 'v12_remove_config_tweaks');
register_uninstall_hook(__FILE__, 'v12_remove_config_tweaks');