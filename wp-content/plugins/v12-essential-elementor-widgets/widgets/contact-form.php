<?php
/**
 * Plugin Name: Widget Locate Form
 * Description: Elementor custom widgets for v12.
 * Plugin URI:  https://www1.v12software.com/
 * Version:     1.0.0
 * Author:      Azeddine ATOUANI
 * Text Domain: essential-elementor-widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class Essential_Elementor_Contact_Form_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_style( 'contact-css', $widget_folder_url.'styles/contact.css');
        wp_enqueue_style('contact-css');
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
    
    
    public function get_style_depends() {
        return [ 'contact-css' ];
     }

    public function get_script_depends()
    {
        return ['lead-widget-js'];
    }

    public function get_name()
    {
        return 'contact form';
    }

    public function get_title()
    {
        return esc_html__('contact Form', 'essential-elementor-widget');
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
        return ['contact', "v12", "contact form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

        ?>


        <div id="contact-container">
            <div class="fs-title d-none">
                <h1>Contact Us</h1>
            </div>

            <div class="fs-content">
                <form id="contact-form" class="form lead-form">
                <input type="hidden" class="type_id valid" name="type_id" value="9" />
                    <input type="hidden" class="user_id valid" name="user_id" value="<?php echo $dealer_id; ?>" />
                    <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">
                    <input type="hidden" class="source_id valid" name="source_id" value="1">


                    <div class="group">
                        <textarea type="text" title="Additional comments" name="additional_comments" rows="6" class="form-input" placeholder=" "></textarea>
                        <label>Please, let us know how we can help?</label>
                        <span class="input-error-req d-none">Additional comments required.</span>
                    </div>

                    <div class="Cu-twice">
                        <div class="group">
                            <input type="text" title="First name"  name="first_name" placeholder=" " class="first_name form-input">
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
                            <input type="Tel" id="phone" title="Phone Number" placeholder=" " name="phone" class="phone form-input" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            <label>Phone Number </label><span class="input-error-req d-none">Phone Number required.</span>
                        </div>
                    </div>
                    <div class="Cu-twice">
                        <p>How would you like to be contacted ?</p>
                        <div class="Cu-three">
                            <div class="checkbox-group">
                                <input type="checkbox" name="contact_via[]" value="call" id="call"  class="valid contact_via[]">
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
                    <button type="button"  class="btn-send form-submit">submit</button>
                        
                    </div>
                </form>
                <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>

            </div> 

        </div>
        <!-- <button onclick="togglePopup()">show me</button> -->
        <?php include( plugin_dir_path( __FILE__ ) . 'popup.php' ); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <?php
    }
}