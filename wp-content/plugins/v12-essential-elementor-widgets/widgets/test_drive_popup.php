<?php

/**
 * Plugin Name: Widget Test Drive Form
 * Description: Elementor custom widgets for v12.
 * Plugin URI:  https://www1.v12software.com/
 * Version:     1.0.0
 * Author:      Azeddine ATOUANI
 * Text Domain: essential-elementor-widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class Essential_Elementor_Test_Drive_popup_Form_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_script('test-drive-btn-js', $widget_folder_url . 'script/test-drive-btn.js', ['jquery'], '1.1', true);
        wp_register_style('test-drive-css', $widget_folder_url . 'styles/test-drive.css');
        wp_enqueue_style('test-drive-css');
    }
    protected function register_controls() {
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
                'default' => '#fff', // Default background color
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
                'default' => '#ccc', // Default hover background color
                'selectors' => [
                    '{{WRAPPER}} .test-popup-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'submit_text_color',
            [
                'label' => esc_html__('Text Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000', // Default text color
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
                'default' => '#000', // Default hover text color
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
                'default' => [
                    'font-size' => '15px', // Default font size
                ],
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
                'default' => [
                    'unit' => '%', // Default unit
                    'size' => 40,  // Default size
                ],
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'label' => esc_html__('Border', 'textdomain'),
                'selector' => '{{WRAPPER}} .test-popup-btn',
                'default' => [
                    'border-style' => 'none', // Default border style
                    'border-width' => '1px',   // Default border width
                    'border-color' => '#000000', // Default border color
                ],
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border_hover',
                'label' => esc_html__('Border on Hover', 'textdomain'),
                'selector' => '{{WRAPPER}} .test-popup-btn:hover',
                'default' => [
                    'border-style' => 'none', // Default border style
                    'border-width' => '1px',   // Default border width
                    'border-color' => '#000000', // Default border color
                ], 
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

        // Controls for .label-days.activated
    $this->add_control(
        'label_days_activated_background_color',
        [
            'label' => esc_html__('Activated Label Background Color', 'textdomain'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .label-days.activated' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'label_days_activated_text_color',
        [
            'label' => esc_html__('Activated Label Text Color', 'textdomain'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .label-days.activated' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'label_days_activated_border',
            'label' => esc_html__('Activated Label Border', 'textdomain'),
            'selector' => '{{WRAPPER}} .label-days.activated',
        ]
    );
    
        $this->end_controls_section();
    }





    public function get_script_depends()
    {
        return ['lead-widget-js', 'test-drive-btn-js'];
    }

    public function get_style_depends()
    {
        return ['test-drive-css'];
    }

    public function get_name()
    {
        return 'test-drive-form-popup';
    }

    public function get_title()
    {
        return esc_html__('test drive Form popup', 'essential-elementor-widget');
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
        return ['test drive', 'test drive popup', "v12"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

?>
        <div class="overlay testdrivecontianer" id="popupOverlaytestdrive">
            <div class="popuptestdrive" id="popuptestdrive">
                <div id="test-drive-form-container">

                    <form id="test-drive-form" class="form lead-form test-drive-form slider-test-drive-form">
                        <div class="loading_form d-none" style="position: absolute; left: 40%;top: 30%;">
                            <img src="https://v12statics.s3.amazonaws.com/website/common/t52/assets/images/spinner-1.svg" alt="loader">
                        </div>
                        <input type="hidden" name="type_id" value="5" />
                        <!-- <input type="hidden" name="vehicle_id" value="21" /> -->
                        <input type="hidden" name="category" value="6" />
                        <input type="hidden" name="source_id" value="1" />
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $dealer_id; ?>" />
                        <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">
                        <input type="hidden" id="due_time" name="due_time" value="" />
                        <div class="modal-header / border-none" style="display: block !important;" >
                            <h5 class="test-drive-popup-title"> Book a Test Drive</h5>

                            <button type="button" class="form-btn-prev back-btn d-none text-drive-popup-action" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 486.963 486.963" xml:space="preserve">
                                        <path d="m483 233.869-139-139c-5.3-5.3-13.8-5.3-19.1 0-5.3 5.3-5.3 13.8 0 19.1l116 116H13.5c-7.5 0-13.5 6-13.5 13.5s6 13.5 13.5 13.5h427.4l-116 116c-5.3 5.3-5.3 13.8 0 19.1 2.6 2.6 6.1 4 9.5 4s6.9-1.3 9.5-4l139-139c5.4-5.4 5.4-14 .1-19.2z"></path>
                                    </svg> </span>
                            </button>
                            <button type="button" class="test-drive-popup-close text-drive-popup-action" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <svg class="svg_icon_close_red icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="25px" height="26px" viewBox="0 0 25 26" style="enable-background:new 0 0 25 26;" xml:space="preserve">
                                        <g id="_x38__1_">
                                            <g>
                                                <path class="" d="M13.1,12.2L2.5,1.3c-0.3-0.4-0.9-0.4-1.3,0c-0.3,0.4-0.3,1,0,1.4l10,10.3l-10,10.3c-0.3,0.4-0.3,1,0,1.4	c0.3,0.4,0.9,0.4,1.3,0l10.6-10.9c0.2-0.2,0.3-0.5,0.3-0.8C13.4,12.7,13.3,12.4,13.1,12.2z"></path>
                                            </g>
                                            <g>
                                                <path class="st1" d="M13.1,12.2L2.5,1.3c-0.3-0.4-0.9-0.4-1.3,0c-0.3,0.4-0.3,1,0,1.4l10,10.3l-10,10.3c-0.3,0.4-0.3,1,0,1.4	c0.3,0.4,0.9,0.4,1.3,0l10.6-10.9c0.2-0.2,0.3-0.5,0.3-0.8C13.4,12.7,13.3,12.4,13.1,12.2z"></path>
                                            </g>
                                        </g>
                                        <g id="_x37__1_">
                                            <g>
                                                <path class="" d="M13.8,13l10-10.3c0.3-0.4,0.3-1,0-1.4c-0.3-0.4-0.9-0.4-1.3,0L11.9,12.2c-0.2,0.2-0.3,0.5-0.3,0.8	c0,0.3,0.1,0.6,0.3,0.8l10.6,10.9c0.3,0.4,0.9,0.4,1.3,0c0.3-0.4,0.3-1,0-1.4L13.8,13z"></path>
                                            </g>
                                            <g>
                                                <path class="st1" d="M13.8,13l10-10.3c0.3-0.4,0.3-1,0-1.4c-0.3-0.4-0.9-0.4-1.3,0L11.9,12.2c-0.2,0.2-0.3,0.5-0.3,0.8	c0,0.3,0.1,0.6,0.3,0.8l10.6,10.9c0.3,0.4,0.9,0.4,1.3,0c0.3-0.4,0.3-1,0-1.4L13.8,13z"></path>
                                            </g>
                                        </g>
                                    </svg> </span>
                            </button>
                        </div>


                        <div class="step-1 d-none active">
                            <p class="para-desc text-center">Please, select a date and time to book your test-drive.</p>
                            <div class="select-time-month">
                                <span class="current-month"></span>
                            </div>
                            <div class="test-drive-days ">
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
                                <span class="next-days rotate-180">
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
                            <div class="group d-none group-selected-time">
                                <select name="selected-time" class="form-control selected-time form-input" id="selected-time">
                                    <option disabled="disabled" selected="selected"></option>
                                </select>
                                <label for="selected-time">Selected time</label>
                            </div>

                            <div class="submit-group">
                                <button type="button" disabled="disabled" class="btn-next-step form-btn-next test-popup-btn">Next</button>
                            </div>
                        </div>
                        <div class="step-2 d-none">
                            <p class="para-desc text-center">Please, enter your contact information.</p>
                            <div class="Cu-twice">
                                <div class="group">
                                    <input type="text" title="First name" name="first_name" placeholder=" " class="first_name form-input">
                                    <label>First Name</label><span class="input-error-req d-none"></span>
                                </div>
                                <div class="group">
                                    <input type="text" title="Last name" placeholder=" " name="last_name" class="last_name form-input">
                                    <label>Last Name</label><span class="input-error-req d-none"></span>
                                </div>
                            </div>
                            <div class="Cu-one">
                                <div class="group">
                                    <input type="email" title="E-mail" placeholder=" " name="email" class="email form-input">
                                    <label>Email address</label><span class="input-error-req d-none"></span>
                                </div>
                            </div>
                            <div class="Cu-twice">
                                <div class="group">
                                    <input type="Tel" id="phone" title="Phone Number" placeholder=" " name="phone" class="phone form-input" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    <label>Phone Number </label>
                                    <span class="input-error-req d-none"></span>
                                </div>
                                <div class="group">
                                    <input type="number" id="zip_code" title="Zip Code" placeholder=" " name="options[zip_code]" class="zip_code form-input">
                                    <label>Zip Code </label>
                                    <span class="input-error-req d-none"></span>
                                </div>

                            </div>

                            <div class="Cu-twice">
                                <p>How would you like to be contacted ?</p>
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
                            </div>

                            <div class="submit-group">
                                <!-- <button type="button" class="prev form-btn-prev test-popup-btn">Prev</button> -->
                                <button type="button" class="btn-send form-submit test-popup-btn">submit</button>
                            </div>

                        </div>

                    </form>
                    <div id="response-message"></div>
                    <div id="loader" style="display: none;">Submitting...</div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const inputElements = [{
                    select: document.getElementById("selected-time"),
                    label: document.querySelector("label[for=selected-time]")
                }];

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

        include(plugin_dir_path(__FILE__) . 'popup.php');
    }
}
