$(document).ready(function () {

    input_validate()
    let arrClass = {
        "options[zip_code]": "zip_code",
        "options[offer]": "MakeOffer",
        "Applicant[0][first_name]": "first_name",
        "Applicant[0][last_name]": "last_name",
        "Applicant[0][contact_phone]": "contact_phone",
        "Applicant[0][email]": "email",
        "Applicant[0][year]": "applicant_0_year",
        "Applicant[0][day]": "applicant_0_day",
        "Applicant[0][month]": "applicant_0_month",
        "Applicant[0][ssn]": "applicant_0_ssn",
        "Applicant[0][state]": "applicant_0_state",
        "Vehicle[0][id]": "Vehicle0Id"
    }


    $(".submit-group .btn-send").click(function (event) {
        var form_data = $(".lead-form").serializeArray();
        var error_free = true;

        console.log("formdata:", form_data)

        for (var input in form_data) {

            if (form_data[input]['name'] != "contact_via[]" && form_data[input]['name'] != "text-us[]") {

                if (in_array(arrClass, form_data[input]['name'])) {
                    var index = form_data[input]['name']
                    form_data[input]['name'] = arrClass[index]
                }

                var element = $("." + form_data[input]['name']);

                if (element.hasClass(form_data[input]['name'])) {

                    var valid = element.hasClass("valid");
                    var error_element = $(".input-error-req", element.parent());
                    var error_text = element.attr('title');

                    if (!valid) {
                        error_element.removeClass('d-none').text(`${error_text} required.`);
                        element.addClass('invalid')
                        error_free = false;

                    }
                    else {
                        error_element.addClass("d-none").text('');
                        element.addClass('valid')

                    }
                }
            }

        }

        // if($('input[type="checkbox"]:checked').length == 0)
        // {
        //     error_free=false;
        //     alert("checkbox");
        // }


        if (!error_free) {
            event.preventDefault();
        }
        else {
            send_form()
        }
    });

})





const isNumericInput = (event) => {
    const key = event.keyCode;
    return ((key >= 48 && key <= 57) || // Allow number line
        (key >= 96 && key <= 105) // Allow number pad
    );
};



const formatToPhone = (event) => {

    // I am lazy and don't like to type things more than once
    const target = event.target;
    const input = event.target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
    const zip = input.substring(0, 3);
    const middle = input.substring(3, 6);
    const last = input.substring(6, 10);

    if (input.length > 6) { target.value = `(${zip}) ${middle} - ${last}`; }
    else if (input.length > 3) { target.value = `(${zip}) ${middle}`; }
    else if (input.length > 0) { target.value = `(${zip}`; }
};


function in_array(data, key) {
    for (var k in data) {
        if (k.toString() == key.toString()) {
            return true
        }
    };
    return false
}

function input_validate() {

    $('input[type=text],input[type=number]').on('input', function () {
        var input = $(this);
        var is_name = input.val();
        var error_text = $(this).attr('title');
        if (is_name) {
            input.removeClass("invalid").addClass("valid");
            input.parent('.group').find('.input-error-req').addClass('d-none').text('');
        }
        else {
            input.removeClass("valid").addClass("invalid");
            input.parent('.group').find('.input-error-req').removeClass('d-none').text(`${error_text} required.`);
        }
    });

    $('input[type=email]').on('input', function () {
        var input = $(this);
        var error_text = $(this).attr('title');
        var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var is_email = re.test(input.val());
        if (input.val().length == 0) {
            input.removeClass("valid").addClass("invalid");
            input.parent('.group').find('.input-error-req').removeClass('d-none').text(`${error_text} required.`);
        }
        else if (is_email) {
            input.removeClass("invalid").addClass("valid");
            input.parent('.group').find('.input-error-req').addClass('d-none').text('');
        }
        else {
            input.removeClass("valid").addClass("invalid");
            input.parent('.group').find('.input-error-req').removeClass('d-none').text(`${error_text} invalid.`);
        }
    });

    $('input[type=tel]').on('input', function (event) {
        var input = $(this);
        var error_text = $(this).attr('title');
        var re = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/;
        var is_phone = re.test(input.val());
        if (input.val().length == 0) {
            input.removeClass("valid").addClass("invalid");
            input.parent('.group').find('.input-error-req').removeClass('d-none').text(`${error_text} required.`);
        }
        else if (is_phone) {
            input.removeClass("invalid").addClass("valid");
            input.parent('.group').find('.input-error-req').addClass('d-none').text('');
        }
        else {
            input.removeClass("valid").addClass("invalid");
            input.parent('.group').find('.input-error-req').removeClass('d-none').text(`${error_text} invalid.`);
        }

        console.log("input.attr('id'):", input.attr('id'))
        const inputElement = document.getElementById(input.attr('id'));

        // console.log("inputElement:",inputElement,input)
        inputElement.addEventListener('keyup', formatToPhone);

    });




}

function send_form() {
    var leadForm = document.getElementsByClassName("lead-form")[0];
    var responseMessage = document.getElementById("response-message");
    var loader = document.getElementById("loader");


    loader.style.display = "block";

    var formData = new FormData(leadForm);

    // Gather selected checkbox values
    var selectedCheckboxes = Array.from(leadForm.querySelectorAll('input[type="checkbox"]:checked')).map(function (checkbox) {
        return checkbox.value;
    });

    if (leadForm.querySelectorAll('input[type="checkbox"]:checked').length > 0) {
        var nameCheckbox = leadForm.querySelectorAll('input[type="checkbox"]:checked')[0].name
        nameCheckbox = nameCheckbox.substring(0, nameCheckbox.length - 2)

        // Set the gathered values as the value for options[contact_via]
        formData.set("options[" + nameCheckbox + "]", selectedCheckboxes.join(','));
    }


    var post_slug = document.getElementById('post_slug').value;

    //  $.ajax({
    //     type: "post",
    //     url: "/"+post_slug+"?_ajax=true&ACT=api",
    //     success: function (response) {
    //         console.log("response:",response)
    //         if(response.status === "success") {
    //             // togglePopup()
    //             alert("ok");
    //             // do something with response.message or whatever other data on success
    //         } else if(response.status === "error") {
    //             // do something with response.message or whatever other data on error
    //             alert("ko");
    //         }
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) { 
    //         errorFunction(); 
    //     }
    // })

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/" + post_slug + "?_ajax=true&ACT=api");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            loader.style.display = "none";
            console.log("response:", xhr.status)
            if (xhr.status === 200) {
                // responseMessage.textContent = "Lead has been submitted successfully.";
                togglePopup()
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

}


function togglePopup() {
    $("#popupOverlay").toggle();
}