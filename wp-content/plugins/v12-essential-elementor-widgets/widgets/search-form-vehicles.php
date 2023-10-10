<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Search_Form_Vehicles_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'search_form_vehicles';
    }

    public function get_title()
    {
        return esc_html__('Search Form Vehicles', 'essential-elementor-widget');
    }

    public function get_icon()
    {
        return 'eicon-header';
    }

    protected function render()
    {
        ?>

        <form id="vehicle-search-form">
            <label for="make">Select Make:</label>
            <select name="make" id="make">
                <option >All makes</option>
                <?php
                global $wpdb;

                $makes_query = "SELECT DISTINCT pm_make.meta_value AS make
                FROM {$wpdb->prefix}postmeta pm_make
                WHERE pm_make.meta_key = 'make'
                ORDER BY make ASC";

                $makes = $wpdb->get_results($makes_query);

                foreach ($makes as $make) {
                    echo '<option value="' . esc_attr($make->make) . '">' . esc_html($make->make) . '</option>';
                }
                ?>
            </select>
        </form>

        <div id="vehicle-search-results"></div>

        <div id="loader" style="display: none;">Loading...</div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const makeDropdown = document.getElementById('make');
                const resultsDiv = document.getElementById('vehicle-search-results');
                const loader = document.getElementById('loader');

                makeDropdown.addEventListener('change', function () {
                    const selectedMake = makeDropdown.value;

                    if (selectedMake) {
                        loader.style.display = 'block';

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                resultsDiv.innerHTML = xhr.responseText;
                                loader.style.display = 'none';
                            }
                        };
                        xhr.send('action=get_vehicle_models&make=' + selectedMake);
                    }
                });
            });
        </script>
        <?php
    }


}



