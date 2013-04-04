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
    $incident = $result["incident"];
    
    foreach($incident as $reports => $report) {
        var_dump($reports);
        }
    
    print "Incident ID: " . $result["incident"]["idIncident"] . "<br />";
    print "Timestamp: " . $result["incident"]["timestamp"] . "<br />";
    print "Last Flag: " . $result["incident"]["lastFlag"] . "<br />";
    print "Connected Reports: " . $result["incident"]["connectedReport"] . "<br /><br />";
    print "Last Message Date: " . $result["incident"]["lastMessageDate"] . "<br />";
    print "Last Message: " . $result["incident"]["lastMessage"] . "<br />";
    print "Connected Messages " . $result["incident"]["connectedMessages"] . "<br />";
    
?>