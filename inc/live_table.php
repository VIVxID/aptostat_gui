<?php

$curl = curl_init();

$options = array(
    CURLOPT_URL => APIURL . "live",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET"
);

//setting curl options

curl_setopt_array($curl, $options);

//getting results

$result_json = curl_exec($curl);
$result = json_decode($result_json, true);
ksort($result);

foreach($result as $service => $state) {

    $product = explode(" ", $service); //get product name
    
    $tree[$product[0]][$product[1]] = $state; //put each service and its state under the corresponding product entry
}
print "<div id='service-panel-wrapper'>";
    print "<ol class='tree'>\r\n";

    foreach($tree as $product => $array) {

        foreach($array as $service => $state) { //check status of services

            switch($state) {

                case "up":
                    $$product = "up";

                    break;

                case "down":
                    $$product = "down";

                    break;

                default:
                    $$product = "warning";

                    break;
            }
        }

        print "<li>\r\n";

        if($$product == "down") {

            print
                "<hr>".
                "<label for='$product'>$product <span class='service-status'>Down <img src='../img/cross.png' /></span></label>\r\n".
                "<input type='checkbox' checked id='$product' />\r\n";
        }
        elseif($$product == "warning") {

            print
                "<hr>".
                "<label for='$product'>$product <span class='service-status'>Problem <img src='../img/warning.png' /></span></label>\r\n".
                "<input type='checkbox' checked id='$product' />\r\n";
        }
        else {

            print
                "<hr>".
                "<label for='$product'>$product <span class='service-status'>OK <img src='../img/check.png' /></span></label>\r\n".
                "<input type='checkbox' id='$product' />\r\n";
        }

        print "<ol>\r\n";

        foreach($array as $service => $state) {

            print "<li class='file'>\r\n";
            print "$service ";

            //validating state
            if ($state == "up") {
                print "<img src='../img/check.png' /> OK\r\n";
            }
            elseif ($state == "down") {
                print "<img src='../img/cross.png' /> Down\r\n";
            }
            else {
                print "<img src='../img/warning.png' /> Problem\r\n";
            }
            print "<br />\r\n";
        }
        print "</ol>\r\n";
        print "</li>\r\n";
    }
    print "</ol>\r\n";
print "</div>";