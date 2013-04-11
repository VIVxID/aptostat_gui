<?php 
    session_start();
?>
<!DOCTYPE html>
<html>

    <?php
        include 'html_head.inc';
    ?>
    
    <body>
        
        <!--HEADER-->
        
        <header id="header">
            <div id="header-content">
                <a href="http://apto.vlab.iu.hio.no/admin_front.php"><img id="logo" src="img/logo.png" /></a>
            </div>
        </header>
        
        <div class="container">
            <div class="row">
                <div class="span5 suffix1">
                    <div class="front_messagebox">
                        <?php
                    
                            //JSON
                            $json_url = "http://aptoapi.vlab.iu.hio.no/api/live";
                            
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
                            foreach($result as $service => $state) {
                                $product = explode(" ", $service); //get product name
                                $tree[$product[0]][$product[1]] = $state; //put each service and its state under the corresponding product entry
                            }
                            
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
                                
                                //for testing auto-expand on errors
                                //$Atika = "down";
                                //$DrPublish = "warning";
                                
                                print "<li>\r\n";
                                if($$product == "down") {
                                    print "<label for='$product'><b>$product <img src='../img/cross.png' /> Down</b></label>\r\n".
                                    "<input type='checkbox' checked id='$product' />\r\n";
                                }
                                elseif($$product == "warning") {
                                    print "<label for='$product'><b>$product <img src='../img/warning.png' /> Problem</b></label>\r\n".
                                    "<input type='checkbox' checked id='$product' />\r\n";
                                }
                                else {
                                    print "<label for='$product'><b>$product <img src='../img/check.png' /> OK</b></label>\r\n".
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
                        ?>
                    </div>
                </div>
                
                <div class="span6 offset1">
                    <div id="current_box" class="error">
                        <table border="0" class="current_box_table">
                            <tr>
                                <td class="table-left">Ongoing issues</td>
                                <td class="table-right">[Unresolved]</td>
                            </tr>
                            <tr>
                                <td class="table-left">Services:</td>
                                <td class="table-right">
                                    DrPublish API<br/>
                                    DrPublish Backoffice
                                </td>
                            </tr>
                            <tr>
                                <td class="table-left">Status:</td>
                                <td class="table-right">Critical</td>
                            </tr>
                            <tr>
                                <td class="table-left">Date:</td>
                                <td class="table-right">07/03-2013 11:50</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    We're in a bit of a snafu here and DrPublish Backoffice is down at the moment. DrPublish API may also be unstable.<br/>
                                    We are working on a fix.
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        
        </div>
        <div class="container">
            <hr/>
            
            <h3> Status History - last 7 days</h3>

            <?php include "uptime_table.php"; ?>

            <hr/>
            
            <div id="current_box" class="error">
            
            <h3>Issue history - Last 3 days</h3>
            <table border="0" class="current_box_table">
                        <tr>
                            <td class="table-left">Ongoing issues</td>
                            <td class="table-right">[Unresolved]</td>
                        </tr>
                        <tr>
                            <td class="table-left">Services:</td>
                            <td class="table-right">
                                DrPublish API<br/>
                                DrPublish Backoffice
                            </td>
                        </tr>
                        <tr>
                            <td class="table-left">Status:</td>
                            <td class="table-right">Critical</td>
                        </tr>
                        <tr>
                            <td class="table-left">Date:</td>
                            <td class="table-right">07/03-2013 11:50</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                We're in a bit of a snafu here and DrPublish Backoffice is down at the moment. DrPublish API may also be unstable.<br/>
                                We are working on a fix.
                            </td>
                        </tr>
                    </table>
            </div>
            </div>
      
        
        <?php include 'admin_footer.inc'; ?>
       
    </body>
</html>