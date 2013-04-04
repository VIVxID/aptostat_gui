<?php 
    session_start();
?>
<!DOCTYPE html>
<html>

    <?php
        include 'html_head.inc';
        include 'propel_bootstrap.inc';
    ?>
    
    <body>
        
        <!--HEADER-->
        
        <header id="header">
            <div id="header-content">
                <a href="http://apto.vlab.iu.hio.no/customer_front.php"><img id="logo" src="img/logo.png" /></a>
            </div>
        </header>
        
        <div class="container_12">
            <div class="grid_5 suffix_1">
                <div class="front_messagebox">
                    <?php
                
                        //JSON
                        $json_url = "http://apto.vlab.iu.hio.no/api/live";
                        
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
                            $Atika = "down";
                            $DrPublish = "warning";
                            
                            print "<ol class='tree'>\r\n";
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
                                elseif ($state =="down") {
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
            <div class="grid_6">
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
          <div class="container_12">
            <hr/>
            
            <h3> Status History - last 7 days</h3>
            
            <table>
                <tr>
                    <td>
                        Service:
                    </td>
                    <td>
                        20/03
                    </td>
                    <td>
                        21/03
                    </td>
                    <td>
                        22/03
                    </td>
                    <td>
                        23/03
                    </td>
                    <td>
                        24/03
                    </td>
                    <td>
                        25/03
                    </td>
                    <td>
                        26/03
                    </td>
                    <td>
                        27/03
                    </td>
                </tr>
                <tr>
                    <td>
                        Atika Backoffice
                    </td>
                     <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                    <img src='../img/check.png' />
                    </td>
                    <td>
                    <img src='../img/check.png' />
                    </td>
                    <td>
                    <img src='../img/check.png' />
                    </td>
                    <td>
                    <img src='../img/check.png' />
                    </td>
                </tr>
                <tr>
                    <td>
                        Dr Publish API
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                     <td>
                        <img src='../img/check.png' />
                    </td>
                </tr>
                <tr>
                    <td>
                        Dr Publish Backoffice
                    </td>
                     <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    
                    
                </tr>
                <tr>
                    <td>
                        Dr Video API
                    </td>
                     <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        Dr Video Backoffice
                    </td>
                     <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        Dr Video Encoding
                    </td>
                     <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        Dr Video CDN
                    </td>
                     <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                </tr>
                <tr>
                    <td>
                        Dr Font API
                    </td>
                     <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td>
                    <td>
                        <img src='../img/check.png' />
                    </td><td>
                        <img src='../img/check.png' />
                    </td><td>
                        <img src='../img/check.png' />
                    </td><td>
                        <img src='../img/check.png' />
                    </td><td>
                        <img src='../img/check.png' />
                    </td><td>
                        <img src='../img/check.png' />
                    </td>
                </tr>
            </table>
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
            
            
            
             
        <?php include 'cust_footer.inc'; ?>
        
    </body>
</html>