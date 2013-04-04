<?php
session_start();
$incidentID = "1";
        
if(isset($_SESSION["incidentId"])) {
        
    $incidentID = $_SESSION["incidentID"];
       
}

$url = "http://aptoapi.vlab.iu.hio.no/api/incident/$incidentID";
$curl = curl_init($url);

if(isset($_POST["flag"])) {

    $arrayData = array(
                    "message" => $_POST["text"],
                    "author" => $_POST["author"],
                    "flag" => $_POST["flag"],
                    "visibility" => 1);
                    
    $jsonData = json_encode($arrayData);

    $headers = array(
                    "Accept: application/json",
                    "Content-Type: application/json");
    
    $options = array(
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_POSTFIELDS => $jsonData);
    
    curl_setopt_array($curl,$options);
    
    if (curl_exec($curl) === false) {
    
        echo "Curl error: " . curl_error($curl);
        exit();
    } else {
    
        echo curl_error($curl);
        exit();
    }
}
    
$options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET");
    
curl_setopt_array($curl,$options);
    
$result = json_decode(curl_exec($curl),true);
$incident = $result["incident"];
    
?>
    <form action="edit_incident.php" method="post">
    <br />
    <?php
        echo "Selected incident: ".$incidentID."<br /><br />";
        echo "<fieldset>";
            echo "<legend>Data</legend>";
            echo '<table border="0">';
                echo "<tr>";
                    echo "<h4>Reports:</h4>";
                    echo "<ul>";
                    
                    foreach ($incident["connectedReports"] as $groupName => $group) {
                    
                        echo "<li>".$groupName."</li>";
                        echo "<ul>";
                        
                            foreach ($group as $report) {
                            
                                echo "<li>".$report["checkType"]." - ".$report["errorMessage"]."</li>";
                            
                            }
                        echo "</ul>";
                    }
                    
                    echo "</ul>";
?>
                </tr>
            </table>
            Flag: <select name="flag">
                <option value="2">Critical</option>
                <option value="1">Warning</option>
                <option value="5">Responding</option>
                <option value="6">Resolved</option>
                <option value="4">Ignored</option>
                <option value="3">Internal</option>
            </select>
        </fieldset>
            <br />
        <fieldset>
            <legend>Message</legend>
            Author: <input name="author" type="text" length="20" /><br />
            <textarea name="text" rows="10" cols="50">Update message goes here...</textarea>
            <input type="submit" value="Submit" />
        </fieldset><br />                
    </form>