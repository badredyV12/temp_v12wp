<?php
/**
 * Plugin Name: Widget Trad-in Form
 * Description: Elementor custom widgets for v12.
 * Plugin URI:  https://www1.v12software.com/
 * Version:     1.0.0
 * Author:      Azeddine ATOUANI
 * Text Domain: essential-elementor-widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Trade_Form_Widget extends \Elementor\Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_script('tradin-js', $widget_folder_url . 'script/tradin.js', ['jquery'], '1.1', true);
        wp_register_style( 'tradin-css', $widget_folder_url.'styles/tradin.css');
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
                    '{{WRAPPER}} .trade-form-btn' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .trade-form-btn:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .trade-form-btn' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .trade-form-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'label' => esc_html__('Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .trade-form-btn',
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
                    '{{WRAPPER}} .trade-form-btn' => 'width: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .trade-form-btn',
                'default' => 'none', 
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border_hover',
                'label' => esc_html__('Border on Hover', 'textdomain'),
                'selector' => '{{WRAPPER}} .trade-form-btn:hover',
                'default' => 'none', 
            ]
        );
    
        $this->add_control(
            'submit_margin',
            [
                'label' => esc_html__('Margin', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .trade-form-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .trade-form-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                
            ]
        );
    
        $this->end_controls_section();
    }

   
    public function get_script_depends()
    {
        return ['lead-widget-js','tradin-js'];
    }

    public function get_style_depends() {
        return [ 'tradin-css' ];
    }

    public function get_name()
    {
        return 'trade-form';
    }

    public function get_title()
    {
        return esc_html__('trade Form', 'essential-elementor-widget');
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
        return ['trade', "v12", "trade form"];
    }

    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

?>

        <div class="fs-container">
            <div class="fs-title">
                <h1>Offer Trade-In</h1>
            </div>

            <div class="fs-content">
                <form id="trade-form" class="form lead-form">
                    <input type="hidden" name="type_id" value="6" />
                    <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />
        
                    <div class="step-1 d-none active">
                        <div class="group">
                            <input type="text" id="trade-make" name="trade_in[trade_in_note]" title="trade in note" class="form-input" placeholder=" ">
                            <label>Year, Make, Model, Trim</label><span class="input-error-req d-none"></span>
                        </div>
                        <div class="group d-none" id="trade_mileage_group">
                            <input type="number" id="trade-mileage" title="trade mileage" name="trade_in[trade_in_mileage]" placeholder=" " class="form-input">
                            <label>Mileage</label><span class="input-error-req d-none"></span>
                        </div>
                        <div class="submit-group">
                            <button type="button" disabled="disabled" class="next form-btn-next trade-form-btn">Next</button>
                        </div>

                    </div>
                    <div class="step-2 d-none">
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
                                    <input type="checkbox" name="text-us[]" value="call" id="call" class="valid ">
                                    <label for="call"> Call</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" name="text-us[]" value="sms" id="sms" class="valid">
                                    <label for="sms"> SMS</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" name="text-us[]" value="email" id="email" class="valid">
                                    <label for="email"> Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="submit-group">
                            <button type="button" class="prev form-btn-prev trade-form-btn">Prev</button>
                            <button type="button" class="btn-send form-submit trade-form-btn">submit</button>
                        </div>
                    </div>
                </form>
                <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>

            </div>

        </div>
        <?php include(plugin_dir_path(__FILE__) . 'popup.php'); ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


       
<?php
    }
}
