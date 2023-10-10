<?php
/**
 * Plugin Name: Widget Vdp Finance Form
 * Description: Elementor custom widgets for v12.
 * Plugin URI:  https://www1.v12software.com/
 * Version:     1.0.0
 * Author:      Azeddine ATOUANI
 * Text Domain: essential-elementor-widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Vdp_Finance_Form_Widget extends \Elementor\Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        // wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_script('vdp-finance-js', $widget_folder_url . 'script/vdp-finance.js', ['jquery'], '1.1', true);
        wp_register_style( 'vdp-finance-css', $widget_folder_url.'styles/vdp-finance.css');
        wp_enqueue_style('vdp-finance-css');


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
            'heading_color',
            [
                'label' => esc_html__( 'Heading Color', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-class' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
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
            'submit_background_color',
            [
                'label' => esc_html__( 'Heading Color', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-class' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
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
    
        $this->add_control(
            'submit_text_hover_color',
            [
                'label' => esc_html__('Text Hover Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
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
    
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'label' => esc_html__('Border', 'textdomain'),
                'selector' => '{{WRAPPER}} .form-submit',
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border_hover',
                'label' => esc_html__('Border on Hover', 'textdomain'),
                'selector' => '{{WRAPPER}} .form-submit:hover',
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

    public function get_script_depends()
    {
        return ['vdp-finance-js'];
    }

    public function get_style_depends() {
        return [ 'vdp-finance-css' ];
    }

    public function get_name()
    {
        return 'vdp-finance-form';
    }

    public function get_title()
    {
        return esc_html__('vdp finance Form', 'essential-elementor-widget');
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
        return ['vdp finance', "v12", "vdp finance form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        // Get the current post ID
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);


        // Get the post meta data for "price"
        $price = str_replace(',','',get_post_meta($post_id, 'price', true)) ;

        // $price = 10000;
        $down_payement="";
        $net_amount="";
        if($price != "")
        {
            $down_payement = $price * 0.1;  // down payement = price / 100 * 10
            $net_amount = $price - $down_payement;
        }
        $interest_rate = 6;
        $loan_term = 60;

?>

        <div class="calculate_result_block">
            <div class="calculate_result_title f-s-25 text-center mb-3">
            ESTIMATED MONTHLY PAYMENT
            </div>
            <div class="group finance amount_result_holder">
                <span class="float-none f-s-25">$<span id="pmt" class="calc-monthly-payment">0.00</span></span>
            </div>
            <div class="group">
                <p class="based-note">Based on 10% down and 6% APR <span class="based-note-span">
                    <a href="javascript:void(0)" class="edit-simulation-vdp">Edit Simulation</a> </span> </p>
            </div>
        </div>
        <div class="block-approve">
        <a href="/credit-application" target="_blank" class="btn btn-danger rounded-full get-pre-approved form-submit">GET PRE-APPROVED NOW</a>
        </div>

        <div class="overlayVdpF " id="popupOverlayVdpF">
            <div class="popupVdpF" id="popupVdpF">

                <div id="vdp-finance-form-container">
                    <div class="fs-title">
                    
                        <h1>finance Us</h1>
                    </div>

                    <div class="fs-content">
                    
                    <div class="calculate_result_title f-s-25 text-center mb-3 calc-title">
                    Finance Calculator​
            </div>
                        <div class="calculator-item calculator-simplified">
                            <form id="finance-form" class="form lead-form">
                            
                                <input type="hidden" class="calc-sales-tax form-control" id="other_fees" placeholder=" " value="0">

                                <div class="Cu-one">
                                    <div class="group finance">
                                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' step="any" title="Vehicle price" class="calc-vehicle-price form-input" placeholder=" " id="Vehicle-price" value="<?php echo $price; ?>"  min="1" <?php  if ($price != "") {
                                            echo "readonly";
                                        } ?>>
                                        <label for="Vehicle-price">Vehicle price</label><span class="input-error-req d-none">Loan Amount is required.</span>
                                    </div>
                                    
                                </div>
                                <div class="Cu-one">
                                    <div class="group finance">
                                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' title="Down Payment" class="calc-down-payment form-input" placeholder=" " id="Down-Payment"  min="1" value="<?php echo $down_payement; ?>">
                                        <label for="Down-Payment">Down Payment</label><span class="input-error-req d-none">Down Payment is required.</span>
                                    </div>
                                </div>
                                <div class="Cu-one">
                                    <div class="group finance">
                                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' title="Trade-in Value" class="calc-trade-in-value form-input" placeholder=" " id="Trade-In"  min="1">
                                        <label for="Trade-In">Trade-in Value</label><span class="input-error-req d-none">Trade-in Value is required.</span>
                                    </div>
                                </div>
                                <div class="Cu-one">
                                    <div class="group finance">
                                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' title="Net Amount to finance" class="net-amount form-input" placeholder=" " id="net-amount"  min="1" value="<?php echo $net_amount ?>">
                                        <label for="net-amount">Net Amount to finance</label><span class="input-error-req d-none">Net Amount to finance is required.</span>
                                    </div>
                                </div>

                                <div class="Cu-one">
                                    <div class="group finance">
                                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' title="Interest Rate" class="calc-interest-rate form-input" placeholder=" " id="Interest-Rate"  min="1" max="100" value="<?php echo $interest_rate; ?>">
                                        <label for="Interest-Rate">Interest Rate</label><span class="input-error-req d-none">Interest Rate is required.</span>
                                    </div>   
                                </div>

                                <div class="Cu-one">
                                    <div class="group finance">
                                        <select class="form-input calc-loan-term" id="Months" placeholder=" " >
                                                <option value="">Loan Term (Months)</option>
                                                <option value="6">06 months</option>
                                                <option value="12">12 months</option>
                                                <option value="18" >18 months</option>
                                                <option value="24">24 months</option>
                                                <option value="30">30 months</option>
                                                <option value="36">36 months</option>
                                                <option value="42">42 months</option>
                                                <option value="48">48 months</option>
                                                <option value="54">54 months</option>
                                                <option value="60" selected>60 months</option>
                                                <option value="66">66 months</option>
                                                <option value="72">72 months</option>
                                                <option value="78">78 months</option>
                                                <option value="84">84 months</option>
                                                <option value="90">90 months</option>
                                                <option value="96">96 months</option>
                                                <option value="102">102 months</option>
                                                <option value="108">108 months</option>
                                                <option value="114">114 months</option>
                                                <option value="120">120 months</option>
                                            </select>
                                        <label for="term">Loan Term (in months)</label><span class="input-error-req d-none">Loan Term (in months) is required.</span>
                                    </div>
                                </div>
                            <!--     <div class="calculate_result_block">
                                    <div class="calculate_result_title f-s-25 text-center mb-3">
                                        Loan Summary
                                    </div>
                                    <div class="group finance amount_result_holder">
                        
                                        <span class="amount_result2 ">$<span  id="pmt" class="calc-monthly-payment">0</span><span class="f-s-16">/month</span></span>
                                    </div>
                                </div> -->

                                <!-- <div class="calculate_result_block">
                                    <div class="calculate_result_title ">
                                        Loan Summary
                                    </div>
                                    <div class="group finance  amount_result_holder">
                                        <span class="amount_result2 ">$<span class="calc-monthly-payment">0</span><span class="f-s-16">/month</span></span>
                                    </div>
                                    <div class="group finance  amount_result_holder">
                                        <span class="amount_result">$<span class="calc-loan-amount">0</span></span>
                                    </div>
                                    <div class="group finance height_auto amount_result_holder">
                                        <span class="month_result_wrapper"><span class="month_result">0</span> months</span>
                                    </div>
                                </div> -->
                                <div class="price-footer">
                                    <div class="form-btns text-center">
                                        <button id="loan_calculat" class="finance-calc-btn form-submit">ESTIMATE MONTHLY Payment</button>
                                        
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div id="response-message"></div>
                        <div id="loader" style="display: none;">Submitting...</div>

                    </div>

                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<?php
    }
}