$("#trade-form").find(".next").on('click', function() {
    $("#trade-form").find(".step-1").removeClass("active");
    $("#trade-form").find(".step-2").addClass("active");
});

$("#trade-form").find(".prev").on('click', function() {
    $("#trade-form").find(".step-1").addClass("active");
    $("#trade-form").find(".step-2").removeClass("active");
});

$('#trade-make').keyup(function() {
    let val = $(this).val()
    if (val.length) {
        $('#trade-mileage').parent().removeClass('d-none')
    } else {
        $('#trade-mileage').parent().addClass('d-none')
    }
})

$('#trade-mileage').keyup(function() {
    let val = $(this).val()
    if (val.length) {
        $('.next').attr('disabled', false)
    } else {
        $('.next').attr('disabled', true)
    }
})