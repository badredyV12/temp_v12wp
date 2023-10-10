<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Essential_Elementor_Price_Calculator_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'card';
	}

	public function get_title() {
		return esc_html__( 'Price Calculator', 'essential-elementor-widget' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_custom_help_url() {
		return 'https://exapmple.com/';
	}

	public function get_categories() {
		return [ "general" ];
	}

	public function get_keywords() {
		return [ 'price', 'calculator', 'finance', "v12" ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html( 'content', 'essential-elementor-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		$this->add_control(
			'card_title',
			[
				'label'       => esc_html__( 'Card title', 'essential-elementor-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Your card title here', 'essential-elementor-widget' ),
			]
		);
		$this->add_control(
			'card_description',
			[
				'label'       => esc_html__( 'Card Description', 'essential-elementor-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Your card description here', 'essential-elementor-widget' ),
			]
		);
		$this->add_control(
			"input_01", [
				'label'       => esc_html__( 'Input 01', 'essential-elementor-widget' ),
				'default'     => 'first number',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'input text here', 'essential-elementor-widget' ),
			]
		);
		$this->add_control(
			"input_02", [
				'label'       => esc_html__( 'Input 02', 'essential-elementor-widget' ),
				'default'     => 'second number',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'input text here', 'essential-elementor-widget' ),
			]
		);
		$this->add_control( 'loan_calculator', [
			'label'        => esc_html__( 'Loan calculator', 'essential-elementor-widget' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show' ),
			'label_off'    => esc_html__( 'Hide' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );
		$this->add_control( 'lease_calculator', [
			'label'        => esc_html__( 'Lease calculator', 'essential-elementor-widget' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show' ),
			'label_off'    => esc_html__( 'Hide' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );
		$this->add_control( 'what_i_can_afford', [
			'label'        => esc_html__( 'What i can afford', 'essential-elementor-widget' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show' ),
			'label_off'    => esc_html__( 'Hide' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );
		$this->add_control( 'style_calculator', [
			'label'   => esc_html__( 'Style Calculator', 'essential-elementor-widget' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'style_01',
			'options' => [
				'style_01' => esc_html__( 'style_01' ),
				'style_02' => esc_html__( 'style_02' ),
			]
		] );
		$this->end_controls_section();

		/*style control*/

		$this->start_controls_section(
			'section_style', [
				'label' => esc_html__( "style", "essential-elementor-widget" ),
				"tab"   => \Elementor\Controls_Manager::TAB_STYLE
			]
		);
		$this->add_control(
			'title_options',
			[
				'label'     => esc_html__( 'Title Options', 'essential-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'essential-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f00',
				'selectors' => [
					'{{WRAPPER}} h3' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} h3',
			]
		);

		$this->add_control(
			'description_options',
			[
				'label'     => esc_html__( 'Description Options', 'essential-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'essential-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f00',
				'selectors' => [
					'{{WRAPPER}} .card__description' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .card__description',
			]
		);
		$this->end_controls_section();

		/*controls for calculator styling [color , font]*/

	}

	protected function render() {

		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();

		// get the individual values of the input
		$card_title        = $settings['card_title'];
		$card_description  = $settings['card_description'];
		$input_01          = $settings['input_01'];
		$input_02          = $settings['input_02'];
		$loan_calculator   = $settings['loan_calculator'];
		$lease_calculator  = $settings['lease_calculator'];
		$what_i_can_afford = $settings['what_i_can_afford'];
		$style_calculator  = $settings['style_calculator'];

		?>

        <!-- Start rendering the output -->


        <!-- Start Calculator forms -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');


            .group {
                display: flex;
                flex-direction: column;
                margin-bottom: 10px;
            }


            input {
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;

            }


            .tab-container {
                border: 1px solid #ccc;
                max-width: 100%;
                padding: 50px ;
                margin: 50px auto;

            }

            .tab {
                display: flex;
                flex-direction: row;
                justify-content: start;
            }

            .tab button {
                background-color: inherit;
                font-weight: bold;
                text-transform: uppercase;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 20px 20px;
                transition: 0.3s;
                font-size: 16px;
                border-bottom: 1px solid transparent;

            }

            .tab button:hover {
                background-color: #F8F8F8;
            }

            .tab button.active {
                border-color: #6C12FF;
            }

            .tabcontent {
                display: none;
                padding: 10px;
            }

            .tabcontent.show {
                display: block;
            }

            input[type="submit"] {
                font-family: poppins;
                text-transform: uppercase;
                display: block;
                width: 30%;
                padding: 10px;
                margin-top:-8px;
                background-color: #6C12FF;
                color: #fff;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
                opacity: 1;
                transition: opacity 0.3s ease;
            }

            input[type="submit"]:hover {
                opacity: 0.8;
            }

            .tablinks{
                font-family: poppins;
            }
            .form{
                display: grid;
                grid-template-columns: auto auto auto;
                grid-gap: 30px;
                padding: 10px;
            }

            .payement-group{

                display: flex;
                justify-content: space-between;

            }
            .twice{
                display: grid;
                grid-template-columns: auto auto;
                grid-gap: 30px;
                padding: 10px;
            }





            /* ---------------------------------------------for the tablet view----------------------------------------------- */

            @media screen and (max-width: 1018px) {

                .tab button {
                    padding: 15px 30px;
                    font-size: 14px;
                }
                .form{
                    display: grid;
                    grid-template-columns: auto auto ;
                    grid-gap: 30px;
                    padding: 10px;
                }
                .payement-group{

                    font-size: 12px;


                }
                input[type="submit"]{
                    margin-top: -14px;
                }
            }

            /* ---------------------------------------------for the mobile view-------------------------------------------------*/


            @media screen and (max-width: 700px) {

                .tab {
                    flex-direction: column;
                }
                .twice{
                    display: grid;
                    grid-template-columns: 1fr;
                    grid-gap: 30px;
                    padding: 10px;
                }
                .form{
                    display: grid;
                    grid-template-columns: 1fr;
                    grid-gap: 30px;
                    padding: 10px;
                }
                input[type="submit"] {
                    font-family: poppins;
                    text-transform: uppercase;
                    display: block;
                    width: 100%;
                    padding: 5px auto;
                    margin-top:-8px;
                    background-color: #6C12FF;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    font-size: 12px;
                    cursor: pointer;
                    opacity: 1;
                    transition: opacity 0.3s ease;
                }
                .payement-group{

                    flex-direction: column;
                    gap: 20px;
                }
            }
        </style>
        <div class="tab-container">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'Loan calculator')">Loan calculator</button>
                <button class="tablinks" onclick="openTab(event, 'Lease calculator')">Lease calculator</button>
                <button class="tablinks" onclick="openTab(event, 'What Can I Afford?')">What Can I Afford?</button>
            </div>

            <div id="Loan calculator" class="tabcontent">
                <div class="form">
                    <div class="group">
                        <label>Vehicle price:</label>
                        <input type="number" name="Vehicle price" placeholder="$54.567" required>
                    </div>
                    <div class="group">
                        <label>Sales Tax:</label>
                        <input type="number" name="Sales Tax" placeholder="542" required>
                    </div>
                    <div class="group">
                        <label>Interest Rate:</label>
                        <input type="number" name="Interest Rate" placeholder="0.00" required>
                    </div>
                    <div class="group">
                        <label>Down payment:</label>
                        <input type="number" name="Down payment" placeholder="354" required>
                    </div>
                    <div class="group">
                        <label>Trade-In Value:</label>
                        <input type="number" name="Trade-In Value" placeholder="87" required>
                    </div>
                    <div class="group">
                        <label>Months:</label>
                        <input type="number" name="Months" placeholder="18" required>
                    </div>

                </div>
                <h4 class="title">payment details:</h4>
                <div class="payement-group">
                    <div>
                        <span class="text">18 monthly payments of :</span>
                        <span class="num">0</span>
                    </div>
                    <div>
                        <span class="text">Amount financed ($) :</span>
                        <span class="num">0</span>
                    </div>
                    <input type="submit" value="Calculate">
                </div>
            </div>

            <div id="Lease calculator" class="tabcontent">

                <div class="form">
                    <div class="group">
                        <label>Vehicle price:</label>
                        <input type="number" name="Vehicle price" placeholder="$54.567" required>
                    </div>
                    <div class="group">
                        <label>Sales Tax:</label>
                        <input type="number" name="Sales Tax" placeholder="542" required>
                    </div>
                    <div class="group">
                        <label>Residual Value:</label>
                        <input type="number" name="Residual Value" placeholder="0.00" required>
                    </div>
                </div>
                <div class="twice">
                    <div class="group">
                        <label>Down payment:</label>
                        <input type="number" name="Down payment" placeholder="354" required>
                    </div>
                    <div class="group">
                        <label>Trade-In Value:</label>
                        <input type="number" name="Trade-In Value" placeholder="87" required>
                    </div>
                </div>
                <div class="twice"><div class="group">
                        <label>Mony Factor:</label>
                        <input type="number" name="Mony Factor" placeholder="18" required>
                    </div>
                    <div class="group">
                        <label>Months:</label>
                        <input type="number" name="Months" placeholder="12" required>
                    </div></div>


                <h4 class="title">payment details:</h4>
                <div class="payement-group">
                    <div>
                        <span class="text">18 monthly payments of :</span>
                        <span class="num">0</span>
                    </div>
                    <div>
                        <span class="text">Amount financed ($) :</span>
                        <span class="num">0</span>
                    </div>
                    <input type="submit" value="Calculate">
                </div>
            </div>

            <div id="What Can I Afford?" class="tabcontent">

                <div class="form">
                    <div class="group">
                        <label>Vehicle price:</label>
                        <input type="number" name="Vehicle price" placeholder="$54.567" required>
                    </div>
                    <div class="group">
                        <label>Sales Tax:</label>
                        <input type="number" name="Sales Tax" placeholder="34" required>
                    </div>
                    <div class="group">
                        <label>Interest Rate:</label>
                        <input type="number" name="Interest Rate" placeholder="0.00" required>
                    </div>
                    <div class="group">
                        <label>Down payment:</label>
                        <input type="number" name="Down payment" placeholder="354" required>
                    </div>
                    <div class="group">
                        <label>Trade-In Value:</label>
                        <input type="number" name="Trade-In Value" placeholder="87" required>
                    </div>
                    <div class="group">
                        <label>Months:</label>
                        <input type="number" name="Months" placeholder="18" required>
                    </div>
                </div>

                <h4 class="title">payment details:</h4>
                <div class="payement-group">
                    <div>
                        <span class="text">18 monthly payments of :</span>
                        <span class="num">0</span>
                    </div>
                    <div>
                        <span class="text">Amount financed ($) :</span>
                        <span class="num">0</span>
                    </div>
                    <input type="submit" value="Calculate">
                </div>
            </div>
        </div>

        <script>
            function openTab(event, tabName) {
                // Hide all tabcontent elements
                var tabcontent = document.getElementsByClassName("tabcontent");
                for (var i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }

                // Remove the "active" class from all tablinks
                var tablinks = document.getElementsByClassName("tablinks");
                for (var i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                // Show the current tab, and add an "active" class to the button that opened the tab
                document.getElementById(tabName).style.display = "block";
                event.currentTarget.className += " active";
            }

            // Set the first tab as active by default
            document.getElementsByClassName("tablinks")[0].click();

        </script>
        <!-- End Calculator forms -->

        <!-- End rendering the output -->

		<?php

	}
}