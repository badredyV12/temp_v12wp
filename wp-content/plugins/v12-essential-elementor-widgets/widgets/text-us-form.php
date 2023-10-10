<?php

/**
 * Plugin Name: Widget Ask Question
 * Description: Elementor custom widgets for v12.
 * Plugin URI:  https://www1.v12software.com/
 * Version:     1.0.0
 * Author:      Azeddine ATOUANI
 * Text Domain: essential-elementor-widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Text_Us_Form_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_style('text-us-css', $widget_folder_url . 'styles/ask-question.css');
        wp_enqueue_style('text-us-css');
    }

    public function get_script_depends()
    {
        return ['lead-widget-js'];
    }

    public function get_style_depends()
    {
        return ['text-us-css'];
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
    

    public function get_name()
    {
        return 'text-us-form';
    }

    public function get_title()
    {
        return esc_html__('text-us Form', 'essential-elementor-widget');
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
        return ['text-us', "v12", "text-us form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

        // $dealer_id = 100079;


?>

    <div class="show-popup">
        <button type="button" class="show-popup-text-us d-none"  id="show-popup-text-us">Text Us</button>
    </div>
    <div class="overlay textuscontianer" id="popupOverlayTextUs">
            <div class="popuptextus" id="popuptextus">
                <button type="button" class="text-us-popup-close text-us-popup-action" data-dismiss="modal" aria-label="Close">
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
                <div id="text-us-form-container">
                <div class="tab ">
                    <h3 class="tablinks">Send Us A Text</h3>
                    <p>Please, enter your contact information</p>
                </div>
                <form id="text-us-form" class="fs-content lead-form">
                    <input type="hidden" name="type_id" value="13" />
                    <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />
                    <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">

                    <div class="Cu-one">
                        <div class="group">
                            <input type="text" title="First name" name="first_name" placeholder=" " class="first_name form-input">
                            <label>First Name</label><span class="input-error-req d-none">First name required.</span>
                        </div>
                    </div>
                    <div class="Cu-one">
                        <div class="group">
                            <input type="text" title="Last name" placeholder=" " name="last_name" class="last_name form-input">
                            <label>Last Name</label><span class="input-error-req d-none">Last name required.</span>
                        </div>
                    </div>
                    <div class="Cu-one">
                        <div class="group">
                            <input type="Tel" title="Phone Number" id="phone-text-us" placeholder=" " name="phone" class="phone form-input" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            <label>Phone Number </label><span class="input-error-req d-none">Phone Number required.</span>
                        </div>
                    </div>
                    <div class="Cu-one">
                        <div class="group">
                            <textarea type="text" title="Message" name="options[question]" rows="6" class="question form-input" placeholder=" "></textarea>
                            <label>Enter your message here</label>
                            <span class="input-error-req d-none">Message required.</span>
                        </div>
                    </div>
                    <div class="submit-group">
                        <button type="button" class="btn-send form-submit">Send</button>
                    </div>
                </form>
                <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    

    $(document).ready(function() {
        const overlay = $("#popupOverlayTextUs");

        $("#show-popup-text-us").click(function() {
            overlay.show();
        });

        $(".text-us-popup-close").click(function() {
            overlay.hide();
        });
       
    });
</script>

<style>
    .textuscontianer .show-popup-text-us {
        position: relative;
        float: right;
        right: 15px;
        margin: 0px !important;
        width: auto !important;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        padding-top: 10%;
        padding-left: 20%;
        padding-right: 20%;
    }

    .popuptextus {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: #fff;
        border-radius: 10px;
        padding: 50px 50px;
    }

    .text-us-popup-close {
        position: absolute;
        top: 10px;
        right: 0;
        border: none;
        width: 66px;
        min-width: 45px !important;
    }
</style>

<?php
    }
}
