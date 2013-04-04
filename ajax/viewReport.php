<?php
    //Uthenting av report
    
    $report = $_POST["report"];
    
    //JSON
    $json_url = "http://apto.vlab.iu.hio.no/api/report/$report";
    
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
    
    print "Report ID: " . $result["report"]["idReport"] . "<br />";
    print "Timestamp: " . $result["report"]["timestamp"] . "<br />";
    print "Last update: " . $result["report"]["lastUpdate"] . "<br />";
    print "Check type: " . $result["report"]["checkType"] . "<br />";
    print "Source name: " . $result["report"]["sourceName"] . "<br />";
    print "Service name: " . $result["report"]["hostName"] . "<br />";
    print "Flag: " . $result["report"]["status"] . "<br /><br />";
    print "Error message:<br />" . $result["report"]["errorMessage"];
?>