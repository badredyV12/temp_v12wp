<?php




if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Make_Offer_Form_Widget extends \Elementor\Widget_Base
{

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url.'lead-form.js', ['jquery'], '1.1', true );

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
    public function get_script_depends() {
        return [ 'lead-widget-js' ];
    }

    public function get_name()
    {
        return 'make an offer form';
    }

    public function get_title()
    {
        return esc_html__('make an offer Form', 'essential-elementor-widget');
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
        return ['make an offer', "v12", "make an offer form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
      //  $dealer_id = 100108; // Retrieve dealer_id from wp_options

        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

        ?>

        <div id="make-offer-container">
            <div class="fs-title d-none ">
                <h1>Make An Offer</h1>
            </div>

            <div class="fs-content">
                <form id="make-offer-form" class="form lead-form"  >
                    <input type="hidden" name="type_id" value="7" />
                    <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />

                    <div class="Cu-twice">
                        <div class="group">
                            <input type="text" required name="first_name">
                            <label >First Name</label>
                        </div>
                    
                        <div class="group">
                            <input type="text" required name="last_name">
                            <label >Last Name</label>
                        </div>

                    </div>
                    <div class="Cu-twice">
                        <div class="group">
                            <input type="email" required name="email">
                            <label >Email Address </label>
                        </div>
                        <div class="group">
                            <input type="tel" id="phone-make"  name="phone" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            <label >Phone Number</label>
                        </div>
                    </div>

                    <div class="Cu-twice">
                        
                        <div class="group">
                            <input type="number" required id="make_offer_price" name="options[offer]">
                            <label >Offer</label>
                        </div>
                    </div>
                    <div class="Cu-twice">
                       <p>How would you like to be contacted ?</p>
                         <div class="checkbox-group">
                            <input type="checkbox" name="text-us[]" value="call" id="call">
                            <label for="call"> Call</label>
                        </div>
                        <div class="checkbox-group">

                            <input type="checkbox" name="text-us[]" value="sms" id="sms">
                            <label for="sms"> SMS</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" name="text-us[]" value="email" id="email">
                            <label for="email"> Email</label>
                        </div>
                    </div>
                    <div class="submit-group">
                        <input type="submit" value="submit" class="form-submit" >   
                    </div>
                  
                 

                </form>
                <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>

            </div>

        </div>
    

        <?php
    }


}

