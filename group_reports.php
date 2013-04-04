<!DOCTYPE html>
<html>
    <?php
		include 'html_head.inc';
		include 'propel_bootstrap.inc';
	?>
    <body>
        
        <!--HEADER-->
        
        <header id="header">
            <div id="header-content">
                <a href="http://apto.vlab.iu.hio.no/admin_front.php"><img id="logo" src="img/logo.png" /></a>
            </div>
        </header>
        
        <?php
            //API URL
            $json_url = "http://apto.vlab.iu.hio.no/api/report";
            
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
            $result_json = curl_exec($ch);
            $result = json_decode($result_json, true);
            $groups = $result["report"]["groups"];
            ksort($groups);
        ?>
        
        <div class="container_12 content_box">
            <div class="list_content" id="groupbox_reports">
                <div class="groupbox_heading">
                    Open reports
                </div>
                <div class="groupbox_wrapper">
                    <ol class="tree" id="group_menu">
                        <?php
                            foreach($groups as $group => $reports) { //gets service and its reports
                                print "<li class='group'>\r\n";
                                    print "<label for='$group'>$group</label>\r\n";
                                    print "<input type='checkbox' id='$group' />\r\n";
                                    print "<ol class='sortable'>\r\n";
                                        foreach($reports as $report) { //goes through all reports for the service
                                            print "<li class='file' id='report_".$report["idReport"]."'>Report ".$report["idReport"]."</li>\r\n"; //the .file class makes it clickable for ajax loading of the report
                                        }
                                    print "</ol>";
                                print "</li>";
                            }
                        ?>
                    </ol>
                </div>
                <div class="list_content_menu">
                    
                </div>
            </div>
            <!--<div class="list_content" id="groupbox_incidents">
                <div class="groupbox_heading">
                    Active incidents
                </div>
                <div class="groupbox_wrapper">
                    <ol class="tree" id="incident_menu">
                        <li class="group">
                            <label for="incident1">Incident 1: 2013-03-12</label>
                            <input type="checkbox" id="incident1" />
                            <ol class="sortable">
                                <li class="file" id="report_41">Report 41</li>
                                <li class="file" id="report_81">Report 81</li>
                                <li class="file" id="report_64">Report 64</li>
                            </ol>
                        </li>
                        <li class="group">
                            <label for="incident2">Incident 2: 2013-03-13</label>
                            <input type="checkbox" id="incident2" />
                            <ol class="sortable">
                                <li class="file" id="report_14">Report 14</li>
                                <li class="file" id="report_15">Report 15</li>
                                <li class="file" id="report_16">Report 16</li>
                            </ol>
                        </li>
                        <li class="group">
                            <label for="incident3">Incident 3: 2013-03-14</label>
                            <input type="checkbox" id="incident3" />
                            <ol class="sortable">
                                <li class="file" id="report_17">Report 17</li>
                                <li class="file" id="report_18">Report 18</li>
                                <li class="file" id="report_19">Report 19</li>
                            </ol>
                        </li>
                    </ol>
                </div>
                <div class="list_content_menu">
                    <div class="align2">New incident</div>
                </div>
            </div>-->
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
        
        <script type="text/javascript">
            $(document).ready(function() {
                $('.sortable')/*.sortable({ /* not sure if we need them sortable anymore, at least not in the same way as before
                    connectWith: $('.sortable'),
                    helper: "clone"
                    /*update : function () {
                        var order = $('.testsortable').sortable('serialize');
                        $("#info").load("process-sortable.php?"+order);
                    }*//*
                })*/.disableSelection(); /* turns the text into a "button" that can't be selected */
            });
            
            $(document).ready(function() {
                $('.file').click(function() {
                    var reportId = $(this).attr('id');
                    var report = reportId.replace("report_", "");
                    $('#reportPane').load('ajax/viewReport.php', {"report": report}, function(response, status, xhr) {
                        if (status == "error") {
                            var msg = "Error: ";
                            $("#reportPane").html(msg + xhr.status + " " + xhr.statusText);
                        }
                    }).selectable();
                });
            });
        </script>
        
        <?php include 'admin_footer.inc'; ?>
        
    </body>
</html>