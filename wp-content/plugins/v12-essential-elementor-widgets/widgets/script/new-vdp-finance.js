      

let arrayAPR = {
    "48": {"≤640": 18.85,"641-699": 14.82,"700-749": 11.47,"750-850": 8.85},
    "60": {"≤640": 19.81,"641-699": 15.02,"700-749": 11.67,"750-850": 9.07},
    "72": {"≤640": 18.78,"641-699": 14.41,"700-749": 11.38,"750-850": 9.15},
    "84": {"≤640": 20.34,"641-699": 15.28,"700-749": 11.61,"750-850": 9.24}
} 

$(".card-estimates-credit").on("click",function(event){
    $(".card-estimates-credit").removeClass("selected")
    $(this).addClass("selected")

    var card_estimates_credit = $(this).text()
    var card_term_month = $(".card-list-term-month").find(".selected").text()
    $(".calc-interest-rate").val(arrayAPR[card_term_month][card_estimates_credit])
    $(".price-estimate-bottom").find(".ir").text(arrayAPR[card_term_month][card_estimates_credit])

    Calculator_Loan($(this))

})

$(".card-term-month").on("click",function(event){
    $(".card-term-month").removeClass("selected")
    $(this).addClass("selected")
    $(".price-estimate-bottom").find(".month").text($(this).text())
    $(".calc-loan-term").val($(this).text())

    var card_term_month = $(this).text()
    var card_estimates_credit = $(".card-list-estimates-credit").find(".selected").text()
    $(".calc-interest-rate").val(arrayAPR[card_term_month][card_estimates_credit])
    $(".price-estimate-bottom").find(".ir").text(arrayAPR[card_term_month][card_estimates_credit])

    Calculator_Loan($(this))

})


$(".estimates-monthly-payment-range").on("change",function(event){
    $(".estimates-monthly-payment-value").val($(this).val())
    // Calculator_Loan($(this))
    $(".estimates-monthly-payment-range").val($(this).val())
    $(".calc-monthly-payment").text($(this).val())
    Calculator_Loan_Reverse($(this))

})
$(".estimates-monthly-payment-value").on("keyup",function(event){
    var value = 0;
    if($(this).val()!="")
    {
        value = $(this).val()
    }
    
    if(value > parseInt($(".estimates-monthly-payment-range").attr("max")))
    {
        value = parseInt($(".estimates-monthly-payment-range").attr("max"))
        
    }
    $(".estimates-monthly-payment-range").val(value)
    $(this).val(value)

    // $(".estimates-monthly-payment-value")
    $(".calc-monthly-payment").text(value)
    Calculator_Loan_Reverse($(this))

})




$(".down-payment-range").on("change",function(event){
    $(".down-payment-value").val($(this).val())
    $(".price-estimate-bottom").find(".down").text($(this).val())
    Calculator_Loan($(this))
   
    var monthly_payment = $(".calc-monthly-payment").text()
    $(".estimates-monthly-payment-value").val(monthly_payment)
    $(".estimates-monthly-payment-range").val(monthly_payment)

})
$(".down-payment-value").on("keyup",function(event){
    var value=0;
    if($(this).val()!="")
        value = $(this).val()

    if(value > parseInt($(".down-payment-range").attr("max")))
    {
        value = parseInt($(".down-payment-range").attr("max"))
       
    }
    $(this).val(value)
    $(".down-payment-range").val(value)
    $(".estimates-monthly-payment-value").val(value)
    $(".estimates-monthly-payment-range").val(value)
    $(".price-estimate-bottom").find(".down").text(value)
    Calculator_Loan($(this))


})

$(".trade-in-range").on("change",function(event){
    $(".trade-in-value").val($(this).val())
    Calculator_Loan($(this))
})

$(".trade-in-value").on("keyup",function(event){
    var value=0;
    if($(this).val()!="")
        value = $(this).val()

    if(value > $(".trade-in-range").attr("max"))
    {
        value = parseInt($(".trade-in-range").attr("max"))
        $(this).val(value)
    }
    $(".trade-in-range").val(value)
    Calculator_Loan($(this))

})

