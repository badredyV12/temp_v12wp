$(function () {
    $('.price-footer .form-btns .finance-calc-btn').click(function () {
        var price = parseFloat($("#price").val());
        var dp = parseFloat($("#dp").val());
        var ir = parseFloat($("#ir").val());
        var term = parseFloat($("#term").val());

        if (price !== 0 || dp !== 0 || ir !== 0 || term !== 0) {
            $(this).addClass('recalculate').text('recalculate');
            $(this).parent().find('.get-pre-approved').removeClass('d-none');
        }
    });

    $("#calc_button").click(function (event) {
        event.preventDefault();
        var price = parseFloat($("#price").val());
        var dp = parseFloat($("#dp").val());
        var ir = parseFloat($("#ir").val());
        var term = parseFloat($("#term").val());

        if (price !== 0 || dp !== 0 || ir !== 0 || term !== 0) {
            Calculator_simple($(this));
        }
    });

    function Calculator_simple(field) {
        console.log("you are here : ");
        var calcTable = field.closest("div.calculator-simplified");
        var price = parseFloat(calcTable.find("#price").val());
        var dp = parseFloat(calcTable.find("#dp").val());
        var ir = parseFloat(calcTable.find("#ir").val());
        var months = parseFloat(calcTable.find("#term").val());
        var other_fees = parseFloat(calcTable.find(".other_fees").val());
        var princ = price - dp;
        var intRate = (ir / 100) / 12;
        var pmt = Math.floor((princ * intRate) / (1 - Math.pow(1 + intRate, (-1 * months))) * 100) / 100;
        
        if (other_fees > 0) {
            pmt += other_fees;
        }

        calcTable.find("#pmt").text(FormatNumber(pmt, 0, true));
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
});