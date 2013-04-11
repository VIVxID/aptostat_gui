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

echo "<ul class='nav nav-pills'>";

foreach ($checkList as $id => $incident) {

    if ($tabs == 1) {

        echo "<li class='active'><a href='#tab1' data-toggle='tab'>Incident #".$id."</a></li>";
        $tabs++;

    } else {

        echo "<li><a href='#tab".$tabs."' data-toggle='tab'>Incident #".$id."</a></li>";
        $tabs++;

    }
}

$tabs = 1;
echo "</ul>";
echo "<div class='tab-content'>";

foreach ($checkList as $id => $incident) {

    if ($tabs == 1) {

        echo "<div class='tab-pane active' id='tab1'>";
        $tabs++;

    } else {

        echo "<div class='tab-pane' id='tab".$tabs."'>";
        $tabs++;

    }

    echo "<table border='0' class='current_box_table'>";

    echo "<tr>";
    echo "<td class='table-left'>Incident #".$id."</td>";
    echo "<td class='table-right'>".$incident["lastMessage"]["status"]."</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='table-left'>".$incident["incidentTitle"]."</td>";
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
}

echo "</div>";