<?php
    //Uthenting av incident
    
    include 'inc/apiurl.php';
    
    $incident = $_POST["incident"];
    
    //JSON
    $json_url = APIURL . "incident/$incident";
    
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
    $messages = $incident["connectedMessages"]["public"];
    
    print "Incident ID: " . $incident["idIncident"] . "<br />";
    print "Timestamp: " . $incident["timestamp"] . "<br />";
    print "Last Flag: " . $incident["lastFlag"] . "<br />";
    print "Author: " . $incident["author"] . "<br />";
    print "Connected Reports: ";
    foreach($reports as $report) {
        $idReport = $report["idReport"];
        print $idReport . ", ";
    }
    print "<br />";
    print "Last Message Date: " . $incident["lastMessageDate"] . "<br />";
    print "Last Message: " . $incident["lastMessage"] . "<br />";
    
    print "<br /> Connected Messages : <br />";
    foreach($messages as $messages) {
        
        $date = $messages["messageDate"];
        $status = $messages["status"];
        $author = $messages["author"];
        $messageText = $messages["messageText"];
        
        print "Date: " . $date . "<br />";
        print "Flag: " . $status . "<br />";
        print "Author: " . $author . "<br />";
        print "Message: " . $messageText . "<br />";
        
   }   
    
?>