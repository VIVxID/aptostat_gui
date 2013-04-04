<?php 
    session_start();
    $structuredReports = array();
    if(isset($_POST)) {
        $incidentID = $_POST["incidentId"];
    }
    
    $url = "http://aptoapi.vlab.iu.hio.no/api/incident/$incidentID";
    $curl = curl_init($url);
    
    $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "GET");
    
    curl_setopt_array($curl,$options);
    
    $result = json_decode(curl_exec($curl),true);
    $incident = $result["incident"];
    
?>
    <form action="" method="post">;
    <br />;
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
                            
                                echo "<li>".$report["checkType"]."</li>";
                            
                            }
                        echo "</ul>";
                    }
                    
                    echo "</ul>";
?>
                </tr>
            </table>
            Flag: <select name="flags">
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
            Author: <input type="text" length="20" /><br />
            <textarea rows="10" cols="50">Update message goes here...</textarea>
        </fieldset><br />                
    </form>
?>