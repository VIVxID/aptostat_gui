<table id="history">
    <tr>
        <td>
            Service:
        </td>
<?php

$url = "http://aptoapi.vlab.iu.hio.no/api/uptime";
$curl = curl_init($url);

$options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET"
);

curl_setopt_array($curl, $options);
$response = json_decode(curl_exec($curl),true);

        //Prints dates on the X-axis in the format "Wed 06", "Thu 07" etc.
        echo "<td>";
            echo date("D d",time()-518400);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-432000);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-345600);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-259200);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-172800);
        echo "</td>";
        echo "<td>";
            echo date("D d",time()-86400);
        echo "</td>";
        echo "<td>";
            echo date("D d",time());
        echo "</td>";
    echo "</tr>";

    ksort($response);
    
    foreach ($response as $host => $errors) {
    
        $timeFrame = array();

        //Prints hostnames on the Y-axis.
        echo "<tr>";
            echo "<td>";
                echo $host;
            echo "</td>";

        $i = 6;

        //Runs through the dates, inserting error icons if Pingdom reports any downtime.
        while ($i >= 0) {
        
            $print = 0;
            echo "<td>";
            
            foreach ($errors as $errorDate => $status) {

                if (date("D d", time()-(86400*$i)) == date("D d", $errorDate)) {
                
                    if ($status == "down") {
                    
                        echo "<img src='../img/cross.png' />";   
                        $print = 1;
                        
                    } else {
                    
                        echo "<img src='../img/warning.png' />";
                        $print = 1;
                    }
                }
            }

            if ($print == 0) {
            
                echo "<img src='../img/check.png' />";
            
            }
            
            echo "</td>";
            $i-=1;
        }
    
        echo "</tr>";
    }
    
?>

    </tr>
</table>