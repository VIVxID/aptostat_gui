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
    $reports = $incident["connectedReports"];
    $lastMessages = $incident["connectedMessages"];
    
    print "Incident ID: " . $incident["idIncident"] . "<br />";
    print "Timestamp: " . $incident["timestamp"] . "<br />";
    print "Last Flag: " . $incident["lastFlag"] . "<br />";
    print "Connected Reports: " . foreach($reports as $report) {
        $idReport = $report["idReport"];
        print $idReport . ", ";
    } . "<br /><br />";
    print "Last Message Date: " . $incident["lastMessageDate"] . "<br />";
    print "Last Message: " . $incident["lastMessage"] . "<br />";
    print "Connected Messages " . foreach($lastMessages as $messages) {
        $date = $messages["messageDate"];
        $status = $messages["status"];
        $author = $messages["author"];
        $messageText = $messages["messageText"];
        print $date . ", ""<br />";
        print $status . ", ""<br />";
        print $author . ", ""<br />";
        print $messageText . ", ""<br />";
        
    }  . "<br />";
    
?>