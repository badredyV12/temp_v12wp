<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Main_Image_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'main image';
    }

    public function get_title()
    {
        return esc_html__('Main Image', 'essential-elementor-widget');
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
        return ['image', "v12", "main image"];
    }

    protected function render()
    {
        // Get the post ID of the current page/post.
        $post_id = get_the_ID();
        $photo = get_field('photo', $post_id);
        $photo_path = get_field("photo_path", $post_id);
        $photoData = unserialize($photo['photos']); // Unserialize the serialized data

        if (is_array($photoData)) {
            foreach ($photoData as $photoInfo) {
                $photoFilename = $photoInfo['photo'];
                $photoUrl = rtrim($photo_path, '/') . '/' . $photoFilename; // Concatenate the path and filename
                echo '<img src="' . $photoUrl . '" />';
            }
        }


        wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
        wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array('jquery'), '', true);;
        wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    }


}