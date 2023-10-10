<?php

class Slider_Vdp_Test_Drive_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url.'lead-form.js', ['jquery'], '1.1', true );
        wp_register_script('test-drive-btn-js', $widget_folder_url . 'script/test-drive-btn.js', ['jquery'], '1.1', true);
        wp_register_style('test-drive-css', $widget_folder_url . 'styles/test-drive.css');
        wp_register_style('slider-vdp-widget-css', $widget_folder_url . 'styles/slider-swiper.css');
        wp_register_style('swiper-bundle-widget-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.8.4/swiper-bundle.min.css');
        wp_enqueue_style('test-drive-css');
        wp_enqueue_style('slider-vdp-widget-css');
        wp_enqueue_style('swiper-bundle-widget-css');   

    }
    public function get_script_depends() {
        return [ 'lead-widget-js','lead-widget-js', 'test-drive-btn-js'];
    }

    public function get_style_depends() {
        return [ 'test-drive-css', 'slider-vdp-test-drive-widget-css', 'swiper-bundle-widget-css' ];
     }
    public function get_name()
    {
        return 'slider-vdp-test-drive-widget';
    }

    public function get_title()
    {
        return esc_html__('Slider VDP Test Drive Widget', 'v12-essential-elementor-widgets');
    }

    public function get_icon() {
        return 'eicon-carousel-loop'; // Icon for your widget
    }

    public function get_categories()
    {
        return ['v12-elementor-widgets'];
    }

    protected function register_controls()
    {
        // Controls in the existing "style_section" (if it exists)
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
                'selectors' => [
                    '{{WRAPPER}} .test-popup-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submit_hover_background_color',
            [
                'label' => esc_html__('Submit Hover Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .test-popup-btn:hover' => 'background-color: {{SUBMIT_HOVER_BACKGROUND_COLOR}};',
                ],
            ]
        );

        $this->add_control(
            'submit_text_color',
            [
                'label' => esc_html__('Text Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .test-popup-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submit_text_hover_color',
            [
                'label' => esc_html__('Text Hover Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .test-popup-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'label' => esc_html__('Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .test-popup-btn',
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
                'selectors' => [
                    '{{WRAPPER}} .test-popup-btn' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'label' => esc_html__('Border', 'textdomain'),
                'selector' => '{{WRAPPER}} .test-popup-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border_hover',
                'label' => esc_html__('Border on Hover', 'textdomain'),
                'selector' => '{{WRAPPER}} .test-popup-btn:hover',
            ]
        );


        $this->add_control(
            'submit_margin',
            [
                'label' => esc_html__('Margin', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .test-popup-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'submit_padding',
            [
                'label' => esc_html__('Padding', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .test-popup-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'available-days',
                'label' => esc_html__('available days Border', 'textdomain'),
                'selector' => '{{WRAPPER}} .available',
            ]
        );
        $this->add_control(
            'activated_background_color',
            [
                'label' => esc_html__('activated day Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .activated' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    public function render()
    {
            $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
            $post_id = get_the_ID();
            $post_slug = get_post_field('post_name', $post_id);
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
            // Begin HTML markup
            ?>
            <div class="swiper-container slider">
            <div class="swiper-wrapper">
                <?php foreach ($vehicle_photos as $photo) : ?>
                <div class="swiper-slide modal-trigger">
                    <img src="<?php echo esc_html($photo); ?>" alt="">   
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
            <div id="test-drive-modal" class="test-drive-modal">
            <div class="test-drive-modal-content">
                <div class="test-drive-modal-header">  
                    <img src="<?php echo esc_url(plugin_dir_url(__FILE__). "images/logo.svg"); ?>" alt="">
                    <span class="close-modal">&times;</span>
                </div>
                <div class="test-drive-modal-body">
                    <!-- start swiper  -->
                    <div class="swiper-container sliderModal">
                        <div class="swiper-wrapper">
                        <?php foreach ($vehicle_photos as $photo) : ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_html($photo); ?>" alt="">   
                        </div>
                        <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <!-- end swiper  -->
                    <!-- start test drive form -->
                    <div class="fs-container testdrive">
                        <div class="fs-title">
                        <h5>Book a test drive</h5>
                        <small>Please, select a date and time to book your test-drive.</small>
                        </div>
                        <form id="slider-test-drive-form" class="form lead-form slider-test-drive-form">
                        <div class="loading_form d-none" style="position: absolute; left: 40%;top: 30%;">
                            <img src="https://v12statics.s3.amazonaws.com/website/common/t52/assets/images/spinner-1.svg" alt="loader">
                        </div>
                        <div class="select-time-month">
                            <span class="btn-disabled prev-days" style="float: left;">
                                <i class=" block">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="14.8px" height="13.7px" viewBox="0 0 14.8 13.7" xml:space="preserve" class="svg_icon_prev_arrow icon">
                                    <g id="_x37__1_">
                                        <g>
                                            <path d="M13.8,5.8H3.2l4.1-4.1c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L0.3,5.9C0,6.2,0,6.5,0,6.8 C0,7.1,0,7.5,0.3,7.7l5.7,5.7c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4L3.2,7.8h10.6c0.6,0,1-0.4,1-1C14.8,6.3,14.4,5.8,13.8,5.8z "></path>
                                        </g>
                                    </g>
                                    </svg>
                                </i>
                            </span>
                            <span class="current-month"></span>
                            <span class="next-days rotate-180" style="float: right;">
                                <i class="chevron-outline-icon block transform ">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="14.8px" height="13.7px" viewBox="0 0 14.8 13.7" xml:space="preserve" class="svg_icon_prev_arrow_red icon">
                                    <defs></defs>
                                    <g id="_x37__1_">
                                        <g>
                                            <path d="M13.8,5.8H3.2l4.1-4.1c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L0.3,5.9C0,6.2,0,6.5,0,6.8 C0,7.1,0,7.5,0.3,7.7l5.7,5.7c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4L3.2,7.8h10.6c0.6,0,1-0.4,1-1C14.8,6.3,14.4,5.8,13.8,5.8z "></path>
                                        </g>
                                    </g>
                                    </svg>
                                </i>
                            </span>
                        </div>
                        <input type="hidden" name="type_id" value="5" />
                        <!-- <input type="hidden" name="vehicle_id" value="21" /> -->
                        <input type="hidden" name="category" value="6" />
                        <input type="hidden" name="source_id" value="1" />
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $dealer_id; ?>" />
                        <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">
                        <input type="hidden" id="due_time" name="due_time" value="" />
                        <input type="hidden" name="vehicle_id" class="popup-vehicle-id" value="">
                        <div class="step-1 d-none active">
                            <div class="test-drive-days ">
                                <div class="days">
                                    <div class="day-wrap-css">
                                    <span class="day day-label">Sun</span>
                                    <span class=" d-none text-lg full-date"></span>
                                    <label class="label-days Sun "></label>
                                    </div>
                                    <div class="day-wrap-css">
                                    <span class="day day-label ">Mon</span>
                                    <span class=" d-none text-lg full-date"></span>
                                    <label class="label-days Mon "></label>
                                    </div>
                                    <div class="day-wrap-css">
                                    <span class="day day-label ">Tue</span>
                                    <span class=" d-none text-lg full-date"></span>
                                    <label class="label-days Tue "></label>
                                    </div>
                                    <div class="day-wrap-css">
                                    <span class="day day-label ">Wed</span>
                                    <span class=" d-none text-lg full-date"></span>
                                    <label class="label-days Wed "></label>
                                    </div>
                                    <div class="day-wrap-css">
                                    <span class="day day-label ">Thu</span>
                                    <span class=" d-none text-lg full-date"></span>
                                    <label class="label-days Thu "></label>
                                    </div>
                                    <div class="day-wrap-css">
                                    <span class="day day-label ">Fri</span>
                                    <span class=" d-none text-lg full-date"></span>
                                    <label class="label-days Fri "></label>
                                    </div>
                                    <div class="day-wrap-css">
                                    <span class="day day-label ">Sat</span>
                                    <span class=" d-none text-lg full-date"></span>
                                    <label class="label-days Sat "></label>
                                    </div>
                                </div>
                            </div>
                            <div class="group d-none group-selected-time">
                                <select class="form-control selected-time selected_time_s form-input" title="Selected time" name="selected_time_s" id="slider-selected-time">
                                    <option></option>
                                </select>
                                <label for="selected-time">Selected time</label>
                                <span class="input-error-req d-none"></span>
                            </div>
                        </div>
                        <div class="step-2">
                            <div class="Cu-one">
                                <div class="group">
                                    <input type="text" title="First name" name="first_name" placeholder=" " class="first_name form-input">
                                    <label>First Name</label><span class="input-error-req d-none"></span>
                                </div>
                            </div>
                            <div class="Cu-one">
                                <div class="group">
                                    <input type="text" title="Last name" placeholder=" " name="last_name" class="last_name form-input">
                                    <label>Last Name</label><span class="input-error-req d-none"></span>
                                </div>
                            </div>
                        </div>
                        <div class="Cu-one">
                            <div class="group">
                                <input type="email" title="E-mail" placeholder=" " name="email" class="email form-input">
                                <label>Email address</label><span class="input-error-req d-none"></span>
                            </div>
                        </div>
                        <div class="Cu-one">
                            <div class="group">
                                <input type="Tel" id="phone" title="Phone Number" placeholder=" " name="phone" class="phone form-input">
                                <label>Phone Number </label>
                                <span class="input-error-req d-none"></span>
                            </div>
                        </div>
                        <div class="Cu-one">
                            <p>How would you like to be contacted ?</p>
                        </div>
                        <div class="Cu-three">
                            <div class="checkbox-group">
                                <input type="checkbox" name="contact_via[]" value="call" id="call" class="valid contact_via[]">
                                <label for="call"> Call</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="contact_via[]" value="sms" id="sms" class="valid contact_via[]">
                                <label for="sms"> SMS</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="contact_via[]" value="email" id="email" class="valid contact_via[]">
                                <label for="email"> Email</label>
                            </div>
                        </div>
                        <div class="submit-group">
                            <button type="button" disabled class="btn-send form-submit test-popup-btn">submit</button>
                        </div>
                        </form>
                        <div id="response-message"></div>
                        <div id="loader" style="display: none;">Submitting...</div>
                    </div>
                    <!-- end test drive form  -->
                </div>
            </div>
            </div>
            <!-- end modal -->
  
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script>
              // Initialize the Swiper slider here using JavaScript
                var sliderThumbnail = new Swiper('.slider-thumbnail', {
                    slidesPerView: 6,
                    freeMode: true,
                    watchSlidesVisibility: true,
                    watchSlidesProgress: true,
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

                jQuery(document).ready(function ($) {

                $('.modal-trigger').click(function () {
                    let current_day = new Date()

                    getAailability(formatDate(current_day))

                    var cliked_image = $(this).find('img').attr('src');
            
                    $(".test-drive-modal-content .swiper-slide").each(function(index, element) {
                        var image = $(element).find('img').attr('src');
                        if( cliked_image == image )
                        {    
                            changeActiveSlide(index);
                            return false;
                        }
                        
                    });               
                    $('#test-drive-modal').fadeIn();
                });

                // Close the modal when the close button is clicked
                $('.close-modal').click(function () {
                    $('#test-drive-modal').fadeOut();
                });
            });

            function changeActiveSlide(index) {
                // Use Swiper's built-in methods to change the active slide
                sliderModal.slideTo(index); // Change to the desired slide index
            }
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const inputElements = [{
                        select: document.getElementById("selected-time"),
                        label: document.querySelector("label[for=selected-time]")
                    }
                ];

                inputElements.forEach(({
                    select,
                    label
                }) => {
                    select.addEventListener("change", () => {
                        if (select.value !== "") {
                            label.style.top = "0px";
                            label.style.transform = "translateY(-50%) scale(0.9)";
                            select.style.border = "1px solid #000";
                        }
                    });
                });
            });
        </script>
        <?php
       // End HTML markup
        } else {
            echo 'No posts found.';
        }
    }

}