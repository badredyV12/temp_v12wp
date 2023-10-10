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

class Essential_Elementor_Locate_Form_Widget extends \Elementor\Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_script('locate-js', $widget_folder_url . 'script/locate.js', ['jquery'], '1.1', true);
        wp_register_style('locate-css', $widget_folder_url . 'styles/locate.css');
        wp_enqueue_style('locate-css');
    }

    protected function register_controls()
    {
        $primary_color = get_theme_mod('primary_color'); 
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
                'default' => !empty($primary_color) ? $primary_color : '#ccc',
                'selectors' => [
                    '{{WRAPPER}} .locate-form-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'submit_hover_background_color',
            [
                'label' => esc_html__('Submit Hover Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00ff00', // Set your default hover color value here
                'selectors' => [
                    '{{WRAPPER}} .locate-form-btn:hover' => 'background-color: {{SUBMIT_HOVER_BACKGROUND_COLOR}};',
                ],
            ]
        );
    
        $this->add_control(
            'submit_text_color',
            [
                'label' => esc_html__('Text Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000', // Set your default text color value here
                'selectors' => [
                    '{{WRAPPER}} .locate-form-btn' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'submit_text_hover_color',
            [
                'label' => esc_html__('Text Hover Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff', // Set your default hover text color value here
                'selectors' => [
                    '{{WRAPPER}} .locate-form-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'label' => esc_html__('Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .locate-form-btn',
            ]
        );

        $this->add_control(
            'submit_button_width',
            [
                'label' => esc_html__('Button Width', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%', // Set the default unit to percentage
                    'size' => 30,  // Set the default size to 100
                ],
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
                    '{{WRAPPER}} .locate-form-btn' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'label' => esc_html__('Border', 'textdomain'),
                'selector' => '{{WRAPPER}} .locate-form-btn',
                'default' => [
                'border-style' => 'none', // Default border style
                'border-width' => '1px',   // Default border width
                'border-color' => '#000000', // Default border color
            ], // Set default border value to "none"
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_border_hover',
                'label' => esc_html__('Border on Hover', 'textdomain'),
                'selector' => '{{WRAPPER}} .locate-form-btn:hover',
                'default' => [
                'border-style' => 'none', // Default border style
                'border-width' => '1px',   // Default border width
                'border-color' => '#000000', // Default border color
            ], // Set default border value to "none"
            ]
        );


        $this->add_control(
            'submit_margin',
            [
                'label' => esc_html__('Margin', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .locate-form-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .locate-form-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();
    }

    public function get_script_depends()
    {
        return ['lead-widget-js', 'locate-js'];
    }

    public function get_style_depends()
    {
        return ['locate-css'];
    }


    public function get_name()
    {
        return 'locate-form';
    }

    public function get_title()
    {
        return esc_html__('locate Form', 'essential-elementor-widget');
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
        return ['locate', "v12", "locate form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);

?>

        <div id="locate-form-container">
            <div class="fs-title d-none">
                <h1>Locate A Car</h1>
            </div>
            <div class="fs-content">
                <form id="locate-form" class="form lead-form">
                    <input type="hidden" name="type_id" class="type_id valid" value="2" />
                    <input type="hidden" name="source_id" class="source_id valid" value="1">
                    <input type="hidden" name="user_id" class="user_id valid" value="<?php echo $dealer_id; ?>" />
                    <input type="hidden" id="post_slug" value="<?php echo $post_slug; ?>">

                    <div class="step-1 d-none active">
                        <div class="group">
                            <input type="text" title="locate" id="locate-make" title="Year, Make, Model" name="locate[note]" placeholder=" " class="locate[note] form-input valid">
                            <label>Year, Make, Model, Trim</label>
                            <span class="input-error-req d-none"></span>
                        </div>
                        <div class="Cu-three">
                            <div class="group">
                                <select name="locate[mileage]" title="Mileage" id="vehicle_mileage" class="valid">
                                    <option value="" disabled selected></option>
                                    <option value="15000">Under 15,000</option>
                                    <option value="30000">Under 30,000</option>
                                    <option value="45000">Under 45,000</option>
                                    <option value="60000">Under 60,000</option>
                                    <option value="75000">Under 75,000</option>
                                    <option value="100000">Under 100,000</option>
                                    <option value="100001">Over 100,000</option>
                                </select>
                                <label for="vehicle_mileage">Mileage</label>
                                <span class="input-error-req d-none">Mileage required.</span>
                            </div>
                            <div class="group">
                                <select name="vehicle_engine" id="vehicle_engine" class="valid">
                                    <option value="" disabled selected></option>
                                    <option value="3CLDR">3 Cylinders</option>
                                    <option value="4CLDR">4 Cylinders</option>
                                    <option value="5CLDR">5 Cylinders</option> 
                                    <option value="6CLDR">6 Cylinders</option>
                                    <option value="8CLDR">8 Cylinders</option>
                                    <option value="10CLDR">10 Cylinders</option>
                                    <option value="12CLDR">12 Cylinders</option>
                                    <option value="RTR">Rotary Engine</option>
                                </select>
                                <label for="vehicle_engine">Engines</label>

                            </div>
                            <div class="group">
                                <select name="vehicle_doors" id="vehicle_doors" class="valid">
                                    <option value=""></option>
                                    <option value="2Doors">Two Doors</option>
                                    <option value="3Doors">Three Doors</option>
                                    <option value="4Doors">Four Doors</option>
                                    <option value="5Doors">Five Doors</option>
                                </select>
                                <label for="vehicle_doors">Doors</label>
                            </div>
                        </div>

                        <div class="Cu-three">
                            <div class="group">
                                <select name="vehicle_price" id="vehicle_price" class="valid">
                                    <option value=""></option>
                                    <option value="$5,000-10,000">$5,000-$10,000</option>
                                    <option value="$10,000-15,000">$10,000-$15,000</option>
                                    <option value="$15,000-20,000">$15,000-$20,000</option>
                                    <option value="$20,000-25,000">$20,000-$25,000</option>
                                    <option value="$25,000-30,000">$25,000-$30,000</option>
                                    <option value="$30,000-35,000">$30,000-$35,000</option>
                                    <option value="$35,000-40,000">$35,000-$40,000</option>
                                    <option value="$40,000-50,000">$40,000-$50,000</option>
                                    <option value="$50,000+">$50,000+</option>
                                </select>
                                <label for="vehicle_price">Price</label>
                            </div>
                            <div class="group">
                                <select name="vehicle_transmission" id="vehicle_transmission" class="valid">
                                    <option value=""></option>
                                    <option value="Automatic">Automatic</option>
                                    <option value="Standard">Standard</option>
                                </select>
                                <label for="vehicle_transmission">Transmission</label>

                            </div>
                            <div class="group">
                                <select name="vehicle_body" id="vehicle_body" class="valid">
                                    <option value=""></option>
                                    <option value="CONVERT">Convertible</option>
                                    <option value="COUPE">Coupe</option>
                                    <option value="HATCH">Hatchback</option>
                                    <option value="SEDAN">Sedan</option>
                                    <option value="SUV">Sport Utility</option>
                                    <option value="TRUCKS">Truck</option>
                                    <option value="VANS">Van</option>
                                    <option value="WAGON">Wagon</option>
                                </select>
                                <label for="vehicle_body">Body Style</label>
                            </div>

                        </div>
                        <div class="Cu-three">
                            <p>Do you need financing?</p>
                            <div class="custom-radio Cu-twice">
                                <div class="radio-group">
                                    <input type="radio" checked name="options[vehicle_financing]" class="valid" value="yes" id="financing_yes">
                                    <label for="financing_yes">Yes</label>
                                </div>
                                <div class="radio-group">
                                    <input type="radio" name="options[vehicle_financing]" value="no" class="valid" id="financing_no">
                                    <label for="financing_no">No</label>
                                </div>
                            </div>

                          <div></div>
                        </div>
                        <div class="group" id="financing_select">
                                <select name="options[time_frame]" id="time_frame" class="valid">
                                    <option value=""></option>
                                    <option value="Now">Now</option>
                                    <option value="One week">One week</option>
                                    <option value="Two weeks">Two weeks</option>
                                    <option value="One month">One month</option>
                                </select>
                                <label for="time_frame">What is your time frame?</label>
                            </div>
                        <div class="Cu-three">
                            <div class="Cu-one">
                                <p>Do you have a trade-in?</p>
                            </div>
                            <div class="custom-radio Cu-twice">
                                <div class="radio-group">
                                    <input type="radio" checked="" name="options[vehicle_tradin]" class="valid" value="yes" id="vehicle_tradin_yes">
                                    <label for="vehicle_tradin_yes">Yes</label>
                                </div>
                                <div class="radio-group">
                                    <input type="radio" name="options[vehicle_tradin]" class="valid" value="No" id="vehicle_tradin_no">
                                    <label for="vehicle_tradin_no">No</label>
                                </div>
                            </div>
                            <div class="group">
                            </div>
                        </div>
                        <div class="Cu-three" id="vehicle_tradin_select">
                            <div class="group">
                                <select name="trade_in[year]" id="trade_in_yearYear" class="valid">
                                    <option value=""></option>
                                    <?php for ($i = date("Y"); $i >= 1980; $i--) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="trade_in_yearYear">Trade-in Year</label>
                            </div>
                            <div class="group">
                                <select name="trade_in_make" id="trade_in_make" class="valid">
                                    <option value=""></option>
                                    <option value="191"></option>
                                    <option value="1">Acura</option>
                                    <option value="2">Alfa Romeo</option>
                                    <option value="3">AMC</option>
                                    <option value="4">Aston Martin</option>
                                    <option value="5">Audi</option>
                                    <option value="6">Austin</option>
                                    <option value="7">Austin Healey</option>
                                    <option value="9">Bentley</option>
                                    <option value="10">BMW</option>
                                    <option value="11">Bugatti</option>
                                    <option value="12">Buick</option>
                                    <option value="13">Cadillac</option>
                                    <option value="14">Chevrolet</option>
                                    <option value="15">Chrysler</option>
                                    <option value="16">Citroen</option>
                                    <option value="17">Cord</option>
                                    <option value="18">Daewoo</option>
                                    <option value="19">Datsun</option>
                                    <option value="291">DeLorean</option>
                                    <option value="20">DeSoto</option>
                                    <option value="21">Dodge</option>
                                    <option value="22">Eagle</option>
                                    <option value="23">Edsel</option>
                                    <option value="24">Ferrari</option>
                                    <option value="25">Fiat</option>
                                    <option value="26">Ford</option>
                                    <option value="27">Geo</option>
                                    <option value="28">GMC</option>
                                    <option value="29">Honda</option>
                                    <option value="30">Hummer</option>
                                    <option value="31">Hyundai</option>
                                    <option value="32">Infiniti</option>
                                    <option value="77">International Harvester</option>
                                    <option value="33">Isuzu</option>
                                    <option value="34">Jaguar</option>
                                    <option value="35">Jeep</option>
                                    <option value="36">Kia</option>
                                    <option value="37">Lamborghini</option>
                                    <option value="38">Lancia</option>
                                    <option value="39">Land Rover</option>
                                    <option value="40">Lexus</option>
                                    <option value="41">Lincoln</option>
                                    <option value="42">Lotus</option>
                                    <option value="43">Maserati</option>
                                    <option value="289">Maybach</option>
                                    <option value="44">Mazda</option>
                                    <option value="316">Mclaren</option>
                                    <option value="45">Mercedes Benz</option>
                                    <option value="46">Mercury</option>
                                    <option value="47">MG</option>
                                    <option value="76">Mini</option>
                                    <option value="48">Mitsubishi</option>
                                    <option value="49">Nissan</option>
                                    <option value="50">Oldsmobile</option>
                                    <option value="51">Opel</option>
                                    <option value="52">Packard</option>
                                    <option value="290">Panoz</option>
                                    <option value="53">Peugeot</option>
                                    <option value="54">Plymouth</option>
                                    <option value="55">Pontiac</option>
                                    <option value="56">Porsche</option>
                                    <option value="1002">RAM</option>
                                    <option value="57">Renault</option>
                                    <option value="428">Reo</option>
                                    <option value="58">Rolls-Royce</option>
                                    <option value="286">RUF</option>
                                    <option value="59">Saab</option>
                                    <option value="60">Saturn</option>
                                    <option value="75">Scion</option>
                                    <option value="288">Shelby</option>
                                    <option value="287">Smart</option>
                                    <option value="62">Studebaker</option>
                                    <option value="63">Subaru</option>
                                    <option value="64">Suzuki</option>
                                    <option value="65">Toyota</option>
                                    <option value="66">Triumph</option>
                                    <option value="67">Volkswagen</option>
                                    <option value="68">Volvo</option>
                                    <option value="69">Willys</option>
                                    <option value="137">Other</option>
                                </select>
                                <label for="trade_in_make">Trade-in Make</label>
                            </div>
                            <div class="group">
                                <input type="text" title="Model" name="trade_in_model" id="trade_in_model" placeholder=" " class="form-input valid">
                                <label>Trade-in Model</label>
                            </div>

                        </div>

                        <div class="submit-group">
                            <button type="button" disabled="disabled" class="next form-btn-next locate-form-btn">Next</button>
                        </div>

                    </div>
                    <div class="step-2 d-none">
                        <div class="Cu-twice">
                            <div class="group">
                                <input type="text" title="First name" name="first_name" placeholder=" " class="first_name form-input">
                                <label>First Name</label>
                                <span class="input-error-req d-none"></span>
                            </div>

                            <div class="group">
                                <input type="text" title="Last name" placeholder=" " name="last_name" class="last_name form-input">
                                <label>Last Name</label>
                                <span class="input-error-req d-none"></span>
                            </div>

                        </div>
                        <div class="Cu-one">
                            <div class="group">
                                <input type="email" title="E-mail" placeholder=" " name="email" class="email form-input">
                                <label>Email address</label>
                                <span class="input-error-req d-none"></span>
                            </div>
                        </div>

                        <div class="Cu-twice">
                            <div class="group">
                                <input type="Tel" id="phone" title="Phone Number" placeholder=" " name="phone" class="phone form-input" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                <label>Phone Number </label>
                                <span class="input-error-req d-none"></span>
                            </div>
                            <div class="group">
                                <input type="number" title="Zip Code" placeholder=" " name="zip_code" class="zip_code form-input" id="zip_code">
                                <label>Zip Code </label>
                                <span class="input-error-req d-none"></span>
                            </div>
                        </div>
                        <div class="Cu-twice">
                            <p>How would you like to be contacted ?</p>
                            <div class="Cu-three">
                                <div class="checkbox-group">
                                    <input type="checkbox" name="text-us[]" value="call" id="call" class="valid text-us[]">
                                    <label for="call"> Call</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" name="text-us[]" value="sms" id="sms" class="valid text-us[]">
                                    <label for="sms"> SMS</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" name="text-us[]" value="email" id="email" class="valid text-us[]">
                                    <label for="email"> Email</label>
                                </div>
                            </div>
                        </div>

                        <div class="submit-group">
                            <button type="button" class="prev form-btn-prev locate-form-btn">Prev</button>
                            <button type="button" class="btn-send form-submit locate-form-btn">submit</button>
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
