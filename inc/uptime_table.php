<table id="history">
    <tr>
        <td>
            Service:
        </td>
<?php

$curl = curl_init();

$options = array(
    CURLOPT_URL => APIURL . "uptime",
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

        //Prints hostnames on the Y-axis.
        echo "<tr>";
            echo "<td>";
                echo $host;
            echo "</td>";

        $i = 6;

        //Runs through the dates, inserting error icons dependig on the reported downtime.
        while ($i >= 0) {
        
            $print = 0;
            echo "<td>";
            
            foreach ($errors as $errorDate => $downtime) {

                if (date("D d", time()-(86400*$i)) == $errorDate) {

                    $outage = array_sum($downtime);

                    if ($outage > 1740) {
                    
                        echo "<img href='#' class='downtime' data-original-title='".gmdate("i:s",$outage)."' src='../img/cross.png' />";
                        $print = 1;

                    } elseif ($outage > 120) {
                    
                        echo "<img href='#' class='downtime' data-original-title='".gmdate("i:s",$outage)."' src='../img/warning.png' />";
                        $print = 1;

                    }
                }
            }

            echo "<a href='#' class='downtime' title='100%'><img src='../img/check.png' /></a>";

            echo "</td>";
            $i-=1;
        }
    
        echo "</tr>";
    }
    
?>

        <script>
            $(function ()
            { $(".downtime").tooltip();
            });
        </script>

    </tr>
</table>