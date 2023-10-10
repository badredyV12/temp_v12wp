<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_VERSION', '2.8.1');

if (!isset($content_width)) {
    $content_width = 800; // Pixels.
}

if (!function_exists('hello_elementor_setup')) {
    /**
     * Set up theme support.
     *
     * @return void
     */
    function hello_elementor_setup()
    {
        if (is_admin()) {
            hello_maybe_update_theme_version_in_db();
        }

        if (apply_filters('hello_elementor_register_menus', true)) {
            register_nav_menus(['menu-1' => esc_html__('Header', 'hello-elementor')]);
            register_nav_menus(['menu-2' => esc_html__('Footer', 'hello-elementor')]);
        }

        if (apply_filters('hello_elementor_post_type_support', true)) {
            add_post_type_support('page', 'excerpt');
        }

        if (apply_filters('hello_elementor_add_theme_support', true)) {
            add_theme_support('post-thumbnails');
            add_theme_support('automatic-feed-links');
            add_theme_support('title-tag');
            add_theme_support(
                'html5',
                [
                    'search-form',
                    'comment-form',
                    'comment-list',
                    'gallery',
                    'caption',
                    'script',
                    'style',
                ]
            );
            add_theme_support(
                'custom-logo',
                [
                    'height' => 100,
                    'width' => 350,
                    'flex-height' => true,
                    'flex-width' => true,
                ]
            );

            /*
             * Editor Style.
             */
            add_editor_style('classic-editor.css');

            /*
             * Gutenberg wide images.
             */
            add_theme_support('align-wide');

            /*
             * WooCommerce.
             */
            if (apply_filters('hello_elementor_add_woocommerce_support', true)) {
                // WooCommerce in general.
                add_theme_support('woocommerce');
                // Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
                // zoom.
                add_theme_support('wc-product-gallery-zoom');
                // lightbox.
                add_theme_support('wc-product-gallery-lightbox');
                // swipe.
                add_theme_support('wc-product-gallery-slider');
            }
        }
    }
}
add_action('after_setup_theme', 'hello_elementor_setup');

