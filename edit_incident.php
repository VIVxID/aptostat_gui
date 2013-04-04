<?php 
    session_start();
    
    if(isset($_POST)) {
        
    }
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
                <a href="http://apto.vlab.iu.hio.no/admin_front.php"><img id="logo" src="img/logo.png" /></a>
            </div>
        </header>
        
        <div class="container_12 content_box">
            <div class="list_content" id="incidentbox_list">
                <ul>
                    <li>Incident 1 - 2013-03-12</li>
                    <li>Incident 2 - 2013-03-13</li>
                    <li>Incident 3 - 2013-03-14</li>
                    <li>Incident 4 - 2013-03-15</li>
                    <li>Incident 5 - 2013-03-16</li>
                    <li>Incident 6 - 2013-03-17</li>
                </ul>
                
                <div class="list_content_menu_fat">
                    View all <input type="checkbox"/>
                    Warning <input type="checkbox"/>
                    Ignored <input type="checkbox"/>
                    <br/>
                    Critical <input type="checkbox"/>
                    Resolved <input type="checkbox"/>
                    Internal <input type="checkbox"/>
                    Responding <input type="checkbox"/>
                </div>
            </div>
            <div class="list_content" id="incidentbox_details">
                <form action="" method="post">
                    <br />
                    Selected incident: 1<br /><br />
                    <fieldset>
                        <legend>Data</legend>
                        <table border="0">
                            <tr>
                                <td>Reports:</td>
                                <td>Report 1</td>
                                <td><a href="group_reports.php">Click here to add or remove reports</a></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>Report 2</td>
                            </tr>
                        </table>
                        Flag: <select name="flags">
                            <option value="critical">Critical</option>
                            <option value="warning">Warning</option>
                            <option value="responding">Responding</option>
                            <option value="resolved">Resolved</option>
                            <option value="ignored">Ignored</option>
                            <option value="internal">Internal</option>
                        </select>
                    </fieldset><br />
                    <fieldset>
                        <legend>Message</legend>
                        Author: <input type="text" length="20" /><br />
                        <textarea rows="10" cols="50">Update message goes here...</textarea>
                    </fieldset><br />
                    
                </form>
                <div class="list_content_menu_fat">
                    <form action="list_incidents.php">
                        <input type="submit" value="Cancel" /><input type="submit" value="Submit" />
                    </form>
                </div>
               
        
            <!-- JSON and curl-->
             <!--?php 
                    //Uthenting av report
                    
                    //JSON
                    $json_url = "http://apto.vlab.iu.hio.no/api/report";
                    
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
                    
                    
                ?>-->
            </div>
        </div>
        
        <?php include 'admin_footer.inc'; ?>
        
    </body>
</html>