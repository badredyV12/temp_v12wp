<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Contact_Form_landing_page_Widget extends \Elementor\Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
    }

    public function get_script_depends()
    {
        return ['lead-widget-js'];
    }

    public function get_name()
    {
        return 'contact form landing page landing page';
    }

    public function get_title()
    {
        return esc_html__('contact form landing page', 'essential-elementor-widget');
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
        return ['contact form landing page', "v12", "contact form landing page"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

        ?>


        <div class="fs-container">
            <div class="fs-title d-none">
                <h1>Contact Us</h1>
            </div>

            <div class="fs-content">
                <form id="contact-form" class="form lead-form">
                    <input type="hidden" name="type_id" value="9" />
                    <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />
                    <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">


                    <div class="group">
                        <!-- 
                            TODO GET dealer CHOOSE AND display theme here
                        -->
                    <div class="row" id="grp-btns">
						<div class="col col-12 rmv-padding">
							<div class="form-check my-2">
								<input type="radio" class="form-check-input" id="radio1" name="data[options][type_form]" value="Schedule a test drive" checked="" autocomplete="off">
								<label class="form-check-label" for="radio1">Schedule a test drive</label>
							</div>
						</div>
						<div class="col col-12 rmv-padding">
							<div class="form-check my-2">
								<input type="radio" class="form-check-input" id="radio2" name="data[options][type_form]" value="Discuss financing options" autocomplete="off">
								<label class="form-check-label" for="radio2">Discuss financing options</label>
							</div>
						</div>
						<div class="col col-12 rmv-padding">
							<div class="form-check my-2">
								<input type="radio" class="form-check-input" id="radio3" name="data[options][type_form]" value="Get more information about the vehicle" autocomplete="off">
								<label class="form-check-label" for="radio3">Get more information about the vehicle</label>
							</div>
						</div>
					</div>
                    </div>
                    <div class="Cu-twice">
                        <div class="group">
                            <input type="text"  name="first_name" placeholder=" " class="form-input">
                            <label>First Name</label><span class="input-error-req">First name required.</span>
                        </div>
                        <div class="group">
                            <input type="text" placeholder=" " name="last_name" class="form-input">
                            <label>Last Name</label><span class="input-error-req">Last name required.</span>
                        </div>
                        <div class="group">
                            <input type="text" placeholder=" " name="email" class="form-input">
                            <label>Email address</label><span class="input-error-req">Email address required.</span>
                        </div>
                        <div class="group">
                            <input type="Tel" placeholder=" " name="phone" class="form-input">
                            <label>Phone Number </label><span class="input-error-req">Phone Number required.</span>
                        </div>
                        <input type="hidden" name="source_id" value="1">
                    </div>
                    <div class="Cu-twice">
                        <p>How would you like to be contacted ?</p>
                        <div class="Cu-three">
                            <div class="checkbox-group">
                                <input type="checkbox" name="contact_via[]" value="call" id="call">
                                <label for="call"> Call</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="contact_via[]" value="sms" id="sms">
                                <label for="sms"> SMS</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="contact_via[]" value="email" id="email">
                                <label for="email"> Email</label>
                            </div>
                        </div>

                    </div>

                    <div class="submit-group">
                        <input type="submit" value="submit">
                    </div>
                </form>
                <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>

            </div>

        </div>



        <?php
    }
}