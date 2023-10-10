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
class Essential_Elementor_Test_Drive_Form_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);
        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url.'lead-form.js', ['jquery'], '1.1', true );
        wp_register_script('test-drive-js', $widget_folder_url.'script/test-drive.js', ['jquery'], '1.1', true );
        wp_register_style( 'test-drive-css', $widget_folder_url.'styles/test-drive.css');
        wp_enqueue_style('test-drive-css');


    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'form buttons background color',
            [
                'label' => esc_html__('submit background color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-submit' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .form-btn-next' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .form-btn-prev' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }   

    public function get_script_depends() {
        return [ 'lead-widget-js', 'test-drive-js' ];
    }

    public function get_style_depends() {
       return [ 'test-drive-css' ];
    }

    public function get_name()
    {
        return 'test-drive-form';
    }

    public function get_title()
    {
        return esc_html__('test drive Form', 'essential-elementor-widget');
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
        return ['test drive', "v12", "test drive form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

        ?>

        <div id="test-drive-form-container">
            <div class="fs-title">
                <h1>Book a test drive</h1>
            </div>
            


            <form id="" class="form lead-form test-drive-form">
                 <div class="loading_form d-none">
                    <img src="https://v12statics.s3.amazonaws.com/website/common/t52/assets/images/spinner-1.svg" alt="loader">
                </div>
                <div class="select-time-month">
            <p class="para-desc text-center">Please, select a date and time to book your test-drive.</p>
                   <span class="current-month"></span>
               </div>

                <input type="hidden" name="type_id" value="5" />
                <input type="hidden" name="vehicle_id" value="21" />
                <input type="hidden" name="category" value="6" />
                <input type="hidden" name="source_id" value="1" />
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $dealer_id; ?>" />
                <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">
                <input type="hidden" id="due_time" name="due_time" value="" />

                <div class="step-1 d-none active">

                    <div class="test-drive-days ">
                        <span class="btn-disabled prev-days" style="float: left;">
                            <i class=" block">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="14.8px" height="13.7px" viewBox="0 0 14.8 13.7" xml:space="preserve" class="svg_icon_prev_arrow icon"><g id="_x37__1_"><g><path d="M13.8,5.8H3.2l4.1-4.1c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L0.3,5.9C0,6.2,0,6.5,0,6.8 C0,7.1,0,7.5,0.3,7.7l5.7,5.7c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4L3.2,7.8h10.6c0.6,0,1-0.4,1-1C14.8,6.3,14.4,5.8,13.8,5.8z "></path></g></g></svg>
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
                        <span class="next-days">
                            <i class="chevron-outline-icon block transform rotate-180">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="14.8px" height="13.7px" viewBox="0 0 14.8 13.7" xml:space="preserve" class="svg_icon_prev_arrow_red icon"><defs></defs> <g id="_x37__1_"><g><path d="M13.8,5.8H3.2l4.1-4.1c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L0.3,5.9C0,6.2,0,6.5,0,6.8 C0,7.1,0,7.5,0.3,7.7l5.7,5.7c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4L3.2,7.8h10.6c0.6,0,1-0.4,1-1C14.8,6.3,14.4,5.8,13.8,5.8z "></path></g></g>
                                </svg>
                            </i>
                        </span>
                    </div>
                    <div class="group d-none group-selected-time">
                        <select class="form-control selected-time form-input"  id="selected-time">
                            <option disabled="disabled" selected="selected"></option> 
                        </select>
                         <label for="selected-time">Selected time</label>
                    </div>

                    <div class="submit-group">
                        <button type="button" disabled="disabled" class="btn-next-step form-btn-next">Next</button>
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
                        <button type="button" class="prev form-btn-prev ">Prev</button>
                        <button type="button"  class="btn-send form-submit">submit</button>
                    </div>
     
                </div>

            </form> 
            <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <?php
        
        include( plugin_dir_path( __FILE__ ) . 'popup.php' );

    }


}



