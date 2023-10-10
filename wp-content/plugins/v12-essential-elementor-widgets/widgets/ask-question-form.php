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

class Essential_Elementor_Ask_Form_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_style('ask-question-css', $widget_folder_url . 'styles/ask-question.css');
        wp_enqueue_style('ask-question-css');
    }

    public function get_script_depends()
    {
        return ['lead-widget-js'];
    }

    public function get_style_depends()
    {
        return ['ask-question-css'];
    }
    // Replace these with the code to fetch the primary and secondary colors from your theme settings
// Replace 'secondary_color' with the actual setting name


    protected function register_controls() {
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
                // 'global' => [
                //     'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                // ],
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
                // 'global' => [
                //     'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                // ],
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
                // 'default' => [
                //     'border-width' => '1px',    // Default border width
                //     'border-style' => 'solid', // Default border style
                //     'border-color' => $primary_color, // Default border color
                // ],
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
        return 'ask-form';
    }

    public function get_title()
    {
        return esc_html__('ask Form', 'essential-elementor-widget');
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
        return ['ask', "v12", "ask form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

?>

        <div id="ask-form-container">
            <div class="tab d-none">
                <h1 class="tablinks">Ask a question</h1>
            </div>
            <form id="ask-question-form" class="fs-content lead-form">
                <input type="hidden" name="type_id" value="4" />
                <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />
                <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">

                <div class="Cu-twice">
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
                        <input type="Tel" title="Phone Number" id="phone-ask" placeholder=" " name="phone" class="phone form-input" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                        <label>Phone Number </label><span class="input-error-req d-none">Phone Number required.</span>
                    </div>
                    
                </div>
                <div class="group">
                        <textarea type="text" title="Message" name="options[question]" rows="6" class="question form-input" placeholder=" "></textarea>
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
        <?php include( plugin_dir_path( __FILE__ ) . 'popup.php' ); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php

    }
}
