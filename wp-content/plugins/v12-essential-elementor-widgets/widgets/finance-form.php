<?php

/**
 * Plugin Name: Widget Finance Form
 * Description: Elementor custom widgets for v12.
 * Plugin URI:  https://www1.v12software.com/
 * Version:     1.0.0
 * Author:      Azeddine ATOUANI
 * Text Domain: essential-elementor-widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Finance_Form_Widget extends \Elementor\Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_script('finance-js', $widget_folder_url . 'script/finance.js', ['jquery'], '1.1', true);
        wp_register_style( 'finance-css', $widget_folder_url.'styles/finance.css');
        wp_enqueue_style('finance-css');

    }


    public function get_style_depends() {
        return [ 'finance-css' ];
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
                    '{{WRAPPER}} .form-submit' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .form-submit:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .form-submit' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .form-submit:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'label' => esc_html__('Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .form-submit',
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
                    '{{WRAPPER}} .form-submit' => 'width: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .form-submit',
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
                'selector' => '{{WRAPPER}} .form-submit:hover',
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
                    '{{WRAPPER}} .form-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .form-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                
            ]
        );
    
        $this->end_controls_section();
    }
    // protected function register_controls()
    // {

    //     $this->start_controls_section(
    //         'style_section',
    //         [
    //             'label' => esc_html__('Style', 'textdomain'),
    //             'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    //         ]
    //     );

    //     $this->add_control(
    //         'submit background color',
    //         [
    //             'label' => esc_html__('submit background color', 'textdomain'),
    //             'type' => \Elementor\Controls_Manager::COLOR,
    //             'selectors' => [
    //                 '{{WRAPPER}} .form-submit' => 'background-color: {{VALUE}}',
    //             ],
    //         ]
    //     );


    //     $this->add_control(
    //         'get pre approved text color',
    //         [
    //             'label' => esc_html__('get pre approved text color', 'textdomain'),
    //             'type' => \Elementor\Controls_Manager::COLOR,
    //             'selectors' => [
    //                 '{{WRAPPER}} .get-pre-approved' => 'color: {{VALUE}}',
    //             ],
    //         ]
    //     );

    //     $this->end_controls_section();
    // }

    public function get_script_depends()
    {
        return ['lead-widget-js', 'finance-js'];
    }

    public function get_name()
    {
        return 'finance-form';
    }

    public function get_title()
    {
        return esc_html__('finance Form', 'essential-elementor-widget');
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
        return ['finance', "v12", "finance form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        // Get the current post ID
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);


?>
        <div id="finance-form-container">
            <div class="fs-title d-none">

                <h1>finance Us</h1>
            </div>

            <div class="fs-content">
                <div class="calculator-item calculator-simplified">
                    <form id="finance-form" class="form lead-form">
                        <input type="hidden" name="type_id" value="9" />
                        <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />
                        <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">
                  
                        <div class="Cu-twice">
                            <div class="group finance">
                                <input type="number" step="any" title="Loan Amount" class="cost form-input" placeholder=" " id="price" min="1"  >
                                <label for="price">Loan Amount</label><span class="input-error-req d-none">Loan Amount is required.</span>
                            </div>
                            <div class="group finance">
                                <input type="number" title="Terms (Months)" class="loan_years form-input" placeholder=" " id="term" min="1">
                                <label for="term">Terms (Months)</label><span class="input-error-req d-none">Terms (Months) is required.</span>
                            </div>
                        </div>

                        <div class="Cu-twice">
                            <div class="group finance">
                                <input type="number" title="Interest Rate" class="interest form-input" placeholder=" " id="ir" min="1">
                                <label for="ir">Interest Rate</label><span class="input-error-req d-none">Interest Rate is required.</span>

                            </div>
                            <div class="group finance">
                                <input type="number" title="Down Payment" class="down_payment form-input" placeholder=" " id="dp" min="1">
                                <label for="dp">Down Payment</label><span class="input-error-req d-none">Down Payment is required.</span>
                            </div>
                        </div>
                         <div class="calculate_result_block">
                            <div class="calculate_result_title f-s-25 text-center mb-3">
                                Simplified Summary
                            </div>
                            <div class="group finance amount_result_holder">
                                <span class="float-none f-s-25">$<span id="pmt">0.00</span></span>
                            </div>
                        </div>
                   
                        <div class="price-footer">
                            <div class="form-btns text-center">
                            
                                <!-- <button id="calc_button" class="btn btn-danger finance-calc-btn">GET PRE-APPROVED NOW</button> -->
                                <button id="calc_button" class="btn btn-danger finance-calc-btn form-submit">calculate</button>
                                <a href="/credit-application" target="_blank" class="btn btn-danger rounded-full get-pre-approved form-submit d-none">Get Pre-Approved</a>
                            </div>
                        </div>

                    </form>
                </div>
                <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>

            </div>

        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php
    }
}
