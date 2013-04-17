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

            if (count($reports) > 1){
                $countString = count($reports)." errors";
            } else {
                $countString = "1 error";
            }

            print "<div class='accordion-group'>\r\n";
            print "<div class='accordion-heading'>";
            print "<a class='accordion-toggle collapsed' data-toggle='collapse' data-parent='#accordion2' href='#".$collapseOrder."'>".$group." - $countString</a>\r\n";
            print "</div>\r\n";
            print "<div id='".$collapseOrder."' class='accordion-body collapse'>\r\n";
            print "<div class='accordion-inner'>\r\n";
            print "<ol>\r\n";
            foreach($reports as $report) { //goes through all reports for the service
                print "<li class='report file ui-widget-content' id='report_".$report["id"]."'>";//the .file class makes it clickable for ajax loading of the report
                print "Error #".$report["id"]." - ".$report["flag"]."\r\n";
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

    }

}