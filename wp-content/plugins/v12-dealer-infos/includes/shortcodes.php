<?php
// Display the custom data page
function v12_dealer_info_page() {
    $options = get_option('custom_data');

    // Handle adding a new key-value pair
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $new_key = sanitize_text_field($_POST['custom_key']);
        $new_value = sanitize_text_field($_POST['custom_value']);

        if (!empty($new_key)) {
            $existing_keys = !empty($options['key']) ? $options['key'] : [];

            // Check if the key already exists
            if (!in_array($new_key, $existing_keys)) {
                $options['key'][] = $new_key;
                $options['value'][] = $new_value; // This can be an empty string
                update_option('custom_data', $options);
                echo '<div class="updated"><p>Key-Value pair added successfully.</p></div>';
            } else {
                echo '<div class="error"><p>Key already exists. Please use a unique key.</p></div>';
            }
        } else {
            echo '<div class="error"><p>Key is required.</p></div>';
        }
    }


    // Handle deleting key-value pairs
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['index'])) {
        $index = intval($_GET['index']);
        if (isset($options['key'][$index])) {
            unset($options['key'][$index]);
            unset($options['value'][$index]);
            $options['key'] = array_values($options['key']);
            $options['value'] = array_values($options['value']);
            update_option('custom_data', $options);
            echo '<div class="updated"><p>Key-Value pair deleted successfully.</p></div>';
            // Use JavaScript to redirect to the index page after deletion
            echo '<script>window.location.href = "' . admin_url('admin.php?page=v12-dealer-info') . '";</script>';
        }
    }

    // Handle updating key-value pairs
    if (isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['index'])) {
        $index = intval($_POST['index']);
        $updated_key = sanitize_text_field($_POST['custom_key']);
        $updated_value = sanitize_text_field($_POST['custom_value']);

        if (isset($options['key'][$index])) {
            $options['key'][$index] = $updated_key;
            $options['value'][$index] = $updated_value;
            update_option('custom_data', $options);
            echo '<div class="updated"><p>Key-Value pair updated successfully.</p></div>';
            // Use JavaScript to redirect to the index page after updating
            echo '<script>window.location.href = "' . admin_url('admin.php?page=v12-dealer-info') . '";</script>';
        }
    }
    ?>
    <div class="wrap">
        <h2>V12 Dealer Info</h2>
        <form method="post" action="">
            <input type="hidden" name="action" value="add">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Key</th>
                    <td><input type="text" name="custom_key" value="" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Value</th>
                    <td><input type="text" name="custom_value" value="" /></td>
                </tr>
            </table>
            <?php submit_button('Add Key-Value Pair'); ?>
        </form>
        <h3>Existing Key-Value Pairs</h3>
        <table class="wp-list-table widefat fixed striped">
            <thead>
            <tr>
                <th scope="col">Key</th>
                <th scope="col">Value</th>
                <th scope="col">Shortcode</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($options) && is_array($options['key'])) {
                foreach ($options['key'] as $index => $key) {
                    $value = isset($options['value'][$index]) ? $options['value'][$index] : '';
                    echo '<tr>';
                    echo '<td>' . esc_html($key) . '</td>';
                    echo '<td>' . esc_html($value) . '</td>';
                    echo '<td>[v12_dealer_data key="' . esc_attr($key) . '"]</td>';
                    echo '<td><a href="?page=v12-dealer-info&action=edit&index=' . $index . '">Edit</a> | <a href="?page=v12-dealer-info&action=delete&index=' . $index . '" onclick="return confirmDelete(' . $index . ');">Delete</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">No key-value pairs defined yet.</td></tr>';
            }
            ?>
            </tbody>
        </table>

        <?php
        if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['index'])) {
            $index = intval($_GET['index']);
            if (isset($options['key'][$index])) {
                $edit_key = $options['key'][$index];
                $edit_value = isset($options['value'][$index]) ? $options['value'][$index] : '';
                ?>
                <h3>Edit Key-Value Pair</h3>
                <form method="post" action="">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">Key</th>
                            <td><input type="text" name="custom_key" value="<?php echo esc_attr($edit_key); ?>" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Value</th>
                            <td><input type="text" name="custom_value" value="<?php echo esc_attr($edit_value); ?>" /></td>
                        </tr>
                    </table>
                    <?php submit_button('Update Key-Value Pair'); ?>
                </form>
                <?php
            }
        }
        ?>
    </div>
    <script>
        // JavaScript to handle deletion confirmation
        function confirmDelete(index) {
            return confirm("Are you sure you want to delete this key-value pair?");
        }
    </script>
    <?php
}

// Shortcode to display custom data
function v12_dealer_data_shortcode($atts) {
    $options = get_option('custom_data');
    $key = isset($atts['key']) ? sanitize_key($atts['key']) : '';
    if (!empty($options) && is_array($options['key']) && in_array($key, $options['key'])) {
        $index = array_search($key, $options['key']);
        $value = isset($options['value'][$index]) ? $options['value'][$index] : '';
        return esc_html($value);
    } else {
        return 'Key not found';
    }
}

// Function to redirect to the index page
function redirect_to_index() {
    $redirect_url = admin_url('admin.php?page=v12-dealer-info');
    wp_redirect($redirect_url);
    exit;
}


add_shortcode('v12_dealer_data', 'v12_dealer_data_shortcode');