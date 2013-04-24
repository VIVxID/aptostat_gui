<?php
    include 'inc/html_head.php';
    include 'inc/apiurl.php';
    include 'inc/reports.php';
    include 'inc/incidents.php';

    $reports = new Reports();
    $reportList = $reports->getReportsAsArray();

    $incidents = new Incidents();
    $incidentList = $incidents->getIncidentsAsArray();


    if (isset($_POST["submitInc"])) {

        //API URL Incident
        $json_url = APIURL . "incident";

        //initializing curl
        $ch = curl_init($json_url);

        $arrayData = array(
            "title" => $_POST["name"],
            "flag" => $_POST["author"],
            "flag" => $_POST["flag"],
            "visibility" => 1);

        //Curl options

        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json");

        $options = array(
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $jsonData,
        );

        //setting curl options
        curl_setopt_array($ch, $options);

        //getting results
        $result_json = curl_exec($ch);
        $result = json_decode($result_json, true);
        $incidents = $result["incident"]["incidents"];
        ksort($incidents);
    }
?>

                    <div class="tabbable">
                    
                        <ul class="nav nav-tabs">
                            <li class="active" id="reportTab"><a href="#tab1" data-toggle="tab">Reports</a></li>
                            <li id="incidentTab"><a href="#tab2" data-toggle="tab">Incidents</a></li>
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
                                    <div class="list_content_menu">
                                        <div class="btn-group" data-toggle="buttons-checkbox">
                                            <button type="button" class="btn btn-primary filter active" id="warning">Warning</button>
                                            <button type="button" class="btn btn-primary filter active" id="critical">Critical</button>
                                            <button type="button" class="btn btn-primary filter active" id="responding">Responding</button>
                                            <button type="button" class="btn btn-primary filter" id="resolved">Resolved</button>
                                            <button type="button" class="btn btn-primary filter" id="ignored">Ignored</button>
                                            <button type="button" class="btn btn-primary filter active" id="internal">Internal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="list_content" id="groupbox_details">
                                <div class="groupbox_heading">
                                    Details for selected report
                                </div>
                                
                            <form name="messageForm" action="group_reports.php" id="messageForm"> 
                                <div class="groupbox_wrapper" id="reportPane">                             
                                    <div id="form">
                                        New incident
                                                
                                        <fieldset>
                                            <legend>Data</legend>
                                            <table border="0">
                                                <tr>
                                                    <h4>Included reports: </h4><span id='select-result'>None</span>
                                                </tr>
                                            </table>
                                            Flag: <select name="flag" id="fieldFlag">
                                                <option value="CRITICAL">Critical</option>
                                                <option value="WARNING">Warning</option>
                                                <option value="RESPONDING">Responding</option>
                                                <option value="RESOLVED">Resolved</option>
                                                <option value="IGNORED">Ignored</option>
                                                <option value="INTERNAL">Internal</option>
                                            </select>
                                        </fieldset>
                                        
                                        <fieldset>
                                            <legend>Message</legend>
                                            Author: <input name="author" type="text" length="20" id="fieldAuthor" /><br />
                                            <textarea id="fieldMessage" name="message" rows="10" cols="50"></textarea><br />
                                            
                                        </fieldset>
                                     </div>
                                </div>
                                
                                <div class="list_content_menu">
                                    <input type="submit" value="Cancel" name="cancel" id="buttonSubmit" style:float:left;/>
                                    <input type="submit" value="Save" name="save" id="buttonSubmit" style:float:right;/>      
                                </div>
                            </form>
                            
                           </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>