$(".price-value").on("keyup",function(event){
    $(".calc-vehicle-price").val($(this).val())
    Calculator_Loan($(this))
})

$("#loan_calculat").click(function(event) {
    event.preventDefault();

    var card_estimates_credit = $(".card-list-estimates-credit").find(".selected").text()
    var card_term_month = $(".card-list-term-month").find(".selected").text()
    $(".calc-interest-rate").val(arrayAPR[card_term_month][card_estimates_credit])
    $(".price-estimate-bottom").find(".ir").text(arrayAPR[card_term_month][card_estimates_credit])

    Calculator_Loan($(this));
});


function Calculator_Loan(field) {
    // var calcDiv = field.closest("div.calculator-loan");
    var vehiclePrice = parseFloat($(".calc-vehicle-price").val());
    var downPayment = parseFloat($(".down-payment-value").val());
    var tradeInValue = parseFloat($(".trade-in-value").val());
    var salesTax = parseFloat($(".calc-sales-tax").val());
    var interestRate = parseFloat($(".calc-interest-rate").val());
    var loanTerm = parseInt($(".calc-loan-term").val());

    
    var other_fees = parseFloat($(".other_fees").val());
    var loanAmount = 0;

    $(".down-payment-range").attr("max",vehiclePrice-tradeInValue)
    $(".trade-in-range").attr("max",vehiclePrice-downPayment)

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
        $(".calc-monthly-payment").text(formatNumberWithCommas(FormatNumber(monthlyPayment, 0, true)));
        $(".estimates-monthly-payment-value").val($(".calc-monthly-payment").text())
        $(".estimates-monthly-payment-range").val($(".calc-monthly-payment").text())

        var downFormat = $(".down-payment-value").val()
        $(".price-estimate-bottom").find(".down").text(formatNumberWithCommas(downFormat))


        loanAmount += downPayment;
        if (interestRate == 0) {
            monthlyPayment = (loanAmount / loanTerm);
        } else {
            monthlyPayment = (loanAmount * (interestRate / 1200) * Math.pow((1 + (interestRate / 1200)), loanTerm)) / (Math.pow((1 + (interestRate / 1200)), loanTerm) - 1);
        };

        $(".estimates-monthly-payment-range").attr('max', monthlyPayment)  


    } else {
        $(".calc-loan-amount").text("0");
        $(".calc-monthly-payment").text("0");
    }
}

function Calculator_Loan_Reverse(field) {

    var loanTerm = parseInt($(".calc-loan-term").val());
    var interestRate = parseFloat($(".calc-interest-rate").val());
    var monthlyPayment = parseFloat($(".estimates-monthly-payment-value").val())
    var tradeInValue = 0
    var vehiclePrice = parseFloat($(".calc-vehicle-price").val());

    // var total = monthlyPayment*loanTerm
    // var loanAmount = 0;

    if (isNaN(interestRate)) 
    interestRate = 0;


    var downPayment = (((monthlyPayment * (Math.pow((1 + (interestRate / 1200)), loanTerm) - 1)) / Math.pow((1 + (interestRate / 1200)), loanTerm)) / (interestRate / 1200)) - vehiclePrice + tradeInValue
    downPayment = Math.ceil(downPayment*(-1))
    if(downPayment < 0)
        downPayment = 0
    else if(downPayment > vehiclePrice)
        downPayment = vehiclePrice - tradeInValue

    $(".down-payment-value").val(downPayment)
    $(".down-payment-range").val(downPayment)

    $(".price-estimate-bottom").find(".down").text(formatNumberWithCommas(downPayment))
 
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


$("document").ready(function() {
    setTimeout(function() {
        $( "#loan_calculat" ).trigger( "click" );
        $("#loan_calculat").removeClass("trigger")
    },100);
});






    