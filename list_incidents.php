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
        
        <?php
            //API URL
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
            $incidents = $result["report"]["incidents"];
            ksort($incidents);
        ?>
        
        <div class="container_12 content_box">
            <div class="list_content" id="incidentbox_list">
                <div class="groupbox_heading">
                    Incidents
                </div>
                <div class="groupbox_wrapper">
                    <ul>
                        <?php
                            foreach($incidents as $incident => $array) {
                                $date = $incident["timestamp"];
                                $title = $incident["title"];
                                print "<li>Incident $incident - $date - $title</li>\r\n";
                            }
                        ?>
                    </ul>
                </div>
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
                <div class="groupbox_heading">
                    Details
                </div>
                <div class="groupbox_wrapper">
                    <div class="front_messagebox">
                        <table border="0">
                             <tr>
                                <td>ID:</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>Startdate:</td>
                                <td>2013-03-12</td>
                            </tr>
                            <tr>
                                <td>Included reports:</td>
                                <td>38, 39, 40</td>
                            </tr>
                            <tr>
                                <td>Services:</td>
                                <td>DrVideo API</td>
                            </tr>
                            <tr>
                                <td>Status:</td>
                                <td>Critical</td>
                            </tr>
                        </table>
                        <hr />
                        Message from Support:<br />
                        This is a test message to test this box!<br />
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam molestie ullamcorper rutrum. Nunc sit amet nunc a quam viverra blandit eleifend eget urna. Duis adipiscing fringilla rhoncus. Suspendisse vitae purus sed nisl euismod consectetur eu ut neque. Nunc vel nulla eget lectus volutpat adipiscing. Quisque mollis magna lectus. Maecenas quis risus metus. Vestibulum fermentum ligula varius elit suscipit quis accumsan turpis mollis. In hendrerit aliquet magna nec ultricies. Nullam eget nunc ac sem accumsan imperdiet. Nam tellus lacus, imperdiet lacinia scelerisque id, mollis id enim. Mauris lobortis erat ut ipsum molestie suscipit vel eget magna. 
                        <hr />
                        <div class="author">
                            Author: Shakespeare
                        </div>
                        <div class="edit">
                            <a href="edit_incident.php">Edit incident</a>
                        </div>
                        <br/>
                    </div>
                   
                    <div class="front_messagebox">
                        <table border="0">
                            <tr>
                                <td>Id Incident:</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>Startdate:</td>
                                <td>2013-03-12</td>
                            </tr>
                            <tr>
                                <td>Services:</td>
                                <td>DrVideo API</td>
                            </tr>
                            <tr>
                                <td>Status:</td>
                                <td>Resolved</td>
                            </tr>
                        </table>
                        <hr />
                        Message from Support:<br />
                        This is yet another test message to test this box!<br />
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam molestie ullamcorper rutrum. Nunc sit amet nunc a quam viverra blandit    eleifend eget urna. Duis adipiscing fringilla rhoncus. Suspendisse vitae purus sed nisl euismod consectetur eu ut neque. Nunc vel nulla eget lectus volutpat adipiscing. Quisque mollis magna lectus. Maecenas quis risus metus. Vestibulum fermentum ligula varius elit suscipit quis accumsan turpis mollis. In hendrerit aliquet magna nec ultricies. Nullam eget nunc ac sem accumsan imperdiet. Nam tellus lacus, imperdiet lacinia scelerisque id, mollis id enim. Mauris lobortis erat ut ipsum molestie suscipit vel eget magna.
                            <hr />
                            <div class="author">
                                Author: Shakespeare
                            </div>
                            <div class="edit">
                                <a href="edit_incident.php">Edit incident</a>
                            </div>
                            <br/>
                    </div>
                </div>
                <div class="list_content_menu_fat">
                    <a href="http://apto.vlab.iu.hio.no/edit_incident.php" style="float: right; margin-right: 5px; margin-top: 10px;">Make new message</a>
                </div>
            </div>
        </div>
       
        
        <?php include 'admin_footer.inc'; ?>
        
    </body>
</html>