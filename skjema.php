<?php 
//Lage skjema for endring av en incident (har API til dette) (PHP og jQuery/Ajax)
    session_start();
?>

<!DOCTYPE html>
    <html>

        <?php
            include 'html_head.inc';
            include 'propel_bootstrap.inc';
            
            //JSON
            $json_url = "http://apto.vlab.iu.hio.no/api/incident/23"; //<-url-en uten incidentnummer
            
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
            ksort($result);
            
            var_dump($result);
            
            $title = $result["title"];
            $message = $result["message"];
            $flag = $result["flag"];
            
            print "<form>\r\n";
                print "<input type='text' name='title' value='$title' /><br>\r\n";
                print "<input type='text' name='flag' value='$flag' /><br>\r\n";
                print "<input type='textfield' name='message' value='$message'>\r\n";
            print "</form>";
        ?>