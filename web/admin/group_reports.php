<!DOCTYPE html>
<html>
    <?php
		include '../inc/html_head.php';
        include 'inc/apiurl.php';
	?>
    <body>
        
        <!--HEADER-->
        
        <header id="header">
            <div id="header-content">
                <a href="http://apto.vlab.iu.hio.no/admin_front.php"><img id="logo" src="/img/logo.png" /></a>
            </div>
        </header>
        
        <?php

            $json_url = APIURL . "report";
            $groups = array();
            $collapseOrder = 1;

            //initializing curl
            $ch = curl_init($json_url);
            
            //Curl options
            $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
            );
            
            //setting curl options
            curl_setopt_array($ch, $options);
            
            //getting results
            $response = json_decode(curl_exec($ch),true);

            foreach ($response["reports"] as $report) {

                $groups[$report["host"]][] = $report;

            }

            ksort($groups);
        ?>
        
        <div class="container">
            <div class="row">
                <div class="list_content" id="groupbox_reports">
                    <div class="groupbox_heading">
                        Open reports
                    </div>
                    <div class="groupbox_wrapper">
                        <div class="accordion" id="accordion2">
                            <?php
                                foreach($groups as $group => $reports) { //gets service and its reports
                                    print "<div class='accordion-group'>\r\n";
                                        print "<div class='accordion-heading'>";
                                        print "<a class='accordion-toggle collapsed' data-toggle='collapse' data-parent='#accordion2' href='#".$collapseOrder."'>".$group."</a>\r\n";
                                        print "</div>\r\n";
                                        print "<div id='".$collapseOrder."' class='accordion-body collapse'>\r\n";
                                        print "<div class='accordion-inner'>\r\n";
                                        print "<ol>\r\n";
                                        foreach($reports as $report) { //goes through all reports for the service
                                            print "<li class='file' id='report_".$report["id"]."'>";//the .file class makes it clickable for ajax loading of the report
                                            print "Error #".$report["id"]."\r\n";
                                            print "<p class='tinytext'>Check type: ".$report["checkType"]."</p>";
                                            print "<p class='tinytext'>Error message: ".$report["errorMessage"]."</p>";
                                        }
                                        print "</li>\r\n";
                                        print "</ol>\r\n";
                                        print "</div>\r\n";
                                        print "</div>\r\n";
                                    print "</div>\r\n";
                                    $collapseOrder++;
                                }
                            ?>
                        </div>
                    </div>
                    <div class="list_content_menu">
                        
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
                        
                    </div>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">
            $(document).ready(function() {

                $(".file").click(function() {
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
                });
                
                $(".file").click(function() {
                    var reportId = $(this).attr('id');
                    var report = reportId.replace("report_", "");
                    $("#reportPane").css("opacity", "0");
                    $("#reportPane").load("ajax/makeIncident.php", {"report": report}, function(response, status, xhr) {
                        if (status == "error") {
                            var msg = "Error: ";
                            $("#reportPane").html(msg + xhr.status + " " + xhr.statusText);
                        }
                        else {
                            $("#reportPane").fadeTo("normal",1);
                        }
                    });
                });
                
            });
        </script>
        
        <?php include 'inc/admin_footer.php'; ?>
        
    </body>
</html>