<!DOCTYPE html>
<html>
    <?php
		include 'inc/html_head.php';
        include 'inc/apiurl.php';
	?>
    <body>
        
        <!--HEADER-->
        
        <header id="header">
            <div id="header-content">
                <a href="http://apto.vlab.iu.hio.no/admin_front.php"><img id="logo" src="img/logo.png" /></a>
            </div>
        </header>
        
        <?php
                //API URL Report
                $json_url = APIURL . "report";
                
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
                $groups = $result["report"]["groups"];
                ksort($groups);
                
                
                
                //API URL Incident
                 $json_url = APIURL . "incident";
                
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
                $incidents = $result["incident"]["incidents"];
                ksort($incidents);
            ?>
            