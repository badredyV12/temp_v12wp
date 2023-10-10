$(function () {

    $(".edit-simulation-vdp").on("click",function(){
        togglePopupVdpF()
    })

    $(".close-btn-popup-vdp").on("click",function(){
        togglePopupVdpF()
    })

    $("#loan_calculat").click(function(event) {
         event.preventDefault();
        Calculator_Loan($(this));
        var months_val = $(this).closest("form").find("#Months").val();
        $(this).closest("form").find(".month_result").removeClass("hide").html(months_val);

        if(!$(this).hasClass("trigger"))
        {
            togglePopupVdpF()
        }


    });

    $(".calc-trade-in-value").on('keyup', function(event){
        let vehiclePrice = parseFloat($(".calc-vehicle-price").val());
        let downPayment = parseFloat($(".calc-down-payment").val());
        let tradeInValue = parseFloat($(this).val());

        if(isNaN(vehiclePrice))
            vehiclePrice = 0;
        if(isNaN(downPayment))
            downPayment = 0;
        if(isNaN(tradeInValue))
            tradeInValue = 0;

        let netAmount = vehiclePrice - downPayment - tradeInValue;
        $(".net-amount").val(netAmount)
    });

    $(".calc-down-payment").on('keyup', function(event) {
        let vehiclePrice = parseFloat($(".calc-vehicle-price").val());
        let tradeInValue = parseFloat($(".calc-trade-in-value").val());
        let downPayment = parseFloat($(this).val());

        if(isNaN(vehiclePrice))
            vehiclePrice = 0;
        if(isNaN(downPayment))
            downPayment = 0;
        if(isNaN(tradeInValue))
            tradeInValue = 0;

        let netAmount = vehiclePrice - downPayment - tradeInValue;
        $(".net-amount").val(netAmount)
    });

    function Calculator_Loan(field) {
        // var calcDiv = field.closest("div.calculator-loan");
        var vehiclePrice = parseFloat($(".calc-vehicle-price").val());
        var downPayment = parseFloat($(".calc-down-payment").val());
        var tradeInValue = parseFloat($(".calc-trade-in-value").val());
        var salesTax = parseFloat($(".calc-sales-tax").val());
        var interestRate = parseFloat($(".calc-interest-rate").val());
        var loanTerm = parseInt($(".calc-loan-term").val());
		var other_fees = parseFloat($(".other_fees").val());
		var loanAmount = 0;

        var monthlyPayment = 0;
        if (isNaN(interestRate)) 
			interestRate = 0;
        if (vehiclePrice > 0) {
            loanAmount += vehiclePrice;
            if (salesTax > 0) 
				loanAmount += loanAmount * (salesTax / 100);
            if (downPayment > 0) 
				loanAmount -= downPayment;
            if (tradeInValue > 0) 
				loanAmount -= tradeInValue;
			if (other_fees>0)	
				loanAmount = loanAmount + other_fees;
        }
        if (loanAmount > 0 && loanTerm > 0 && interestRate >= 0) {
            if (interestRate == 0) {
                monthlyPayment = (loanAmount / loanTerm);
            } else {
                monthlyPayment = (loanAmount * (interestRate / 1200) * Math.pow((1 + (interestRate / 1200)), loanTerm)) / (Math.pow((1 + (interestRate / 1200)), loanTerm) - 1);
            };
            $(".calc-loan-amount").text(formatNumberWithCommas(FormatNumber(loanAmount, 0, true)));
            $(".calc-monthly-payment").text(formatNumberWithCommas(FormatNumber(monthlyPayment, 0, true)));
        } else {
            $(".calc-loan-amount").text("0");
            $(".calc-monthly-payment").text("0");
        }
    }

    function togglePopupVdpF() {
        var popup = document.getElementById("popupOverlayVdpF");
        popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
    }

    function FormatNumber(num, dec, zero) {
        if (isNaN(parseFloat(num))) {
            return '0.00';
        }
        if (!zero && num === 0) {
            return '0.00';
        }
        var neg = num < 0;
        var tmpNum = parseFloat(num);
        tmpNum *= Math.pow(10, dec);
        tmpNum = Math.round(Math.abs(tmpNum));
        tmpNum /= Math.pow(10, dec);
        
        if (neg) {
            tmpNum *= -1;
        }

        var tmpNumStr = tmpNum.toString();
        if (dec > 0) {
            var pos = tmpNumStr.lastIndexOf(".");
            if (pos === -1) {
                tmpNumStr += "." + StrRepeat("0", dec);
            } else {
                pos = tmpNumStr.length - pos;
                if (pos < dec + 1) {
                    tmpNumStr += StrRepeat("0", dec + 1 - pos);
                }
            }
        }
        return tmpNumStr;
    }

    function StrRepeat(str, count) {
        return new Array(count + 1).join(str);
    }

    function formatNumberWithCommas(nb) {
        return nb.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };
});

$("document").ready(function() {
    setTimeout(function() {
        $( "#loan_calculat" ).trigger( "click" );
        $("#loan_calculat").removeClass("trigger")
    },100);
});

$("#popupOverlayVdpF").on("click", function(event) {
    $("#popupOverlayVdpF").css('display','none');
}
);