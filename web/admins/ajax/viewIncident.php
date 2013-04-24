<?php
    //Uthenting av incident
    
    include '../inc/apiurl.php';
    
    $incident = $_POST["incident"];

    $ch = curl_init();
    $options = array(
    CURLOPT_URL => APIURL . "incident/$incident",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET"
    );
    
    curl_setopt_array($ch, $options);
    $result = json_decode(curl_exec($ch),true);
    $incident = $result["incidents"];
    $messages = $incident["messageHistory"];
    $reports = $incident["connectedReports"];

    print "Incident ID: " . $incident["id"] . "<br />";
    print "Timestamp: " . $incident["createdTimestamp"] . "<br />";
    print "Last Flag: " . $incident["lastStatus"] . "<br />";
    print "Connected Reports: ";

    foreach($reports as $report) {
            print $report . ", ";
    }

    print "<br />";
    print "Author: " . $incident["lastMessageAuthor"] . "<br />";
    print "Last Message Date: " . $incident["lastMessageTimestamp"] . "<br />";
    print "Author: " . $incident["lastMessageAuthor"] . "<br />";
    print "Last Message: " . $incident["lastMessageText"] . "<br />";
    
    print "<br /> Connected Messages : <br />";
    foreach($messages as $messages) {
        
        $date = $messages["messageTimestamp"];
        $status = $messages["messageStatus"];
        $author = $messages["messageAuthor"];
        $messageText = $messages["messageText"];
        
        print "Date: " . $date . "<br />";
        print "Flag: " . $status . "<br />";
        print "Author: " . $author . "<br />";
        print "Message: " . $messageText . "<br />";
        
   }   
    
?>