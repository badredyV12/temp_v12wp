<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class Essential_Elementor_Test_Drive_Form_btn_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_style('test-drive-css', $widget_folder_url . 'styles/test-drive.css'); 
        wp_enqueue_style('test-drive-css');

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
                    '{{WRAPPER}} .show-popup-btn' => 'background-color: {{VALUE}};',
                    
                ],
            ]
        );

        $this->add_control(
            'submit_hover_background_color',
            [
                'label' => esc_html__('Submit Hover Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .show-popup-btn:hover' => 'background-color: {{SUBMIT_HOVER_BACKGROUND_COLOR}};',
                ],
            ]
        );

        $this->add_control(
            'submit_text_color',
            [
                'label' => esc_html__('Text Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .show-popup-btn' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'submit_text_hover_color',
            [
                'label' => esc_html__('Text Hover Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .show-popup-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'label' => esc_html__('Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .show-popup-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'label' => esc_html__('Border', 'textdomain'),
                'selector' => '{{WRAPPER}} .show-popup-btn',
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border_hover',
                'label' => esc_html__('Border on Hover', 'textdomain'),
                'selector' => '{{WRAPPER}} .show-popup-btn:hover',
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
                    '{{WRAPPER}} .show-popup-btn' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    public function get_script_depends()
    {
        return ['lead-widget-js','test-drive-btn-js'];
    }

    public function get_style_depends()
    {
        return ['test-drive-css'];
    }

    public function get_name()
    {
        return 'testdriveformbtn';
    }

    public function get_title()
    {
        return esc_html__('test drive Form btn', 'essential-elementor-widget');
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
        return ['test drive btn', "v12", "test drive btn"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);
        $btn_show_popup_id = str_replace(' ', '_', get_post_meta($post_id, 'id', true));

?>


        <div class="show-popup">
            <button type="button" class="show-popup-btn" data-id="<?php echo $btn_show_popup_id; ?>" id="<?php echo $btn_show_popup_id; ?>">Schedule a Test-Drive</button>
        </div>
       


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            

            $(document).ready(function() {
                const overlay = $("#popupOverlaytestdrive");
                const closeButton = $("#close-btn-popup");

                $("#<?php echo $btn_show_popup_id; ?>").click(function() {
                    $("body").addClass("disable-scroll");
                    overlay.show();
                });

                closeButton.click(function() {
                    closePopup();
                });

                // Close the popup when clicking outside of it
                overlay.click(function(event) {
                    if (event.target === overlay[0]) {
                        closePopup();
                    }
                });

                function closePopup() {
                    $("body").removeClass("disable-scroll");
                    overlay.hide();
                }
            });
        </script>
<?php

        include(plugin_dir_path(__FILE__) . 'popup.php');
    }
}
