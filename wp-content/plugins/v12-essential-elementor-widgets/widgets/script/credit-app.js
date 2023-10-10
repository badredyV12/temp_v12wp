$(function(){
    $('.select-search-car').select2({
        width: 'resolve'
    });

    $('.select-search-car').on("change", function(){
        if($('.select-search-car').val() != "")
        {
            $('.select-search-car').addClass("valid")
        }
        else
        {
            $('.select-search-car').removeClass("valid")
        }
    })
})

function Dob(m,d,y) {
	if(typeof y !== 'undefined' && typeof m !== 'undefined' && typeof d !== 'undefined') {
    var newdate = m+'/'+d+'/'+y;
   jQuery("#Applicant0Dob").val(newdate);
  }
}

var y , m , d;
$('select#year').on('change', function() {
    y = this.value;
    Dob(m,d,y);
    $(this).addClass("valid")
});

$('select#month').on('change', function() {
    m = this.value;
    Dob(m,d,y);
    $(this).addClass("valid")
});

$('select#day').on('change', function() {
    d = this.value;
    Dob(m,d,y);
    $(this).addClass("valid")
});

$('select#state').on('change', function() {
    $(this).addClass("valid")
})

 document.addEventListener("DOMContentLoaded", function() {
    const inputElements = [{
            select: document.getElementById("month"),
            label: document.querySelector("label[for=month]")
        },
        {
            select: document.getElementById("day"),
            label: document.querySelector("label[for=day]")
        },
        {
            select: document.getElementById("year"),
            label: document.querySelector("label[for=year]")
        },
        {
            select: document.getElementById("state"),
            label: document.querySelector("label[for=state]")
        },
        {
            select: document.getElementById("residence_type"),
            label: document.querySelector("label[for=residence_type]")
        },
        {
            select: document.getElementById("residence_years"),
            label: document.querySelector("label[for=residence_years]")
        },
        {
            select: document.getElementById("residence_months"),
            label: document.querySelector("label[for=residence_months]")
        },
        {
            select: document.getElementById("ApplicantEmploymentStatus"),
            label: document.querySelector("label[for=ApplicantEmploymentStatus]")
        },
        {
            select: document.getElementById("Applicant0IncomeInterval"),
            label: document.querySelector("label[for=Applicant0IncomeInterval]")
        },
        {
            select: document.getElementById("friend_state"),
            label: document.querySelector("label[for=friend_state]")
        },
        {
            select: document.getElementById("Applicantyears"),
            label: document.querySelector("label[for=Applicantyears]")
        },
        {
            select: document.getElementById("Applicantmonths"),
            label: document.querySelector("label[for=Applicantmonths]")
        },
        {
            select: document.getElementById("Applicantmonths"),
            label: document.querySelector("label[for=Applicantmonths]")
        },
        {
            select: document.getElementById("home_phone"),
            label: document.querySelector("label[for=home_phone]")
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