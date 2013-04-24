﻿<?php
    include 'inc/html_head.php';
    include 'inc/apiurl.php';
    include 'inc/reports.php';
    include 'inc/incidents.php';

    $reports = new Reports();
    $reportList = $reports->getReportsAsArray();

    $incidents = new Incidents();
    $incidentList = $incidents->getIncidentsAsArray();

    $url = APIURL . "incident/$incidentID";
    $curl = curl_init($url);

    if(isset($_POST["submitEdit"])) {

        $arrayData = array(
            "message" => $_POST["message"],
            "author" => $_POST["author"],
            "flag" => $_POST["flag"],
            "visibility" => 1);

        $jsonData = json_encode($arrayData);

        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json");

        $options = array(
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $jsonData);

        curl_setopt_array($curl,$options);

        if (curl_exec($curl) === false) {
            echo "Curl error: " . curl_error($curl);
            exit();
        }
        else {
            echo "Message recieved.";
            exit();
        }
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
                                <div class="groupbox_wrapper" id="reportPane">
                                    <div id="form">
                                        <form name="messageForm" action="" id="messageForm">
                                            <br />
                                            <?php
                                                echo "Selected incident: ".$incidentID."<br /><br />";
                                            ?>
                                            <fieldset>
                                                <legend>Data</legend>
                                                <table border="0">
                                                    <tr>
                                                        <h4>Reports:</h4>
                                                        <ul>
                                                            <?php
                                                                foreach ($incident["connectedReports"] as $groupName => $group) {

                                                                    echo "<li>".$groupName."</li>";
                                                                    echo "<ul>";

                                                                    foreach ($group as $report) {
                                                                        echo "<li>".$report["checkType"]." - ".$report["errorMessage"]."</li>";
                                                                    }
                                                                    echo "</ul>";
                                                                }
                                                            ?>
                                                        </ul>
                                                    </tr>
                                                </table>
                                                Flag:
                                                <select name="flag" id="fieldFlag">
                                                    <option value="CRITICAL">Critical</option>
                                                    <option value="WARNING">Warning</option>
                                                    <option value="RESPONDING">Responding</option>
                                                    <option value="RESOLVED">Resolved</option>
                                                    <option value="IGNORED">Ignored</option>
                                                    <option value="INTERNAL">Internal</option>
                                                </select>
                                            </fieldset>
                                            <br />
                                            <fieldset>
                                                <legend>Message</legend>
                                                Author: <input name="author" type="text" length="20" id="fieldAuthor" /><br />
                                                <textarea id="fieldMessage" name="message" rows="10" cols="50"></textarea><br />
                                                <input type="submit" value="Submit" id="buttonSubmit" />
                                            </fieldset><br />
                                        </form>
                                    </div>
                                </div>
                                <div class="list_content_menu">
                                    <a href="#" id="editIncident" style="float: right; margin-right: 5px; margin-top: 10px; ">Edit incident</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </body>
</html>