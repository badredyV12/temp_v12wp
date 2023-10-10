<?php
// Add the custom menu page
function v12_dealer_info_menu() {
    add_menu_page(
        'V12 Dealer Info',
        'V12 Dealer Info',
        'manage_options',
        'v12-dealer-info',
        'v12_dealer_info_page'
    );
}

add_action('admin_menu', 'v12_dealer_info_menu');