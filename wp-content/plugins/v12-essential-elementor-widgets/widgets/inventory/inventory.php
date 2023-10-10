<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Inventory_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'inventory';
    }

    public function get_title()
    {
        return esc_html__('Inventory', 'essential-elementor-widget');
    }

    public function get_icon()
    {
        return 'eicon-header';
    }

    public function get_custom_help_url()
    {
        return 'https://exapmple.com/';
    }

    public function get_categories()
    {
        return ["general"];
    }

    public function get_keywords()
    {
        return ['inventory', "v12"];
    }


    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        // Widget settings
        $this->widget_title = 'Essential Elementor Inventory Widget';
        $this->widget_description = 'Display inventory items with Bootstrap styling.';
        // Enqueue Bootstrap CSS
        wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

    }


    protected function render()
    {
        echo "<input type='search' id='search-input' placeholder='Search by year or make'>";
        echo '<input id="price_range"  min="5" max="10"  type="range"   class="form-range" />';
        echo "<div id='vehicle-list'>";

        // Query and display all data initially
        $args = array(
            'post_type' => 'vehicle',
            'posts_per_page' => -1,
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

        echo "</div>";
    }



}
