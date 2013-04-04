<?php
$hosts = array(
                "Atika Backoffice" => 615766,
                "DrVideo Encoding" => 615772,
                "DrFront Backoffice" => 615760,
                "DrVideo Backoffice" => 615764,
                "DrVideo CDN" => 615768,
                "DrVideo API" => 615770,
                "DrPublish Backoffice" => 615767,
                "DrPublish API" => 615771);

$login = file("/var/apto/ping", FILE_IGNORE_NEW_LINES);
?>

<table>
    <tr>
        <td>
            Service:
        </td>
<?php
        echo "<td>";
            echo date("D d",time());
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-86400);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-172800);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-259200);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-345600);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-432000);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-518400);
        echo "</td>";
    echo "</tr>";

    foreach ($hosts as $hostName => $hostID) {
    
        $timeFrame = array();
    
        echo "<tr>";
            echo "<td>";
                echo $hostName;
            echo "</td>";
    
        $curl = curl_init();
    
        $options = array(
            CURLOPT_URL => "https://api.pingdom.com/api/2.0/summary.outage/$hostID",
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_USERPWD => $login[0].":".$login[1],
            CURLOPT_HTTPHEADER => array("App-Key: ".$login[2]),
            CURLOPT_RETURNTRANSFER => true
        );

        curl_setopt_array($curl,$options);
        $response = json_decode(curl_exec($curl),true);
        $checkList = $response["summary"]["states"];
        
        foreach ($checkList as $check) {
        
            if ($check["status"] != "up") {
            
                $timeFrame[date("D d",$check["timefrom"])] = $check["status"];
            
            }
        }
    
        for ($i = 6; $i = 0; $i--) {
        
            echo "<td>";
            
            foreach ($timeFrame as $date => $status) {

                if (date("D d", time()-(86400*$i) == $date) {
                
                    if ($status == "down") {
                    
                        echo "<img src='../img/cross.png' />";   
                        $print = 1;
                        
                    } else {
                    
                        echo "<img src='../img/warning.png' />";
                        $print = 1;
                    }
                }
            }

            if ($print != 1) {
            
                echo "<img src='../img/check.png' />";
            
            }
            
            $print = 0;
            echo "</td>";
        }
    
        echo "</tr>";
    }
    
?>