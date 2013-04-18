<?php

class CurrentIncidents
{

    function getIncidentsAsArray()
    {

        $checkList = array();
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . "incident",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
        );

        curl_setopt_array($curl, $options);

        $response = json_decode(curl_exec($curl), true);

        $incidentList = $response["incidents"];

        foreach ($incidentList as $currentIncident) {

            if ($currentIncident["hidden"] != "false") {

                $checkList[] = $currentIncident;

            }

        }

        return $checkList;

    }

    function generateIncidentList($incidents)
    {

        if (empty($incidents)) {

            echo '<div id="current_box" class="no_issues">';
            echo "<p class='all-clear'>No current issues.</p>";

        } else {

            echo '<div id="current_box" class="error">';

            echo "<div class='accordion' id='accordion2'>";

            foreach ($incidents as $incident) {

                echo "<div class='accordion-group'>";

                echo "<div class='accordion-heading'>";
                echo "<a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse".$incident["id"]."'>";
                echo "Incident #".$incident["id"];
                echo "</a>";
                echo "</div>";

                echo "<div id='collapse".$incident["id"]."' class='accordion-body collapse'>";
                echo "<div class='accordion-inner'>";

                echo "<table border='0' class='current_box_table'>";

                echo "<tr>";
                echo "<td class='left'>Incident #".$incident["id"]."</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td class='left'>".$incident["title"]."</td>";
                echo "</tr>";

                echo "<td colspan='2'><hr /></td>";

                echo "<tr>";
                echo "<td class='left'>Created on:</td>";
                echo "<td class='right'>".$incident["createdTimestamp"]."</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td colspan='2'><hr /></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td class='left'>Last update:</td>";
                echo "<td class='right'>".$incident["lastMessageTimestamp"]."</td>";
                echo "<td class='right'>".$incident["lastMessageText"]."</td>";
                echo "</tr>";

                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }

            echo "</div>";
        }
        echo "</div>";

    }
}