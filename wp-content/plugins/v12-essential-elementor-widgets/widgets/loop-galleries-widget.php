<?php

class Loop_Galleries_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        // wp_register_style('slider-vdp-widget-css', $widget_folder_url . 'styles/slider-swiper.css');
        wp_register_style('swiper-bundle-widget-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.8.4/swiper-bundle.min.css');
        // wp_enqueue_style('slider-vdp-widget-css');
        wp_enqueue_style('swiper-bundle-widget-css');
    }

    public function get_style_depends() {
        return [ 'swiper-bundle-widget-css' ];
     }

    public function get_name()
    {
        return 'loop-galleries-widget';
    }

    public function get_title()
    {
        return esc_html__('Loop Galleries Widget', 'v12-essential-elementor-widgets');
    }

    public function get_icon() {
        return 'eicon-carousel-loop'; // Icon for your widget
    }

    public function get_categories()
    {
        return ['v12-elementor-widgets'];
    }
    protected function register_controls() {

        // Controls in the existing "style_section" (if it exists)
    
        $this->start_controls_section(
            'custom_styles_section',
            [
                'label' => esc_html__('Custom Styles', 'textdomain'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        // Controls for .swiper-pagination-bullets.swiper-pagination-horizontal
        $this->add_control(
            'pagination_margin_bottom',
            [
                'label' => esc_html__('Pagination Margin Bottom', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets.swiper-pagination-horizontal' => 'margin-bottom: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        // Controls for .swiper-pagination-bullet-active
        $this->add_control(
            'active_bullet_background_color',
            [
                'label' => esc_html__('Active Bullet Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    
        // Controls for img
        $this->add_control(
            'img_width',
            [
                'label' => esc_html__('Image Width', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '100',
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        // Controls for .elementor-element .elementor-widget-container .swiper-container
        $this->add_control(
            'swiper_container_overflow',
            [
                'label' => esc_html__('Swiper Container Overflow', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'hidden',
                'options' => [
                    'hidden' => esc_html__('Hidden', 'textdomain'),
                    'visible' => esc_html__('Visible', 'textdomain'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-element .elementor-widget-container .swiper-container' => 'overflow: {{VALUE}};',
                ],
            ]
        );
    
        // Controls for .swiper-container
        $this->add_control(
            'swiper_container_width',
            [
                'label' => esc_html__('Swiper Container Width', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '100',
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        // Controls for .swiper-container.slider
        $this->add_control(
            'slider_height',
            [
                'label' => esc_html__('Slider Height', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '80',
                    'unit' => 'vh',
                ],
                'range' => [
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container.slider' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        // Controls for .swiper-free-mode>.swiper-wrapper
        $this->add_control(
            'free_mode_grid_gap',
            [
                'label' => esc_html__('Free Mode Grid Gap', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '2',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-free-mode>.swiper-wrapper' => 'grid-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        // Controls for .swiper-container.slider-thumbnail
        $this->add_control(
            'thumbnail_slider_height',
            [
                'label' => esc_html__('Thumbnail Slider Height', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '20',
                    'unit' => 'vh',
                ],
                'range' => [
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container.slider-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        // Controls for .swiper-container.slider-thumbnail .swiper-wrapper .swiper-slide
        $this->add_control(
            'thumbnail_slide_width',
            [
                'label' => esc_html__('Thumbnail Slide Width', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '25',
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container.slider-thumbnail .swiper-wrapper .swiper-slide' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_control(
            'thumbnail_slide_opacity',
            [
                'label' => esc_html__('Thumbnail Slide Opacity', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '0.5',
                    'unit' => '',
                ],
                'range' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.01,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container.slider-thumbnail .swiper-wrapper .swiper-slide' => 'opacity: {{SIZE}};',
                ],
            ]
        );
    
        // Controls for .swiper-container.slider-thumbnail .swiper-wrapper .swiper-slide.swiper-slide-thumb-active
        $this->add_control(
            'thumbnail_slide_active_opacity',
            [
                'label' => esc_html__('Active Thumbnail Slide Opacity', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '1',
                    'unit' => '',
                ],
                'range' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.01,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container.slider-thumbnail .swiper-wrapper .swiper-slide.swiper-slide-thumb-active' => 'opacity: {{SIZE}};',
                ],
            ]
        );
    
        // Controls for .swiper-button-next and .swiper-button-prev
        $this->add_control(
            'button_next_prev_color',
            [
                'label' => esc_html__('Next/Prev Button Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:after, {{WRAPPER}} .swiper-rtl .swiper-button-prev:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-button-prev:after, {{WRAPPER}} .swiper-rtl .swiper-button-next:after' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'button_next_prev_background_color',
            [
                'label' => esc_html__('Next/Prev Button Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0000005c',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'button_next_prev_border_radius',
            [
                'label' => esc_html__('Next/Prev Button Border Radius', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '100',
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        // Controls for responsive styles
        $this->add_responsive_control(
            'responsive_styles',
            [
                'label' => esc_html__('Responsive Styles', 'textdomain'),
                'type' => \Elementor\Controls_Manager::CODE,
                'language' => 'css',
                'selectors' => [
                    '{{WRAPPER}}' => '{{VALUE}}',
                ],
            ]
        );
    
        $this->end_controls_section();
    }
    
    public function render()
    {

        // Begin HTML markup
        global $post;
        if (isset($post)) {
            $post_url = get_permalink($post->ID);
        }

                // Set up a query to retrieve posts of the specified post type
                $args = array(
                    'post_type' => 'vehicles',
                    'posts_per_page' => -1, // To retrieve all posts of the specified type
                    // Add any other query parameters as needed
                );

                $vehicle_photo_query = new WP_Query($args);

                // Check if there are posts
                if ($vehicle_photo_query->have_posts()) {
                    // Retrieve the custom field value
                    $vehicle_photos = get_post_meta(get_the_ID(), 'photo_photos', true);
                    $vehicle_photos = json_decode($vehicle_photos,true);
                    // $vehicle_photos = ["https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531232.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531232.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531233.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531234.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531234.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531235.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531236.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531236.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531237.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531238.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531238.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531239.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531240.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531241.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531241.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531242.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531243.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531243.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531244.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531245.jpg"];

                 } else {
                    echo 'No posts found.';
                }
            ?>
            <div class="swiper-container loop">
                <div class="swiper-wrapper">
                <?php foreach ($vehicle_photos as $photo) : ?>
                    <div class="swiper-slide">
                        <a href=<?php echo esc_url($post_url)?>> 
                          <img src=<?php echo esc_html($photo); ?> alt="">
                       </a>
                   </div>
                <?php endforeach; ?>
                </div>
                  <!-- Pagination container -->
                <div class="swiper-pagination"></div>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script>
            // Initialize the Swiper slider here using JavaScript           
            var slider = new Swiper('.loop', {
                navigation: false,
                pagination: {
                    el: '.swiper-pagination', // This targets the container where pagination will be rendered
                    clickable: true, // Allow clicking on pagination dots to navigate
                },
            }); 

        </script>
        <?php
       // End HTML markup
    }
}