$(document).ready(function() {

    //used on index.php//

    $(function() {
        $(".downtime").tooltip({
            'placement': 'left'
        });
    });

    $(function(){
        function checkScrollPosition() {
            var top = $(window).scrollTop();
            if (top > 1) {
                $("#dimmer").fadeTo("normal",1);
            }
    }
    $(window).scroll(checkScrollPosition);
    checkScrollPosition();
    });


    //used in manage.php//

    //filter active incidents
    
    if ($("#showAll").hasClass("active")) {
            $("#incidentPane").load("ajax/listIncident", {"showHidden": false}, function(response, status, xhr) {
                if (status == "error") {
                    var msg = "Error: ";
                    $("#incidentPane").html(msg + xhr.status + " " + xhr.statusText);
                }
                else {
                    $("#incidentPane").fadeTo("normal",1);
                }
            });
        } else {
            $("#incidentPane").load("ajax/listIncident", {"showHidden": true}, function(response, status, xhr) {
                if (status == "error") {
                    var msg = "Error: ";
                    $("#incidentPane").html(msg + xhr.status + " " + xhr.statusText);
                }
                else {
                    $("#incidentPane").fadeTo("normal",1);
                }
            });
        }
    });
    
    //redirects to newIncident on button click

    $("#newincButton").click(function(event) {
       window.location.href = "newIncident.php"
    });

    //hides new incident button on tab change
    $("#incidentTab").click(function() {
        $('#newIncident').hide();
    });

    //hides new incident button on tab change
    $("#reportTab").click(function() {
        $('#newMessage').hide();
    });

    //used in editIncident.php//

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
            url: "editIncident.php",
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
        var selectedReports = new Array();
        $('#reportSelect').click(function() {
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
            $("#selectedReports").html(selectedReports);
        })
    });
});