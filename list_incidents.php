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
            $incidents = $result["report"]["incidents"];
            ksort($incidents);
            
            var_dump($incidents);
        ?>
        
        <div class="container_12 content_box">
            <div class="list_content" id="incidentbox_list">
                <div class="groupbox_heading">
                    Incidents
                </div>
                <div class="groupbox_wrapper">
                    <ul>
                        <?php
                            foreach($incidents as $incident => $array) {
                                $date = $incident["timestamp"];
                                $title = $incident["title"];
                                print "<li>Incident $incident - $date - $title</li>\r\n";
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
                <div class="groupbox_wrapper">
                    
                </div>
                <div class="list_content_menu_fat">
                    <a href="http://apto.vlab.iu.hio.no/edit_incident.php" style="float: right; margin-right: 5px; margin-top: 10px;">Make new message</a>
                </div>
            </div>
        </div>
       
        
        <?php include 'admin_footer.inc'; ?>
        
    </body>
</html>