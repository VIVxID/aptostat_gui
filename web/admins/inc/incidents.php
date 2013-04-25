<?php

class Incidents
{

    function getIncidentsAsArray()
    {

        $ch = curl_init();

        $options = array(
            CURLOPT_URL => APIURL . "incident",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
        );

        curl_setopt_array($ch, $options);

        $result = json_decode(curl_exec($ch), true);
        $incidents = $result["incidents"];
        ksort($incidents);

        return $incidents;

    }

    function generateIncidentsList($incidents)
    {

        foreach($incidents as $incident) {
            $date = $incident["createdTimestamp"];
            $title = $incident["title"];
            $flag = $incident["lastStatus"];
            print "<li class='incident file flag_$flag' id='incident_".$incident["id"]."'>Incident ".$incident["id"]." - $date - $title</li>\r\n";
        }

    }

}