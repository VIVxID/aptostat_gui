<!DOCTYPE html>
<html>
    <?php
		include 'inc/html_head.php';
        include 'inc/apiurl.php';
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
            $json_url = APIURL . "report";
            
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
            $incidents = $result["report"]["incidents"];
            ksort($incidents);
        ?>
        
        <div class="container content_box">
            <div class="row">
                <div class="list_content" id="incidentbox_list">
                    <div class="groupbox_heading">
                        Incidents
                    </div>
                    <div class="groupbox_wrapper">
                        <ul>
                            <?php
                                foreach($incidents as $incident => $details) {
                                        $date = $details["incidentTimestamp"];
                                        $title = $details["incidentTitle"];
                                        print "<li class='file' id='incident_$incident'>Incident $incident - $date - $title</li>\r\n";
                                    
                                }
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
                <div class="list_content" id="incidentbox_details">
                    <div class="groupbox_heading">
                        Details
                    </div>
                    <div class="groupbox_wrapper" id="reportPane">
                            Click on an incident to view it and to make or edit messages for the incident.
                    </div>
                    <div class="list_content_menu_fat">
                        <a href="#" id="newMessage" style="float: right; margin-right: 5px; margin-top: 10px; display: none;">Make new message</a>
                    </div>
                </div>
            </div>
        </div>
       
       <script type="text/javascript">
            $(document).ready(function() {
                    
                    var incident;
                    
                    $(".file").click(function() {
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
                    
                });
        </script>
        
        <?php include 'inc/admin_footer.php'; ?>
        
    </body>
</html>