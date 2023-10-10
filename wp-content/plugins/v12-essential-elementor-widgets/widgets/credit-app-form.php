<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Credit_App_Form_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_script('credit-app-js', $widget_folder_url . 'script/credit-app.js', ['jquery'], '1.1', true);
        wp_register_script('select2-js', $widget_folder_url . 'script/select2.js', ['jquery'], '1.1', true);
        wp_register_style('credit-app-css', $widget_folder_url . 'styles/credit-app.css');
        wp_register_style('select2-css', $widget_folder_url . 'styles/select2.css');
        wp_enqueue_style('credit-app-css');
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
        
        // Controls for textarea with text editor

        $this->add_control(
            'custom_content',
            [
                'label' => esc_html__('disclosure', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 15,
                'placeholder' => 'Enter your content here...',
                'default' => "I understand that you, and/or your assignees may retain this application and any other information you receive whether or not the application is approved. For purposes of this application, you are authorized to check my credit and employment history. I authorize any person or consumer reporting agency to furnish to you any information it may have or obtain in response to credit inquiries, whenever you make them.\n\nI understand this partial application may not provide sufficient information to make a credit decision.\nIf this occurs, I agree to provide the additional information required to the dealer. If I do not provide this information,\nI understand my application will be incomplete. I also understand that further information may be requested by you, the dealer, or any third party entities that provide credit.\n\nIn order to successfully transmit and receive the information and disclosures related to this credit application, I understand I must have an active Internet connection, a browser capable of sending and receiving secure information and the ability to print pages from this Web site for my records.\n\nI consent to receive the information, follow-up communications, and disclosures related to this credit application and any subsequent credit transaction from you, your affiliates, agents and service providers, in writing, verbally, or electronically. This consent includes, but is not limited to, contact by manual calling methods, prerecorded or artificial voice messages, text messages, emails and/or automatic telephone dialing systems using any e-mail address or any telephone number I provide, now or in the future, including a number for a cellular phone or other wireless device, regardless of whether I incur charges as a result.\n\nI agree that you, your affiliates, agents and service providers may monitor and record telephone calls regarding this credit application and any subsequent credit transaction to assure the quality of your service or for other reasons.\n\nI understand that each time I submit a credit application, a notice will be placed on my credit report.\n\nI certify that the information that I submit with this application is true and complete to the best of my knowledge.\nI further certify that I am not contemplating a bankruptcy action at the present time, nor do I have any executions or pending legal proceedings against me. I recognize that providing false or fraudulent information is illegal and may be a basis for denying a discharge in bankruptcy.\nI further certify that I have attained the age of majority."
            ]
        );
    
        $this->end_controls_section();
    }

    public function get_script_depends()
    {
        return ['lead-widget-js', 'credit-app-js', 'select2-js'];
    }

    public function get_style_depends()
    {
        return ['credit-app-css', 'select2-css'];
    }

    public function get_name()
    {
        return 'creditappform';
    }

    public function get_title()
    {
        return esc_html__('credit app Form', 'essential-elementor-widget');
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
        return ['credit app', "v12", "credit app form"];
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $content = $settings['custom_content'];

        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        //  $dealer_id = 100108; // Retrieve dealer_id from wp_options

        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);
        
        

        $arrStates = array("3" => "AK", "2" => "AL", "7" => "AR", "6" => "AZ", "9" => "CA", "10" => "C", "11" => "CT", "68" => "DC", "12" => "DE", "14" => "FL", "15" => "GA", "17" => "HI", "21" => "IA", "18" => "ID", "19" => "IL", "20" => "IN", "22" => "KS", "23" => "KY", "24" => "LA", "29" => "MA", "28" => "MD", "25" => "ME", "30" => "MI", "31" => "MN", "33" => "MO", "32" => "MS", "34" => "MT", "43" => "NC", "44" => "ND", "35" => "NE", "38" => "NH", "39" => "NJ", "40" => "NM", "47" => "NS", "36" => "NV", "41" => "NY", "48" => "OH", "49" => "OK", "51" => "OR", "53" => "PA", "55" => "PR", "57" => "RI", "59" => "SC", "60" => "SD", "61" => "TN", "62" => "TX", "63" => "UT", "66" => "VA", "64" => "VT", "67" => "WA", "70" => "WI", "69" => "WV", "71" => "WY");


        $args = array(
            'post_type' => 'vehicles',
            'posts_per_page' => -1, // To retrieve all posts
        );

        $query = new WP_Query($args);


        $options = "";

        if ($query->have_posts()) :

            while ($query->have_posts()) : $query->the_post();

                $title = get_the_title();
                $vin = get_post_meta(get_the_ID(), 'vin', true);
                $year = get_post_meta(get_the_ID(), 'year', true);
                $make = get_post_meta(get_the_ID(), 'make', true);
                $model = get_post_meta(get_the_ID(), 'model', true);
                $stock = get_post_meta(get_the_ID(), 'stock', true);
                $mileage = get_post_meta(get_the_ID(), 'mileage', true);
                $price = get_post_meta(get_the_ID(), 'price', true);
                $vehicleId = get_post_meta(get_the_ID(), 'id', true);

                $options = $options . '<option value="' . $vehicleId . '">' . $year . ' ' . $make . ' ' . $model . ' - VIN: ' . $vin . ' - Stock ID: ' . $stock . ' - ' . $mileage . ' miles - $' . $price . '</option>';

            // Use $title, $vin, and $year as needed
            // For example, you can echo or manipulate the data here
            endwhile;
            wp_reset_postdata(); // Restore original post data
        else :
        // No posts found
        endif;
