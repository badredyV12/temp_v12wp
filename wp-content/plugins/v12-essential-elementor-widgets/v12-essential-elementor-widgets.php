<?php
/**
 * Plugin Name: V12 Essential Elementor Widgets
 * Description: Elementor custom widgets for v12.
 * Plugin URI:  https://www1.v12software.com/
 * Version:     1.0.0
 * Author:      Badr eddine rahali
 * Text Domain: essential-elementor-widget
 */
if (!defined('ABSPATH')) {
    exit;
}



function register_essential_custom_widgets($widgets_manager)
{
    require_once(__DIR__ . '/leads.php');

    require_once(__DIR__ . '/widgets/price-calculator.php');  // include the widget file
    $widgets_manager->register(new \Essential_Elementor_Price_Calculator_Widget());  // register the widget

    require_once(__DIR__ . '/widgets/main-image.php');
    $widgets_manager->register(new \Essential_Elementor_Main_Image_Widget());

    require_once(__DIR__ . '/widgets/search-form-vehicles.php');
    $widgets_manager->register(new \Essential_Elementor_Search_Form_Vehicles_Widget());

    require_once(__DIR__ . '/widgets/loop-item.php');
    $widgets_manager->register(new \Essential_Elementor_Loop_Item_Widget());

    require_once(__DIR__ . '/widgets/contact-form.php');
    $widgets_manager->register(new \Essential_Elementor_Contact_Form_Widget());

    // require_once(__DIR__ . '/widgets/contact-form-lading-page.php');
    // $widgets_manager->register(new \Essential_Elementor_Contact_Form_landing_page_Widget());

    require_once(__DIR__ . '/widgets/inventory/inventory.php');
    $widgets_manager->register(new \Essential_Elementor_Inventory_Widget());

    require_once(__DIR__ . '/widgets/ask-question-form.php');
    $widgets_manager->register(new \Essential_Elementor_Ask_Form_Widget());
    
    require_once(__DIR__ . '/widgets/ask-question-form-footer.php');
    $widgets_manager->register(new \Essential_Elementor_Ask_Form_Footer_Widget());
    
 

    require_once(__DIR__ . '/widgets/locate-form.php');
    $widgets_manager->register(new \Essential_Elementor_Locate_Form_Widget());

    require_once(__DIR__ . '/widgets/sell-form.php');
    $widgets_manager->register(new \Essential_Elementor_Sell_Form_Widget());

    require_once(__DIR__ . '/widgets/traded-cars-form.php');
    $widgets_manager->register(new \Essential_Elementor_Trade_Form_Widget());

    require_once(__DIR__ . '/widgets/make-offer-form.php');
    $widgets_manager->register(new \Essential_Elementor_Make_Offer_Form_Widget());

    require_once(__DIR__ . '/widgets/finance-form.php');
    $widgets_manager->register(new \Essential_Elementor_Finance_Form_Widget());

    require_once(__DIR__ . '/widgets/test-drive-form.php');
    $widgets_manager->register(new \Essential_Elementor_Test_Drive_Form_Widget());
    
    require_once(__DIR__ . '/widgets/credit-app-form.php');
    $widgets_manager->register(new \Essential_Elementor_Credit_App_Form_Widget());

    require_once(__DIR__ . '/widgets/test-drive-button.php');
    $widgets_manager->register(new \Essential_Elementor_Test_Drive_Form_btn_Widget());


    require_once(__DIR__ . '/widgets/vdp-finance-form.php');
    $widgets_manager->register(new \Essential_Elementor_Vdp_Finance_Form_Widget());
    
    
    require_once(__DIR__ . '/widgets/test_drive_popup.php');
    $widgets_manager->register(new \Essential_Elementor_Test_Drive_popup_Form_Widget());
    
    require_once(__DIR__ . '/widgets/slider-vdp-widget.php');
    $widgets_manager->register(new \Slider_Vdp_Widget());

    require_once(__DIR__ . '/widgets/loop-galleries-widget.php');
    $widgets_manager->register(new \Loop_Galleries_Widget());

    require_once(__DIR__ . '/widgets/slider-vdp-test-drive-widget.php');
    $widgets_manager->register(new \Slider_Vdp_Test_Drive_Widget());

    require_once(__DIR__ . '/widgets/new-vdp-finance-form.php');
    $widgets_manager->register(new \Essential_Elementor_New_Vdp_Finance_Form_Widget());
    
    require_once(__DIR__ . '/widgets/text-us-form.php');
    $widgets_manager->register(new \Essential_Elementor_Text_Us_Form_Widget());

}

add_action('elementor/widgets/register', 'register_essential_custom_widgets');

// die("register_essential_custom_widgets");
