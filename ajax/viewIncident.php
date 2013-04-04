<?php
    //Uthenting av incident
    
    $incident = $_POST["incident"];
    
    //JSON
    $json_url = "http://apto.vlab.iu.hio.no/api/incident/1";
    
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
    
    var_dump($result);
    // print "Incident ID: " . $result["incident"]["idIncident"] . "<br />";
    // print "Timestamp: " . $result["report"]["timestamp"] . "<br />";
    // print "Last update: " . $result["report"]["lastUpdate"] . "<br />";
    // print "Check type: " . $result["report"]["checkType"] . "<br />";
    // print "Source name: " . $result["report"]["sourceName"] . "<br />";
    // print "Service name: " . $result["report"]["hostName"] . "<br />";
    // print "Flag: " . $result["report"]["status"] . "<br /><br />";
    // print "Error message:<br />" . $result["report"]["errorMessage"];
?>