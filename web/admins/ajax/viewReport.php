<?php
    //Uthenting av report
    
    include '../inc/apiurl.php';
    
    $report = $_POST["report"];
    
    //JSON
    $json_url = APIURL . "report/$report";
    
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
    
    print "Report ID: " . $result["reports"]["id"] . "<br />";
    print "Timestamp: " . $result["reports"]["createdTimestamp"] . "<br />";
    print "Last update: " . $result["reports"]["lastUpdatedTimestamp"] . "<br />";
    print "Check type: " . $result["reports"]["checkType"] . "<br />";
    print "Source name: " . $result["reports"]["source"] . "<br />";
    print "Service name: " . $result["reports"]["host"] . "<br />";
    print "Flag: " . $result["reports"]["flag"] . "<br /><br />";
    print "Error message:<br />" . $result["reports"]["errorMessage"];
?>