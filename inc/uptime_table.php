<h3> Status History - last 7 days</h3>
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
        echo "<td class='uptime-x'>";
            echo date("D d",time()-518400);
        echo "</td>";
        echo "<td class='uptime-x'>";
            echo date("D d",time()-432000);
        echo "</td>";
        echo "<td class='uptime-x'>";
            echo date("D d",time()-345600);
        echo "</td>";
        echo "<td class='uptime-x'>";
            echo date("D d",time()-259200);
        echo "</td>";
        echo "<td class='uptime-x'>";
            echo date("D d",time()-172800);
        echo "</td>";
        echo "<td class='uptime-x'>";
            echo date("D d",time()-86400);
        echo "</td>";
        echo "<td class='uptime-x'>";
            echo date("D d",time());
        echo "</td>";
    echo "</tr>";

    ksort($response);
    
    foreach ($response as $host => $errors) {

        //Prints hostnames on the Y-axis.
        echo "<tr>";
            echo "<td class='uptime-y'>";
                echo $host;
            echo "</td>";

        $i = 6;

        //Runs through the dates, inserting icons relevant to the reported downtime.
        while ($i >= 0) {
        
            $print = 0;
            echo "<td class='uptime-image'>";
            
            foreach ($errors as $errorDate => $downtime) {

                if (date("d/m/Y", time()-(86400*$i)) == $errorDate) {

                    $outage = array_sum($downtime);

                    if ($outage > 1740) {
                    
                        echo "<a href='#' class='downtime' title='" . (86400-$outage)/864 . "% uptime.'><img src='../img/cross.png' /></a>";
                        $print = 1;

                    } elseif ($outage > 120) {

                        echo "<a href='#' class='downtime' title='" . (86400-$outage)/864 . "% uptime.'><img src='../img/warning.png' /></a>";
                        $print = 1;

                    }
                }
            }

            echo "<img src='../img/check.png' />";

            echo "</td>";
            $i-=1;
        }
    
        echo "</tr>";
    }
    
?>

        <script>
            $(function ()
            { $(".downtime").tooltip({'placement': 'left'});
            });
            $(function ()
            { $('.nav-tabs').button()
            });
        </script>

    </tr>
</table>