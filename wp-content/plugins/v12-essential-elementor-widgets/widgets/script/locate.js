$("#locate-form").find(".next").on('click', function() {
    $("#locate-form").find(".step-1").removeClass("active");
    $("#locate-form").find(".step-2").addClass("active");
});

$("#locate-form").find(".prev").on('click', function() {
    $("#locate-form").find(".step-1").addClass("active");
    $("#locate-form").find(".step-2").removeClass("active");
});

$("#locate-form").find('#locate-make').keyup(function() {
    let val = $(this).val()
    let val1 = $("#locate-form").find('#vehicle_mileage').val()
    if (val.length && (val1 != "" && val1 != null)) {
        $('.next').attr('disabled', false)
    } else {
        $('.next').attr('disabled', true)
    }
});

$("#locate-form").find('#vehicle_mileage').change(function() {
    let val = $(this).val()
    let val1 = $("#locate-form").find('#locate-make').val()
    if (val1.length && val != "") {
        $('.next').attr('disabled', false)
    } else {
        $('.next').attr('disabled', true)
    }
});


document.addEventListener("DOMContentLoaded", function() {
    const inputElements = [{
            select: document.getElementById("vehicle_mileage"),
            label: document.querySelector("label[for=vehicle_mileage]")
        },
        {
            select: document.getElementById("vehicle_engine"),
            label: document.querySelector("label[for=vehicle_engine]")
        },
        {
            select: document.getElementById("vehicle_doors"),
            label: document.querySelector("label[for=vehicle_doors]")
        },
        {
            select: document.getElementById("vehicle_price"),
            label: document.querySelector("label[for=vehicle_price]")
        },
        {
            select: document.getElementById("vehicle_transmission"),
            label: document.querySelector("label[for=vehicle_transmission]")
        },
        {
            select: document.getElementById("vehicle_body"),
            label: document.querySelector("label[for=vehicle_body]")
        },
        {
            select: document.getElementById("time_frame"),
            label: document.querySelector("label[for=time_frame]")
        },
        {
            select: document.getElementById("trade_in_yearYear"),
            label: document.querySelector("label[for=trade_in_yearYear]")
        },
        {
            select: document.getElementById("trade_in_make"),
            label: document.querySelector("label[for=trade_in_make]")
        }
    ];

    inputElements.forEach(({
        select,
        label
    }) => {
        select.addEventListener("change", () => {
            if (select.value !== "") {
                label.style.top = "0px";
                label.style.transform = "translateY(-50%) scale(0.9)";
                select.style.border = "1px solid #000";
            }
        });
    });
});




const financingYesRadio = document.getElementById("financing_yes");
const financingNoRadio = document.getElementById("financing_no");
const financingSelect = document.getElementById("financing_select");

function toggleFinancingSelectVisibility() {
    if (financingYesRadio.checked) {
        financingSelect.style.display = "block";
    } else {
        financingSelect.style.display = "none";
    }
}

toggleFinancingSelectVisibility();

financingYesRadio.addEventListener("change", toggleFinancingSelectVisibility);
financingNoRadio.addEventListener("change", toggleFinancingSelectVisibility);


const vehicle_tradin_yes_Radio = document.getElementById("vehicle_tradin_yes");
const vehicle_tradin_no_Radio = document.getElementById("vehicle_tradin_no");
const vehicle_tradin_select = document.getElementById("vehicle_tradin_select");

function toggleTradinSelectVisibility() {
    if (vehicle_tradin_yes_Radio.checked) {
        vehicle_tradin_select.style.display = "grid";
    } else {
        vehicle_tradin_select.style.display = "none";
    }
}

toggleTradinSelectVisibility();

vehicle_tradin_yes_Radio.addEventListener("change", toggleTradinSelectVisibility);
vehicle_tradin_no_Radio.addEventListener("change", toggleTradinSelectVisibility);