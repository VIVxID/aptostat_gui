<!DOCTYPE html>
<html>
    <?php
		include 'inc/html_head.php';
        include 'inc/apiurl.php';
        include 'inc/reports.php';
        include 'inc/incidents.php';

        $reports = new Reports();
        $reportList = $reports->getReportsAsArray();

        $incidents = new Incidents();
        $incidentList = $incidents->getIncidentsAsArray();
	?>

                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">Reports</a></li>
                            <li><a href="#tab2" data-toggle="tab">Incidents</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="list_content" id="groupbox_reports">
                                    <div class="groupbox_heading">
                                        Open reports
                                        <p style="margin-right:6px" class="right">Status</p>
                                    </div>
                                    <div class="groupbox_wrapper">
                                        <div class="accordion" id="accordion2">
                                            <?php
                                                $reports->generateReportList($reportList);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="list_content_menu">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="list_content" id="incidentbox_list">
                                    <div class="groupbox_heading">
                                        Incidents
                                    </div>
                                    <div class="groupbox_wrapper">
                                        <ul>
                                            <?php
                                                $incidents->generateIncidentsList($incidentList);
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="list_content_menu_fat">
                                        View all <input type="checkbox"/>
                                        Warning <input type="checkbox"/>
                                        Ignored <input type="checkbox"/>
                                        <br/>
                                        Critical <input type="checkbox"/>
                                        Resolved <input type="checkbox"/>
                                        Internal <input type="checkbox"/>
                                        Responding <input type="checkbox"/>
                                    </div>
                                </div>
                            </div>

                            <div class="list_content" id="groupbox_details">
                                <div class="groupbox_heading">
                                    Details for selected report
                                </div>
                                <div class="groupbox_wrapper" id="reportPane">
                                    Click a report to view it.
                                </div>
                                <div class="list_content_menu">
                                    <a href="#" id="newIncident" style="float: right; margin-right: 5px; margin-top: 10px; display: none;">Make new incident</a>
                                    <a href="#" id="newMessage" style="float: right; margin-right: 5px; margin-top: 10px; display: none;">Make new message</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        

        <script type="text/javascript">
            $(document).ready(function() {

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

                $("#neweIncident").click(function() {
                    var reportId = $(this).attr('id');
                    var report = reportId.replace("report_", "");
                    $("#reportPane").css("opacity", "0");
                    $("#reportPane").load("ajax/newIncident.php", {"report": report}, function(response, status, xhr) {
                        if (status == "error") {
                            var msg = "Error: ";
                            $("#reportPane").html(msg + xhr.status + " " + xhr.statusText);
                        }
                        else {
                            $("#reportPane").fadeTo("normal",1);
                        }
                    });
                });

                var incident;
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

                var selectedReports = new Array();

            });
        </script>
        
    </body>
</html>