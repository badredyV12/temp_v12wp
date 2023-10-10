function updateStep(direction) {
    const $form = $("#sell-form");
    const $step1 = $form.find(".step-1");
    const $step2 = $form.find(".step-2");

    if (direction === "next") {
        $step1.removeClass("active");
        $step2.addClass("active");
    } else if (direction === "prev") {
        $step1.addClass("active");
        $step2.removeClass("active");
    }
}

$("#sell-form").find(".next").on('click', function() {
    updateStep("next");
});

$("#sell-form").find(".prev").on('click', function() {
    updateStep("prev");
});

$(document).ready(function() {
    const $sellMakeInput = $("#sell_make");
    const $sellMileageGroup = $("#sell_mileage_group");
    const $nextButton = $(".next");
    const $sellMileageInput = $("#sell_mileage");

    // Initial state based on the input value
    toggleSellMileageGroupVisibility();

    // Add an input event listener to the sell_make input
    $sellMakeInput.on("input", toggleSellMileageGroupVisibility);
    $sellMileageInput.on("input", toggleSellMileageGroupVisibility);


    function toggleSellMileageGroupVisibility() {
        const sellMakeValue = $sellMakeInput.val().trim();
        const sellMileageValue = $sellMileageInput.val().trim();

        if (sellMakeValue !== "" && sellMileageValue !== "") {
            $nextButton.prop("disabled", false); // Enable the "Next" button
        } else {
            $nextButton.prop("disabled", true); // Disable the "Next" button
        }

        if (sellMakeValue !== "") {
            $sellMileageGroup.removeClass("d-none");   
        } else {
            $sellMileageGroup.addClass("d-none");     
        }
    }
});