function hello_maybe_update_theme_version_in_db()
{
    $theme_version_option_name = 'hello_theme_version';
    // The theme version saved in the database.
    $hello_theme_db_version = get_option($theme_version_option_name);

    // If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
    if (!$hello_theme_db_version || version_compare($hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<')) {
        update_option($theme_version_option_name, HELLO_ELEMENTOR_VERSION);
    }
}

if (!function_exists('hello_elementor_scripts_styles')) {
    /**
     * Theme Scripts & Styles.
     *
     * @return void
     */
    function hello_elementor_scripts_styles()
    {
        $min_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        if (apply_filters('hello_elementor_enqueue_style', true)) {
            wp_enqueue_style(
                'hello-elementor',
                get_template_directory_uri() . '/style' . $min_suffix . '.css',
                [],
                HELLO_ELEMENTOR_VERSION
            );
        }

        if (apply_filters('hello_elementor_enqueue_theme_style', true)) {
            wp_enqueue_style(
                'hello-elementor-theme-style',
                get_template_directory_uri() . '/theme' . $min_suffix . '.css',
                [],
                HELLO_ELEMENTOR_VERSION
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'hello_elementor_scripts_styles');

if (!function_exists('hello_elementor_register_elementor_locations')) {
    /**
     * Register Elementor Locations.
     *
     * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
     *
     * @return void
     */
    function hello_elementor_register_elementor_locations($elementor_theme_manager)
    {
        if (apply_filters('hello_elementor_register_elementor_locations', true)) {
            $elementor_theme_manager->register_all_core_location();
        }
    }
}
add_action('elementor/theme/register_locations', 'hello_elementor_register_elementor_locations');

if (!function_exists('hello_elementor_content_width')) {
    /**
     * Set default content width.
     *
     * @return void
     */
    function hello_elementor_content_width()
    {
        $GLOBALS['content_width'] = apply_filters('hello_elementor_content_width', 800);
    }
}
add_action('after_setup_theme', 'hello_elementor_content_width', 0);

if (is_admin()) {
    require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
 */

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
 */
function hello_register_customizer_functions()
{
    if (is_customize_preview()) {
        require get_template_directory() . '/includes/customizer-functions.php';
    }
}

add_action('init', 'hello_register_customizer_functions');

if (!function_exists('hello_elementor_check_hide_title')) {
    /**
     * Check hide title.
     *
     * @param bool $val default value.
     *
     * @return bool
     */
    function hello_elementor_check_hide_title($val)
    {
        if (defined('ELEMENTOR_VERSION')) {
            $current_doc = Elementor\Plugin::instance()->documents->get(get_the_ID());
            if ($current_doc && 'yes' === $current_doc->get_settings('hide_title')) {
                $val = false;
            }
        }
        return $val;
    }
}
add_filter('hello_elementor_page_title', 'hello_elementor_check_hide_title');

if (!function_exists('hello_elementor_add_description_meta_tag')) {
    /**
     * Add description meta tag with excerpt text.
     *
     * @return void
     */
    function hello_elementor_add_description_meta_tag()
    {
        $post = get_queried_object();

        if (is_singular() && !empty($post->post_excerpt)) {
            echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($post->post_excerpt)) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'hello_elementor_add_description_meta_tag');

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if (!function_exists('hello_elementor_body_open')) {
    function hello_elementor_body_open()
    {
        wp_body_open();
    }
}

// Start : Function for element search form
function get_vehicle_models_callback()
{
    global $wpdb;

    $selected_make = sanitize_text_field($_POST['make']);

    $vehicles_query = "SELECT DISTINCT pm.meta_value AS model
					  FROM {$wpdb->prefix}postmeta pm
					  JOIN {$wpdb->prefix}postmeta pm_make ON pm.post_id = pm_make.post_id
					  WHERE pm_make.meta_key = 'make'
						AND pm_make.meta_value = %s
						AND pm.meta_key = 'model'";

    $vehicles = $wpdb->get_results($wpdb->prepare($vehicles_query, $selected_make));

    if (!empty($vehicles)) {
//		echo '<h2>Models for ' . esc_html( $selected_make ) . ':</h2>';
        echo '<select>';
        echo '<option>select model</option>';

        foreach ($vehicles as $vehicle) {
            echo '<option>' . esc_html($vehicle->model) . '</option>';
        }
        echo '</select>';
    } else {
        echo '<p>No models found for ' . esc_html($selected_make) . '.</p>';
    }

    die();
}
add_action('wp_ajax_get_vehicle_models', 'get_vehicle_models_callback');
add_action('wp_ajax_nopriv_get_vehicle_models', 'get_vehicle_models_callback');
// END : Function for element search form


// Start : Function to delete all post meta when a post is deleted
// Add an action hook to delete post meta when a post is deleted
add_action('before_delete_post', 'delete_all_post_meta');
function delete_all_post_meta($post_id)
{
    // Get all post meta keys for the given post
    $meta_keys = get_post_custom_keys($post_id);

    // If there are meta keys, delete them
    if ($meta_keys) {
        foreach ($meta_keys as $meta_key) {
            delete_post_meta($post_id, $meta_key);
        }
    }
}
// END : Function to delete all post meta when a post is deleted


// Start : Function to hide the title on all pages
//function hide_title_on_pages($title, $id = null) {
//    if (is_page()) {
//        return ''; // Return an empty title to hide it
//    }
//    return $title; // Return the original title
//}
//add_filter('the_title', 'hide_title_on_pages', 10, 2);
// END : Function to hide the title on all pages



// START : Function to display dealer_id set or not
function display_dealer_id_notice() {
    $dealer_id = get_option('dealer_id');

    if ($dealer_id) {
        echo '<div class="notice notice-success">
            <p>Dealer ID: ' . esc_html($dealer_id) . '</p>
        </div>';
    } else {
        echo '<div class="notice notice-error">
            <p style="color: red;">Dealer ID not set yet.</p>
        </div>';
    }
}
add_action('admin_notices', 'display_dealer_id_notice');
// END : Function to display dealer_id set or not

// START : Ajax filter inventory
// Enqueue JavaScript for AJAX
function enqueue_inventory_ajax_script() {
    wp_enqueue_script('inventory-ajax', get_template_directory_uri() . '/js/inventory-ajax.js', array('jquery'), null, true);
    wp_localize_script('inventory-ajax', 'inventory_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_inventory_ajax_script');

// AJAX handler for search
function inventory_search_callback() {
    $search_term = sanitize_text_field($_POST['search_term']);

    $args = array(
        'post_type' => 'vehicle',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'year',
                'value' => $search_term,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'make',
                'value' => $search_term,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'model',
                'value' => $search_term,
                'compare' => 'LIKE'
            ),
        )
    );

    $query = new \WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . get_the_title() . "</h5>";
            echo "<a href='".get_permalink()."'>details</a>";
            echo "</div>";
            echo "</div>";
        }
        wp_reset_postdata();
    } else {
        echo "No vehicles found.";
    }

    wp_die(); // Terminate the AJAX request
}
add_action('wp_ajax_inventory_search', 'inventory_search_callback');
add_action('wp_ajax_nopriv_inventory_search', 'inventory_search_callback');
// END : Ajax filter inventory
// 
// 
// 
function remove_google_fonts() {
    wp_dequeue_style('Poppins');
    //wp_dequeue_style('roboto');
}

add_action('wp_enqueue_scripts', 'remove_google_fonts', 100);


// START : Function to display dealer_id set or not
function display_dealer_id_notice()
{
   $dealer_id = get_option('dealer_id');

   if ($dealer_id) {
      echo '<div class="notice notice-success">
            <p>Dealer ID: ' . esc_html($dealer_id) .  '</p>
        </div>';
   } else {
      echo '<div class="notice notice-error">
            <p style="color: red;">Dealer ID not set yet.</p>
        </div>';
   }
}

add_action('admin_notices', 'display_dealer_id_notice');
// END : Function to display dealer_id set or not


// START : Delete all linked images for deleted post  (not working yet)

// Hook into the post deletion process
// Hook into the post deletion process
add_action('before_delete_post', 'delete_linked_media');

function delete_linked_media($post_id)
{
   $attachments = get_attached_media('', $post_id);
   foreach ($attachments as $attachment) {
      wp_delete_attachment($attachment->ID, true);
   }
}

// END : Delete all linked images for deleted post

// START : Add a custom field to pages named 'pwa_page_id'

function add_pwa_page_id_custom_field()
{
   add_meta_box(
      'pwa_page_id_custom_field',
      'PWA Page ID',
      'render_pwa_page_id_custom_field',
      'page', // Add custom field to pages
      'normal',
      'default'
   );
}

// Render the custom field
function render_pwa_page_id_custom_field($post)
{
   // Get the current value of the custom field, if it exists
   $pwa_page_id = get_post_meta($post->ID, 'pwa_page_id', true);
   ?>
   <label for="pwa_page_id">PWA Page ID:</label>
   <input type="text" id="pwa_page_id" name="pwa_page_id" value="<?php echo esc_attr($pwa_page_id); ?>"/>
   <?php
}

// Save the custom field value when the page is updated or published
function save_pwa_page_id_custom_field($post_id)
{
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

   if (isset($_POST['pwa_page_id'])) {
      $pwa_page_id = sanitize_text_field($_POST['pwa_page_id']);
      update_post_meta($post_id, 'pwa_page_id', $pwa_page_id);
   }
}

// Hook the custom field functions into WordPress
add_action('add_meta_boxes', 'add_pwa_page_id_custom_field');
add_action('save_post', 'save_pwa_page_id_custom_field');

// END : Add a custom field to pages named 'pwa_page_id'

// START : add id vehicle to url
function custom_vehicles_rewrite_rules() {
   add_rewrite_rule(
      '^vehicles/([0-9]+)/([^/]+)/?$',
      'index.php?post_type=vehicles&name=$matches[2]&id=$matches[1]',
      'top'
   );
}
add_action('init', 'custom_vehicles_rewrite_rules');

function custom_vehicles_post_type_link($permalink, $post) {
   if ($post->post_type == 'vehicles') {
      $id = get_post_meta($post->ID, 'id', true);
      if (!empty($id)) {
         $permalink = home_url("/vehicles/{$id}/{$post->post_name}/");
      }
   }
   return $permalink;
}
add_filter('post_type_link', 'custom_vehicles_post_type_link', 10, 2);

// END : add id vehicle to url


// Start : Redis
function loadRedisAndDotEnv(){
    require_once ABSPATH . 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(ABSPATH);
    $dotenv->load();
    //Redis Config
    $redisConfig =[
        'scheme' => "tcp",
        'host' => $_ENV['WP_REDIS_HOST'],
        'port' => $_ENV['WP_REDIS_PORT'],
        'password' => $_ENV['WP_REDIS_PASSWORD'],
        'database' => 1,
        'cluster' => 'redis',
    ];
    global $redis;
    global $use_redis;
    try {
        $redis = new Predis\Client($redisConfig);
        $redis->connect();
        $use_redis = true;
        error_log("Redis connection successful.");
    } catch (Predis\Connection\ConnectionException $e) {
        error_log("Redis connection error.");
        $use_redis = false;
    }
}

add_action('init', 'loadRedisAndDotEnv');
// Start : Redis