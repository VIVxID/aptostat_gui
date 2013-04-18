<?php

class Reports
{

    function getReportsAsArray()
    {

        $groups = array();
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . "report",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
        );

        curl_setopt_array($ch, $options);
        $response = json_decode(curl_exec($ch),true);

        foreach ($response["reports"] as $report) {

            $groups[$report["host"]][] = $report;

        }
        ksort($groups);

        return $groups;

    }

    function generateReportList($groups)
    {

        $collapseOrder = 1;

        foreach($groups as $group => $reports) { //gets service and its reports

            foreach ($reports as $report) {
                if ($report["flag"] == "WARNING") {
                    $warningsExist = 1;
                } elseif ($report["flag"] == "CRITICAL") {
                    $criticalsExist = 1;
                }
            }

            if (isset($criticalsExist)) {
                $titleImage = "../img/cross.png";
            } elseif (isset($warningsExist)) {
                $titleImage = "../img/warning.png";
            } else {
                $titleImage = "../img/check.png";
            }

            if (!isset($warningsExist) and !isset($criticalsExist)) {
                $titleErrorString = "All responding";
            } elseif (count($reports) > 1){
                $titleErrorString = count($reports)." errors";
            } else {
                $titleErrorString = "1 error";
            }

            unset($criticalsExist);
            unset($warningsExist);

            print "<div class='accordion-group'>\r\n";
            print "<div class='accordion-heading'>";
            print "<a class='accordion-toggle collapsed' data-toggle='collapse' href='#".$collapseOrder."'><img class='right' src='$titleImage' />".$group." - $titleErrorString</a>\r\n";
            print "</div>\r\n";
            print "<div id='".$collapseOrder."' class='accordion-body collapse'>\r\n";
            print "<div class='accordion-inner'>\r\n";
            print "<ol class='selectable'>\r\n";
            foreach($reports as $report) { //goes through all reports for the service
                print "<li class='report file ui-widget-content' id='report_".$report["id"]."'>\r\n";//the .file class makes it clickable for ajax loading of the report
                print "Error #".$report["id"]." - ".ucwords(strtolower($report["flag"]))."\r\n";
                print "<p class='tinytext'>Check type: ".$report["checkType"]."</p>\r\n";
                print "<p class='tinytext'>Error message: ".$report["errorMessage"]."</p>\r\n";
            }
            print "</li>\r\n";
            print "</ol>\r\n";
            print "</div>\r\n";
            print "</div>\r\n";
            print "</div>\r\n";
            $collapseOrder++;
        }

    }

}