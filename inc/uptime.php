<?php

class Uptime
{

    function __construct()
    {



    }

    function getUptimeAsArray ()
    {

        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . "uptime",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
        );

        curl_setopt_array($curl, $options);
        $response = json_decode(curl_exec($curl),true);
        ksort($response);

        return $response;

    }

    function generateUptimeTable ($uptime)
    {

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

        $alternateColor = 1;
        foreach ($uptime as $host => $errors) {

            $daysGenerated = 6;

            if ($alternateColor == 1) {
                $rowColor = "odd";
                $alternateColor = 0;
            } else {
                $rowColor = "even";
                $alternateColor = 1;
            }

            //Prints hostnames on the Y-axis.
            echo '<tr class="'.$rowColor.'">';
            echo "<td class='uptime-y'>";
            echo $host;
            echo "</td>";

            //Runs through the dates, inserting icons relevant to the reported downtime.
            while ($daysGenerated >= 0) {

                echo "<td class='uptime-image'>";

                foreach ($errors as $errorDate => $downtime) {

                    if (date("d/m/Y", time()-(86400*$daysGenerated)) == $errorDate) {

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

                if(!isset($print)) {
                    echo "<img src='../img/check.png' />";
                }

                echo "</td>";
                $daysGenerated-=1;
                unset($print);
            }

            echo "</tr>";

        }

    }
}