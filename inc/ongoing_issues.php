<?php

$curl = curl_init();
$tabs = 1;

$options = array(
    CURLOPT_URL => "http://aptoapi.vlab.iu.hio.no/api/report",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET"
);

curl_setopt_array($curl, $options);

$response = json_decode(curl_exec($curl), true);

$checkList = $response["report"]["incidents"];

if (empty($checkList)) {

    echo '<div id="current_box" class="no_issues">';
    echo "<p class='all-clear'>No current issues.</p>";

} else {

    echo '<div id="current_box" class="error">';

    echo "<div class='accordion' id='accordion2'>";

    foreach ($checkList as $id => $incident) {

        echo "<div class='accordion-group'>";

        echo "<div class='accordion-heading'>";
        echo "<a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse".$id."'>";
        echo "Incident #".$id;
        echo "</a>";
        echo "</div>";

        echo "<div id='collapse".$id."' class='accordion-body collapse'>";
        echo "<div class='accordion-inner'>";

        echo "<table border='0' class='current_box_table'>";

        echo "<tr>";
        echo "<td class='table-left'>Incident #".$id."</td>";
        echo "<td class='table-right'>".$incident["lastMessage"]["status"]."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-right'>".$incident["incidentTitle"]."</td>";
        echo "</tr>";

        echo "<td colspan='2'><hr /></td>";

        echo "<tr>";
        echo "<td class='table-left'>Errors:</td>";

        foreach ($incident["reports"] as $report) {

            echo "<td class='table-right'>".$report["serviceName"]." - ".$report["checkType"]."</td>";

        }

        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-left'>Created on:</td>";
        echo "<td class='table-right'>".$incident["incidentTimestamp"]."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan='2'><hr /></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-left'>Last update:</td>";
        echo "<td class='table-right'>".$incident["lastMessage"]["messageDate"]."</td>";
        echo "<td class='table-right    '>".$incident["lastMessage"]["messageText"]."</td>";
        echo "</tr>";

        echo "</table>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
}
echo "</div>";