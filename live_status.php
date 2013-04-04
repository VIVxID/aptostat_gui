<?php
    
    //Uthenting av report
    
    //JSON
    $json_url = "http://apto.vlab.iu.hio.no/api/live";
    
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
    
    foreach($result as $service => $state) {
        print "$service: ";
        if ($state == "up") {
            print '<img src="../img/check.png" />';
            }
        elseif ($state =="down") {
            print '<img src="../img/cross.png" />';
        }
        else {
            print '<img src="../img/warning.png" />';
        }
        print '<br />';
    }
   
?>