?>

        <div id="credit-app-container">
            <div class="fs-title d-none">
                <h1>Credit Application</h1>
            </div>

            <div class="fs-content">
                <form id="credit-app-form" class="form lead-form">

                    <input type="hidden" name="credit_app" value="1" />
                    <input type="hidden" name="type_id" value="1" />
                    <input type="hidden" class="" name="source_id" value="1" />
                    <input type="hidden" name="credit_app_type" value="0" />
                    <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />
                    <input type="hidden" name="_method" value="POST" />
                    <input type="hidden" name="FromWebsite" value="yes" />
                    <input type="hidden" value="EN" id="lang_place" />
                    <input type="hidden" name="Lead[id]" value="" id="lead_id" />





                    <!-- <div class="group">
                        <input type="text" title="vehicle name" name="name_mid" placeholder=" " class="vehicle_name_data name_mid form-input">
                        <label>vehicle name</label>
                        <span class="input-error-req d-none"></span>
                    </div> -->



                    <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">

                    <input name="Applicant[0][dob]" type="hidden" id="Applicant0Dob" />


                    <div class="Cu-one">
                        <div class="group ">
                            <select name="Vehicle[0][id]" title="Vehicle of interest" id="Vehicle0Id" placeholder=" " class="Vehicle0Id select-search-car form-input">
                                <option value="">Vehicle of interest</option>
                                <?php echo $options; ?>
                            </select>
                            <span class="input-error-req d-none">Vehicle of interest required</span>

                        </div>
                    </div>




                    <div class="credit-app-block-title">Applicant Personal Information</div>
                    <div class="credit-app-block-subtitle">Please, enter your personal information.</div>

                    <div class="Cu-twice">
                        <div class="group">
                            <input type="text" title="First name" name="Applicant[0][first_name]" placeholder=" " class="first_name form-input">
                            <label>First Name</label>
                            <span class="input-error-req d-none"></span>
                        </div>

                        <div class="group">
                            <input type="text" title="Last name" placeholder=" " name="Applicant[0][last_name]" class="last_name form-input">
                            <label>Last Name</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                    </div>
                    <div class="Cu-three">
                        <div class="group">
                            <input type="Tel" id="phone" title="Cell Phone" placeholder=" " name="Applicant[0][contact_phone]" class="contact_phone form-input">
                            <label>Cell Phone</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                        <div class="group">
                            <input type="Tel" id="home_phone" placeholder=" " name="Applicant[0][home_phone]" class="form-input">
                            <label for="home_phone">Work Phone</label>
                        </div>
                        <div class="group">
                            <input type="email" title="E-mail" placeholder=" " name="Applicant[0][email]" class="email form-input">
                            <label>Email address</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                    </div>
                    <div class="Cu-fourth">
                        <div class="group">
                            <select id="month" name="Applicant[0][month]" title="Month" class="applicant_0_month form-input">
                                <option value=""></option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <label for="month">Month</label>
                            <span class="input-error-req d-none"></span>
                        </div>

                        <div class="group">
                            <select id="day" name="Applicant[0][day]" title="Day" class="applicant_0_day form-input">
                                <option value=""></option>
                                <?php for ($i = 1; $i <= 31; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <label for="day">Day</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                        <div class="group">
                            <select id="year" name="Applicant[0][year]" title="Year" class="applicant_0_year form-input">
                                <option value=""></option>
                                <?php for ($i = date("Y"); $i >= 1920; $i--) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <label for="year">Year</label>
                            <span class="input-error-req d-none"></span>
                        </div>


                        <div class="group">
                            <input type="text" name="Applicant[0][ssn]" title="SSN" class="applicant_0_ssn form-input" placeholder=" " id="ApplicantSsn" maxlength="9">
                            <label>SSN (only 9 digits)</label>
                            <span class="input-error-req d-none">SSN required</span>
                        </div>
                    </div>
                    <div class="Cu-twice">
                        <div class="group ">
                            <input name="Applicant[0][license_no]" type="text" placeholder=" " class="form-input">
                            <label>Driver’s License Number</label>
                        </div>
                        <div class="group ">
                            <input name="Applicant[0][dl_exp_date_dd]" type="text" placeholder=" " class="form-input">
                            <label>Driver’s License Expiration Date</label>
                        </div>
                    </div>


                    <div class="credit-app-block-title">Applicant Residence</div>
                    <div class="credit-app-block-subtitle">Please, enter your address information.</div>

                    <div class="Cu-one">
                        <div class=" group ">
                            <input name="Applicant[0][address]" type="text" placeholder=" " class="form-input">
                            <label>Address</label>
                        </div>
                    </div>
                    <div class="Cu-three">
                        <div class="group">
                            <input name="Applicant[0][city]" type="text" placeholder=" " class="form-input">
                            <label>City</label>
                        </div>
                        <div class="group">
                            <select id="state" name="Applicant[0][state]" title="State" class="applicant_0_state state form-input">
                                <option value=""></option>
                                <?php foreach ($arrStates as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                            <label for="state">State</label>
                            <span class="input-error-req d-none"></span>


                        </div>
                        <div class="group">
                            <input name="Applicant[0][zip]" type="text" placeholder=" " class="form-input">
                            <label>ZIP</label>
                        </div>
                    </div>
                    <div class="Cu-fourth">
                        <div class="group">
                            <select id="residence_type" name="Applicant[0][residence_type]" class="form-input">
                                <option value=""></option>
                                <option value="mortgage">Own home w/ mortgage</option>
                                <option value="own">Own home w/o mortgage</option>
                                <option value="rent">Rent</option>
                                <option value="relatives">Live with relative</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="residence_type">Residence Type</label>

                        </div>
                        <div class="group rent_mortgage">
                            <input name="Applicant[0][rent_payments]" type="text" placeholder=" " id="ApplicantRentPayments" class="form-input">
                            <label>Your Monthly Rentals</label>
                        </div>
                        <div class="group">
                            <select id="residence_years" name="Applicant[0][residence_years]" title="Year" class="form-input">
                                <option value=""></option>
                                <?php for ($i = date("Y"); $i >= 1920; $i--) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <label for="residence_years">Year</label>
                        </div>



                        <div class="group">
                            <select id="residence_months" name="Applicant[0][residence_months]" class="form-input">
                                <option value=""></option>
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <label for="residence_months">Months</label>
                        </div>
                    </div>


                    <div class="credit-app-block-title">Applicant Employment Information</div>
                    <div class="credit-app-block-subtitle">Please, enter your employment information.</div>

                    <div class="Cu-twice">
                        <div class="group">
                            <select name="Applicant[0][employment_status]" id="ApplicantEmploymentStatus" class="form-input">
                                <option value=""></option>
                                <option value="contract">Contract</option>
                                <option value="full time">Full Time</option>
                                <option value="na">N/A</option>
                                <option value="part time">Part Time</option>
                                <option value="retired">Retired</option>
                                <option value="seasonal">Seasonal</option>
                                <option value="self">Self-Employed</option>
                                <option value="temporary">Temporary</option>
                                <option value="pa">Public Assistance</option>
                            </select>
                            <label for="ApplicantEmploymentStatus">Employment Status</label>
                        </div>
                        <div class="group">
                            <input name="Applicant[0][occupation]" placeholder=" " type="text" class="form-input">
                            <label for="">Job Title</label>
                        </div>
                    </div>
                    <div class="Cu-twice">
                        <div class="group ">
                            <input name="Applicant[0][salary]" type="number" placeholder=" " id="Applicant0Salary" class="form-input">
                            <label>Gross Salary</label>
                        </div>
                        <div class="group">
                            <select name="Applicant[0][income_interval]" id="Applicant0IncomeInterval" class="form-input">
                                <option value=""></option>
                                <option value="weekly">Weekly</option>
                                <option value="biweekly">Bi-Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                            <label for="Applicant0IncomeInterval">Income Interval</label>
                        </div>
                    </div>


                    <div class="credit-app-block-title">Applicant Personal Reference Information.</div>
                    <div class="credit-app-block-subtitle">Please, enter your applicant personal reference information.</div>

                    <div class="Cu-three">
                        <div class="group">
                            <input name="Applicant[0][friend_first_name][0]" placeholder=" " type="text" class="form-input">
                            <label>First name</label>
                        </div>
                        <div class="group">
                            <input name="Applicant[0][friend_last_name][0]" placeholder=" " type="text" class="form-input">
                            <label>Last name</label>
                        </div>
                        <div class="group">
                            <input name="Applicant[0][friend_relationship][0]" placeholder=" " type="text" class="form-input">
                            <label>Relationship</label>
                        </div>
                    </div>
                    <div class="Cu-three">
                        <div class="group">
                            <input id="friend_home_phone" name="Applicant[0][friend_home_phone][0]" placeholder=" " type="tel" class="form-input">
                            <label>Work phone</label>
                        </div>
                        <div class="group">
                            <input id="friend_contact_phone" name="Applicant[0][friend_contact_phone][0]" placeholder=" " type="tel" class="form-input">
                            <label>Cell phone</label>
                        </div>
                        <div class="group">
                            <input name="Applicant[0][friend_email][0]" placeholder=" " type="email" class="form-input">
                            <label>Email Address</label>
                        </div>
                    </div>

                    <div class="Cu-one">
                        <div class=" group ">
                            <input name="Applicant[0][friend_address][0]" placeholder="Address" type="text" class="form-input">
                            <label>Address</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                    </div>

                    <div class="Cu-three">
                        <div class="group">
                            <input name="Applicant[0][friend_city][0]" placeholder=" " type="text" class="form-input">
                            <label>City</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                        <div class="group">
                            <select id="friend_state" name="Applicant[0][friend_state][0]" class="form-input">
                                <option value=""></option>
                                <?php foreach ($arrStates as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                            <label for="friend_state">State</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                        <div class="group">
                            <input name="Applicant[0][friend_zip][0]" placeholder=" " type="text" class="form-input">
                            <label>ZIP</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                    </div>
                    <div class="Cu-three">
                        <div class="group">
                            <select id="Applicantyears" name="Applicant[0][years][0]" class="form-input">
                                <option value=""></option>
                                <?php for ($i = 0; $i <= 30; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <label for="Applicantyears">Year</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                        <div class="group">
                            <select id="Applicantmonths" name="Applicant[0][months][0]" class="form-input">
                                <option value=""></option>
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <label for="Applicantmonths">Month</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                        <div class="group">
                            <input name="Applicant[0][friend_license_no][0]" placeholder=" " type="text" class="form-input">
                            <label>Driver’s License Number</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                    </div>



                    <div class="credit-app-block-title">Disclosure</div>

                    <div class="Cu-one">
                        <div class="group">
                            <textarea disabled="" name="disclosure" id="disclosure" rows="15" cols="45" placeholder=" " readonly="readonly"><?php echo esc_html($settings['custom_content']); ?></textarea>
                            <label>Disclosure</label>
                        </div>
                    </div>

                    <div class="Cu-one">
                        <div class="group acceptCondition">
                            <input type="checkbox" name="acceptCondition" value="0" id="acceptCondition" />
                            <label for="acceptCondition" class="f-s-13 f-w-500">I Understand and Accept the Terms and Conditions Above. *</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                    </div>

                    <div class="submit-group">
                        <button type="button" class="btn-send form-submit">submit</button>
                    </div>


                </form>
                <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>

            </div>

        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        

<?php
    }
}