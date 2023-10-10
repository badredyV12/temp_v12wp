

let seleted_time_am = []
let seleted_time_pm = []
let full_date=""
let full_time=""
// let due_time = 20-9-2023 08:00:00

var arr_month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"]

$(document).ready(function(){
    let current_day = new Date()
  

    getAailability(formatDate(current_day))

    $(".test-drive-form").find(".next-days").on('click', function () {
        $(".test-drive-form").find(".prev-days").removeClass('btn-disabled')
        current_day = getNextWeek(current_day)
        getAailability(formatDate(current_day))
    })

    $(".test-drive-form").find(".prev-days").on('click', function () {
        current_day = getPrevWeek(current_day)
        if(formatDate(current_day) == formatDate(new Date()))
        {
            $(".test-drive-form").find(".prev-days").addClass('btn-disabled')
        }
        getAailability(formatDate(current_day))
    });


    

    $(".test-drive-form").find(".label-days").on('click', function () {
        if(!$(this).hasClass("disabled")){
            $(".label-days").removeClass('activated')
            $(this).addClass('activated')
            var this_day = $(this).text();
            let disabled = ""
    
            let html='<option disabled="disabled">Morning</option>'
            $.each(seleted_time_am[this_day], function(key, value) {
                disabled = !value['available'] ? 'disabled' : ''
                html = html + '<option value="'+value['time']+':00" class="zone-time-label" '+disabled+' >'+value['time']+' am</option>';
    
            })
            html = html + '<option disabled="disabled">Afternoon</option>'
             $.each(seleted_time_pm[this_day], function(key, value) {
                disabled = !value['available'] ? 'disabled' : ''
                html = html + '<option value="'+value['time']+':00" class="zone-time-label" '+disabled+' >'+value['time']+' pm</option>';
    
             })
    
            $(".selected-time").append(html)
            $(".group-selected-time").addClass('active')
    
            $('#due_time').val($(this).parent('.day-wrap-css').find('.full-date').text())
        }
       
    });

    $(".selected-time").on('change', function() {
        $('.btn-next-step').attr('disabled', false)  
        full_time = $(".selected-time").val()
        $('#due_time').val(full_date +" "+full_time)
    })
    

    $(".test-drive-form").find(".btn-next-step").on('click', function () {
        $(".test-drive-form").find(".step-1").removeClass("active");
        $(".test-drive-form").find(".step-2").addClass("active");  
    });

    $(".test-drive-form").find(".form-btn-prev").on('click', function () {
        $(".test-drive-form").find(".step-2").removeClass("active");
        $(".test-drive-form").find(".step-1").addClass("active");  
    });

}) // end document ready

function formatDate(date = new Date()) {
  const year = date.toLocaleString('default', {year: 'numeric'});
  const month = date.toLocaleString('default', {
    month: '2-digit',
  });
  const day = date.toLocaleString('default', {day: '2-digit'});

  return [year, month, day].join('-');
}

function getNextWeek(date) {
  const nextWeek = new Date(date);
  // nextWeek.setDate(nextWeek.getDate() + (7 - nextWeek.getDay() + 1)); 
  nextWeek.setDate(nextWeek.getDate() + 7); // +1 to get the first day of next week


  return nextWeek;
}

function getPrevWeek(date) {
  const prevWeek = new Date(date);
  prevWeek.setDate(prevWeek.getDate() - 7); // +1 to get the first day of next week

  return prevWeek;
}

function getAailability(current_day)
{

    $(".loading_form").removeClass('d-none');
    var post_slug =$("#post_slug").val();
    // $.ajax({
    //     url: "/"+post_slug+"?_ajax=true&ACT=Availability&user_id=100043&current_day=2023-09-14&lead_id=",
    //     success: function(response){
    //         var res = response.split("#response:#")
    //         console.log("****:",JSON.parse(res[1]))

    //         // $.each(res[1].result.weekDays, function( index, value ) {
    //         //     console.log("each:",index,value)
    //         // });
    //         // console.log("result:",result)
    //         // $.each(result[0], function( index, value ) {
    //         //   alert( index + ": " + value );
    //         // });
    //     }                
    // });


    let user_id = $("#user_id").val()
    $.ajax({
        url: "/"+post_slug+"?_ajax=true&ACT=Availability",
        data: {"user_id":user_id,"current_day":current_day},
        type: 'GET',
        success: function(response){
            response = response.split("#_ajax_v12#")
            response = JSON.parse(response[1])

            let nbrMonth_1=0
            let nbrMonth_2=0
            let nameMonth_1=""
            let nameMonth_2=""
            let nbrYear_1=0
            let nbrYear_2=0
            let nameYear_1=""
            let nameYear_2=""

            seleted_time_am = []
            seleted_time_pm = []

            let day=0

            

            $.each(response.result.weekDays, function( index, value ) {
                full_date = value['Day'] +"-"+ (arr_month.indexOf(value["Month"])+1) +"-"+value['Year'];
                $('.'+index).parent('.day-wrap-css').find('.full-date').text(full_date)
                $.each(value, function(key, val ) {
                    if(key === "Day")
                    {
                        $('.'+index).text(val)
                        day = val
                    }
                    else if(key === "available") 
                    {
                        if(val == true)
                            $('.'+index).addClass("available").removeClass("disabled")
                        else
                            $('.'+index).removeClass("available").addClass("disabled")

                    }
                    else if(key === "Month") 
                    {
                        if(nameMonth_1 === "")
                        {
                            nbrMonth_1 = nbrMonth_1 + 1
                            nameMonth_1 = val
                        }
                        else if(nameMonth_1 === val)
                        {
                            nbrMonth_1 = nbrMonth_1 + 1
                            nameMonth_1 = val
                        }

                        if(nameMonth_2 === "" && nameMonth_1 !== val)
                        {
                            nbrMonth_2 = nbrMonth_2 + 1
                            nameMonth_2 = val
                        }
                        else if(nameMonth_2 === val)
                        {
                            nbrMonth_2 = nbrMonth_2 + 1
                            nameMonth_2 = val
                        }

                    }
                    else if(key === "Year") 
                    {
                        if(nameYear_1 === "")
                        {
                            nbrYear_1 ++
                            nameYear_1 = val
                        }
                        else if(nameYear_1 === val)
                        {
                            nbrYear_1 ++
                        }

                        if(nameYear_2 === "" && nameYear_1 !== val)
                        {
                            nbrYear_2 ++
                            nameYear_2 = val
                        }
                        else if(nameYear_2 === val)
                        {
                            nbrYear_2 ++
                        }

                    }
                    else if(key === "am")
                    {
                        seleted_time_am[day] = val
                    }
                    else if(key === "pm")
                    {
                        seleted_time_pm[day] = val
                    }
                })
         
            });

            let month = nbrMonth_1 > nbrMonth_2 ? nameMonth_1 : nameMonth_2;
            let year = nbrYear_1 > nbrYear_2 ? nameYear_1 : nameYear_2;
            $(".select-time-month").find('.current-month').text(month +" "+year)
            setTimeout(() => {
                $(".loading_form").addClass('d-none');
            }, 800);
              

        }                
    });

}


document.addEventListener("DOMContentLoaded", function() {
    const inputElements = [{
            select: document.getElementById("selected-time"),
            label: document.querySelector("label[for=selected-time]")
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