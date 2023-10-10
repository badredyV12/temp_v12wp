<?php
/**
 * Plugin Name: Widget Vdp Finance Form
 * Description: Elementor custom widgets for v12.
 * Plugin URI:  https://www1.v12software.com/
 * Version:     1.0.0
 * Author:      Azeddine ATOUANI
 * Text Domain: essential-elementor-widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_New_Vdp_Finance_Form_Widget extends \Elementor\Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $widget_folder_url = plugin_dir_url(__FILE__);
        // wp_register_script('lead-widget-js', $widget_folder_url . 'lead-form.js', ['jquery'], '1.1', true);
        wp_register_script('new-vdp-finance-js', $widget_folder_url . 'script/new-vdp-finance.js', ['jquery'], '1.1', true);
        wp_register_style( 'new-vdp-finance-css', $widget_folder_url.'styles/new-vdp-finance.css');
        wp_enqueue_style('new-vdp-finance-css');


    }

    protected function register_controls()
    {
        $primary_color =  \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY;
        // Controls in the existing "style_section" (if it exists)
        $this->start_controls_section(
            'form_buttons_styles_section',
            [
                'label' => esc_html__('Form Buttons Styles', 'textdomain'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    

        $this->add_control(
            'border_class',
            [
                'label' => __('Border CSS Class', 'your-plugin-text-domain'),
                'description' => esc_html__( 'Border (Estimated Credit Score, Term Length (months)).', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .selected' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accent_color_class',
            [
                'label' => __('Accent Color CSS', 'your-plugin-text-domain'),
                'description' => esc_html__( 'Accent Color (Input Range).', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} input[type="range"]' => 'accent-color: {{VALUE}};',
                ],
            ]
        );

        
        $this->add_control(
            'background_class',
            [
                'label' => __('background CSS Class', 'your-plugin-text-domain'),
                'description' => esc_html__( 'background button Get Pre-Approved.', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-btn-credit-app a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    }


    public function get_script_depends()
    {
        return ['new-vdp-finance-js'];
    }

    public function get_style_depends() {
        return [ 'new-vdp-finance-css' ];
    }

    public function get_name()
    {
        return 'new-vdp-finance-form';
    }

    public function get_title()
    {
        return esc_html__('vdp finance Form', 'essential-elementor-widget');
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
        return ['new vdp finance', "v12", "new vdp finance form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
        // Get the current post ID
        $post_id = get_the_ID();
        $post_slug = get_post_field('post_name', $post_id);


        // Get the post meta data for "price"
        $price = str_replace(',','',get_post_meta($post_id, 'price', true)) ;

        // $price = 18900;
        $down_payement=0;
        $maxTradeIn = $price;
        if($price != "")
        {
            $down_payement = intval($price * 0.1);  // down payement = price / 100 * 10
            $maxTradeIn = $price - $down_payement;
        }else{
            $price = 0;
        }

        
        $interest_rate = 6;
        $loan_term = 60;

?>

        <div class="calculator-container calc-page-container">
            <div class="left-column-finance">
                <input type="hidden" class="calc-vehicle-price" value="<?php echo $price; ?>" />
                <input type="hidden" class="calc-sales-tax" id="other_fees" value="0">
                <input type="hidden" class="calc-interest-rate"  value="<?php echo $interest_rate ?>">
                <input type="hidden" class="calc-loan-term"  value="<?php echo $loan_term ?>">
                <input type="hidden" class="cal-month-payement-without-down-tradin"  value="0">

                <?php if($price == 0) { ?>
                <div class="input-block-price group">
                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder=" " class="form-input price-value">
                    <label>Vehicle Price</label>

                </div>
                
                <?php } ?>
                <div class="title">Estimated Credit Score</div>
                <div class="card-list card-list-estimates-credit">
                    <div class="card-estimates-credit">≤ 640</div>
                    <div class="card-estimates-credit">641-699</div>
                    <div class="card-estimates-credit selected">700-749</div>
                    <div class="card-estimates-credit">750-850</div>
                </div>
                <div class="block-range">
                    <div class="group">
                        <span class="estimates-monthly-payment-text">Monthly Payment </span>
                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="estimates-monthly-payment-value">
                    </div>
                    <div class="range">
                        <input type="range" class="estimates-monthly-payment-range" min="0" max="<?php echo $price ?>">
                    </div>
                </div>
                <div class="block-range">
                    <div class="group">
                        <span class="down-payment-text">Down Payment</span>
                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="down-payment-value" value="<?php echo $down_payement ?>">
                    </div>
                    <div class="range">
                        <input type="range" class="down-payment-range" min="0" max="<?php echo $price ?>" value="<?php echo $down_payement ?>">
                    </div>
                </div>
                <div class="block-range">
                    <div class="group">
                        <span class="trade-in-text">Trade-In Value</span>
                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="trade-in-value" value="0">
                    </div>
                    <div class="range">
                        <input type="range" class="trade-in-range" min="0" max="<?php echo $maxTradeIn ?>" value="0">
                    </div>
                </div>
                <div class="title">Term Length (months)</div>
                <div class="card-list card-list-term-month">
                    <div class="card-term-month">48</div>
                    <div class="card-term-month selected">60</div>
                    <div class="card-term-month">72</div>
                    <div class="card-term-month">84</div>
                </div>
            </div>
            <div class="right-column-finance">
                <div class="finance price-estimate-top">
                    <span class="price-estimate-prefix">$</span>
                    <span id="pmt" class="calc-monthly-payment"></span>
                    <span class="price-estimate-suffix">/mo</span>
                </div>
                <div class="price-estimate-bottom">
                    <span><span class="ir"></span> % APR</span>
                    <span><span class="month"><?php echo $loan_term ?></span> Months</span>
                    <span>$<span class="down"><?php echo $down_payement ?> </span> Down</span>
                </div>

                <div class="block-btn-credit-app">
                    <a class=" " href="/credit-application">
				        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Capa_1" x="0px" y="0px" width="510px" height="510px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve"><g>	<g id="check-circle-outline">		<path d="M150.45,206.55l-35.7,35.7L229.5,357l255-255l-35.7-35.7L229.5,285.6L150.45,206.55z M459,255c0,112.2-91.8,204-204,204   S51,367.2,51,255S142.8,51,255,51c20.4,0,38.25,2.55,56.1,7.65l40.801-40.8C321.3,7.65,288.15,0,255,0C114.75,0,0,114.75,0,255   s114.75,255,255,255s255-114.75,255-255H459z"></path>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>			</span>
						Get Pre-Approved
					</a>
                </div>

            </div>

        </div>
        <button id="loan_calculat" style="display: none;">ESTIMATE MONTHLY Payment</button>

      

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<?php
    }
}