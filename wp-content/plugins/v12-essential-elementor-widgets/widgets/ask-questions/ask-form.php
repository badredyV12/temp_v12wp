<?php




if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Essential_Elementor_Ask_Form_Widget extends \Elementor\Widget_Base
{

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        // Enqueue your custom stylesheet here
        $widget_folder_url = plugin_dir_url(__FILE__);
        wp_register_style('ask-questions-css', $widget_folder_url . '/style.css', [], '1.1' );
    }

    public function get_style_depends() {
        return [ 'ask-questions-css' ];
    }


    public function get_name()
    {
        return 'ask form';
    }

    public function get_title()
    {
        return esc_html__('ask Form', 'essential-elementor-widget');
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
        return ['ask', "v12", "ask form"];
    }


    protected function render()
    {
        $dealer_id = get_option('dealer_id'); // Retrieve dealer_id from wp_options
      //  $dealer_id = 100108; // Retrieve dealer_id from wp_options
        ?>

       
        <div class="fs-container">
            <div class="fs-title">
                <h1>Contact Us</h1>
            </div>

            <div class="fs-content">
                <form id="ask-form" class="form"  >
                    <input type="hidden" name="type_id" value="9" />
                    <input type="hidden" name="user_id" value="<?php echo $dealer_id; ?>" />

                    <div class="group">
                        <input type="text"  name="additional_comments" >
                        <label>Please, let us know how we can help?</label>
                    </div>
                    <div class="Cu-twice">
                        <div class="group">
                            <input type="text" required name="first_name" >
                            <label>First Name</label>
                        </div>
                        <div class="group">
                            <input type="text" required name="last_name">
                            <label>Last Name</label>
                        </div>
                        <div class="group">
                            <input type="email" required name="email">
                            <label>Email address</label>
                        </div>
                        <div class="group">
                            <input type="Tel" required name="phone">
                            <label>Phone Number </label></div>
                        <input type="hidden" name="source_id" value="1">

                    </div>
                    <p>How would you like to be contacted ?</p>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="contact_via[]" value="call"> Call</label>
                        <label><input type="checkbox" name="contact_via[]" value="sms"> SMS</label>
                        <label><input type="checkbox" name="contact_via[]" value="email"> Email</label>
                    </div>

                    <input type="submit" value="submit">
                </form>
                <div id="response-message"></div>
                <div id="loader" style="display: none;">Submitting...</div>

            </div>

        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var askForm = document.getElementById("ask-form");
                var responseMessage = document.getElementById("response-message");
                var loader = document.getElementById("loader");

                askForm.addEventListener("submit", function (event) {
                    event.preventDefault();
                    loader.style.display = "block";

                    var formData = new FormData(askForm);

                    // Gather selected checkbox values
                    var selectedCheckboxes = Array.from(askForm.querySelectorAll('input[type="checkbox"]:checked')).map(function(checkbox) {
                        return checkbox.value;
                    });

                    // Set the gathered values as the value for options[ask_via]
                    formData.set("options[ask_via]", selectedCheckboxes.join(','));

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "/test-v12?_ajax=true&ACT=api");
                    xhr.setRequestHeader("Authorization", "Bearer REFx1MRtzW7k3mzY0tJWikz47DjoKtOB");

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            loader.style.display = "none";

                            if (xhr.status === 200) {
                                responseMessage.textContent = "Lead has been submitted successfully.";
                            } else {
                                responseMessage.textContent = "Error submitting lead: " + xhr.statusText;
                            }

                            // Hide the message after 3 seconds
                            setTimeout(function () {
                                responseMessage.textContent = "";
                            }, 2500);
                        }
                    };

                    xhr.send(formData);
                });
            });

        </script>


        <?php
    }


}

