<?php

class Slider_Vdp_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_style('ask-question-css', $widget_folder_url . 'styles/ask-question.css');
        wp_register_style('slider-vdp-widget-css', $widget_folder_url . 'styles/slider-swiper.css');
        wp_register_style('swiper-bundle-widget-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.8.4/swiper-bundle.min.css');
        wp_enqueue_style('ask-question-css');
        wp_enqueue_style('slider-vdp-widget-css');
        wp_enqueue_style('swiper-bundle-widget-css');
    }
    public function get_script_depends()
    {
        return ['lead-widget-js'];
    }

    public function get_style_depends()
    {
        return ['ask-question-css', 'slider-vdp-widget-css', 'swiper-bundle-widget-css'];
    }
    public function get_name()
    {
        return 'slider-vdp-widget';
    }

    public function get_title()
    {
        return esc_html__('Slider VDP Widget', 'v12-essential-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-code'; // Icon for your widget
    }

    public function get_categories()
    {
        return ['v12-essential-elementor-widgets'];
    }


    protected function register_controls()
    {
        $primary_color =  \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY;

        $this->start_controls_section(
            'form_buttons_styles_section',
            [
                'label' => esc_html__('Form Buttons Styles', 'textdomain'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'submit_background_color',
            [
                'label' => esc_html__('Submit Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .form-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submit_hover_background_color',
            [
                'label' => esc_html__('Submit Hover Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .form-submit:hover' => 'background-color: {{SUBMIT_HOVER_BACKGROUND_COLOR}};',
                ],
            ]
        );

        $this->add_control(
            'submit_text_color',
            [
                'label' => esc_html__('Text Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .form-submit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'label' => esc_html__('Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .form-submit',
            ]
        );

        $this->add_control(
            'submit_button_width',
            [
                'label' => esc_html__('Button Width', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .form-submit' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Additional controls for .form-submit
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'label' => esc_html__('Button Border', 'textdomain'),
                'selector' => '{{WRAPPER}} .form-submit',
                'default' => [
                    'border-width' => '1px',    // Default border width
                    'border-style' => 'solid', // Default border style
                    'border-color' => $primary_color, // Default border color
                ],
            ]
        );

        $this->add_control(
            'submit_border_radius',
            [
                'label' => esc_html__('Button Border Radius', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .form-submit' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'submit_padding',
            [
                'label' => esc_html__('Button Padding', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .form-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
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
            $vehicle_photos = json_decode($vehicle_photos, true);

            $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
            $post_id = get_the_ID();
            $post_slug = get_post_field('post_name', $post_id);
            // $vehicle_photos = ["https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531232.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531232.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531233.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531234.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531234.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531235.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531236.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531236.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531237.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531238.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531238.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531239.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531240.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531241.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531241.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531242.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531243.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531243.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531244.jpg","https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/12/8750/1694531245.jpg"];

            // Begin HTML markup
?>
            <div class="swiper-container slider">
                <div class="swiper-wrapper">
                    <?php foreach ($vehicle_photos as $photo) : ?>
                        <div class="swiper-slide modal-trigger">
                            <img src=<?php echo esc_html($photo); ?> alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="swiper-container slider-thumbnail">
                <div class="swiper-wrapper">
                    <?php foreach ($vehicle_photos as $photo) : ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_html($photo); ?>" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- start modal  -->
            <div id="ask-modal" class="ask-modal">
                <div class="ask-modal-content">
                    <div class="ask-modal-header">
                        <img class="ask-modal-logo" width="100" src=<?php echo esc_url(plugins_url('/images/logo.svg', __FILE__)); ?>>
                            <a class="agent-phone" href="tel:(209)%20362-3099">
                                <img src="<?php echo esc_url(plugins_url('/images/telephone.svg', __FILE__)); ?>"> 
                                <span>(209) 362-3099</span>
                            </a>
                        <span class="close-modal">&times;</span>
                    </div>
                    <div class="ask-modal-body">
                        <!-- start swiper  -->
                        <div class="swiper-container sliderModal">
                            <div class="swiper-wrapper">
                                <?php foreach ($vehicle_photos as $photo) : ?>
                                    <div class="swiper-slide">
                                        <img src=<?php echo esc_html($photo); ?> alt="">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <!-- end swiper  -->
                        <!-- start contact form -->
                        <div id="ask-form-container" class="form-ask-side">
                            <div class="fs-title">
                                <h5 class="tablinks">Send a message</h5>
                            </div>
                            <form id="ask-question-form" class="fs-content lead-form">
                                <input type="hidden" name="type_id" value="4" />
                                <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />
                                <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">
                                    <div class="group">
                                        <input type="text" title="First name" name="first_name" placeholder=" " class="first_name form-input">
                                        <label>First Name</label><span class="input-error-req d-none">First name required.</span>
                                    </div>
                                    <div class="group">
                                        <input type="text" title="Last name" placeholder=" " name="last_name" class="last_name form-input">
                                        <label>Last Name</label><span class="input-error-req d-none">Last name required.</span>
                                    </div>
                                    <div class="group">
                                        <input type="email" title="E-mail" placeholder=" " name="email" class="email form-input">
                                        <label>Email address</label><span class="input-error-req d-none">Email address required.</span>
                                    </div>
                                    <div class="group">
                                        <input type="Tel" title="Phone Number" id="phone-vdp-widget" placeholder=" " name="phone" class="phone form-input" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                        <label>Phone Number </label><span class="input-error-req d-none">Phone Number required.</span>
                                    </div>
                                    <div class="group">
                                        <textarea type="text" title="Message" name="options[question]" rows="10" class="question form-input" placeholder=" "></textarea>
                                        <label>Enter your message here</label>
                                        <span class="input-error-req d-none">Message required.</span>
                                    </div>
                               
                                <div class="submit-group">
                                    <button type="button" class="btn-send form-submit">Send</button>
                                </div>
                            </form>
                            <div id="response-message"></div>
                            <div id="loader" style="display: none;">Submitting...</div>
                        </div>
                        <!-- end contact form  -->
                    </div>
                </div>
            </div>
            <!-- end modal -->

            <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
            <script>
                // Initialize the Swiper slider here using JavaScript
                var sliderThumbnail = new Swiper('.slider-thumbnail', {
                    slidesPerView: 4,
                    breakpoints: {
                        768: {
                            slidesPerView: 6, // Set to 4 slides per view on screens with width 768 pixels or more (desktop)
                        }
                    },

                    freeMode: true,
                    watchSlidesVisibility: true,
                    watchSlidesProgress: true
                });

                var slider = new Swiper('.slider', {
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    thumbs: {
                        swiper: sliderThumbnail
                    }
                });
                var sliderModal = new Swiper('.sliderModal', {
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    }
                });

                jQuery(document).ready(function($) {

                    $('.modal-trigger').click(function() {
                        var cliked_image = $(this).find('img').attr('src');

                        $(".ask-modal-content .swiper-slide").each(function(index, element) {
                            var image = $(element).find('img').attr('src');
                            if (cliked_image == image) {
                                changeActiveSlide(index);
                                return false;
                            }

                        });
                        $('#ask-modal').fadeIn();
                    });

                    // Close the modal when the close button is clicked
                    $('.close-modal').click(function() {
                        $('#ask-modal').fadeOut();
                    });
                });

                function changeActiveSlide(index) {
                    // Use Swiper's built-in methods to change the active slide
                    sliderModal.slideTo(index); // Change to the desired slide index
                }
            </script>
            <?php include(plugin_dir_path(__FILE__) . 'popup.php'); ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php
            // End HTML markup
        } else {
            echo 'No posts found.';
        }
    }
}
