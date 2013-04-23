//used in groupReports.php//


//load viewReport on click

$(".report").click(function() {
    var reportId = $(this).attr('id');
    var report = reportId.replace("report_", "");
    $("#reportPane").css("opacity", "0");
    $("#reportPane").load("ajax/viewReport.php", {"report": report}, function(response, status, xhr) {
        if (status == "error") {
            var msg = "Error: ";
            $("#reportPane").html(msg + xhr.status + " " + xhr.statusText);
        }
        else {
            $("#reportPane").fadeTo("normal",1);
        }
    });
    $('#newIncident').show();
});

var incident;


//load viewIncident on click

$(".incident").click(function() {
    var incidentId = $(this).attr("id");
    incident = incidentId.replace("incident_", "");
    $("#reportPane").css("opacity", "0");
    $("#reportPane").load("ajax/viewIncident.php", {"incident": incident}, function(response, status, xhr) {
        if (status == "error") {
            var msg = "Error: ";
            $("#reportPane").html(msg + xhr.status + " " + xhr.statusText);
        }
        else {
            $("#reportPane").fadeTo("normal",1);
        }
    });
    $('#newMessage').show();
});


//load newMessage on click

$("#newMessage").click(function(event) {
    $("#reportPane").css("opacity", "0");
    $("#reportPane").load("ajax/newMessage.php", {"incident": incident}, function(response, status, xhr) {
        if (status == "error") {
            var msg = "Error: ";
            $("#reportPane").html(msg + xhr.status + " " + xhr.statusText);
        }
        else {
            $("#reportPane").fadeTo("normal",1);
        }
    });
    event.preventDefault();
});


//load newIncident on click

$("#newIncident").click(function(event) {
    $("#reportPane").css("opacity", "0");
    $("#reportPane").load("ajax/newIncident.php", {"incident": incident}, function(response, status, xhr) {
        if (status == "error") {
            var msg = "Error: ";
            $("#reportPane").html(msg + xhr.status + " " + xhr.statusText);
        }
        else {
            $("#reportPane").fadeTo("normal",1);
        }
    });
    event.preventDefault();
});

//hides new incident button on tab change
$("#incidentTab").click(function() {
    $('#newIncident').hide();
});

var selectedReports = new Array();


//Filter incidents by flag on click

$(".filter").click(function() {
    var critical = $(".filter").getElementById("critical");
    var warning = $(".filter").getElementById("warning");
    var responding = $(".filter").getElementById("responding");
    var resolved = $(".filter").getElementById("internal");
    var ignored = $(".filter").getElementById("internal");


});


//used in newMessage.php//

//removes placeholder text on textarea focus
var placeholder = $("#message").val();
$("#fieldMessage").focus(
    function() {
        if($(this).val() == placeholder) {
            $(this).val("");
        }
    }
);

//inserts placeholder text if textarea is empty
$("#fieldMessage").blur(
    function() {
        if($(this).val() == "") {
            $(this).val(placeholder);
        }
    }
);

//ajax post of new message form
$("#messageForm").submit(function(event) {
    event.preventDefault();
    var author = $("#fieldAuthor").val();
    var flag = $("#fieldFlag").val();
    var message =$("#fieldMessage").val();
    var dataString = "author=" + author + "&flag=" + flag + "&message=" + message;
    $.ajax({
        type: "POST",
        url: "newMessage.php",
        data: dataString,
        success: function(){
            $("#reportPane").css("opacity", "0");
            $("#reportPane").html("Message posted.");
            $("#reportPane").fadeTo("normal",1);
        }
    });
});


//used in newIncident.php

//activates click-to-select functionality for reports
$(function() {
     $(".selectable").bind("mousedown", function(event) {
         event.metaKey = true;
     }).selectable({
         tolerance: 'fit',
         stop: function() {
             var result = $( "#select-result" ).empty();
             selectedReports.length = 0;
             var i = 0;
             $(".ui-selected", $("#accordion2")).each(function() {
                 var itemId = $(this).attr('id');
                 var item = itemId.replace("report_", "");
                 result.append( " #" + ( item + 1 ) );
                 selectedReports[i] = item;
                 i++;
             });
         }
     });
});