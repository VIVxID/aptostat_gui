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
                <img id="logo" src="img/logo.png" />
            </div>
        </header>
        <div class="container_12">
            
            <!-- Sist oppdaterte pågående hendelse -->
            
            <div class="grid_4 prefix_1 listbox">
                <?php 
                    //SQL, endring i group
                    
                    //JSON
                    $json_url = "http://apto.vlab.iu.hio.no/api/report/39";
                    
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
                    
                   	print "Report ID: " . $result["report"]["idReport"] . "<br/>";
			print "Timestamp: " . $result["report"]["timestamp"] . "<br/>";
			print "Error message: " . $result["report"]["errorMessage"] . "<br/>";
			print "Czech type: " . $result["report"]["checkType"] . "<br/>";
			print "Source name: " . $result["report"]["sourceName"] . "<br/>";
			print "Service name: " . $result["report"]["serviceName"] . "<br/>";
			print "Flag: " . $result["report"]["flag"] . "<br/>";
					
                 ?>
            </div>
            
            <!-- Statuspanel -->
            
        </div>
        
        <!--FOOTER-->
        <footer id="footer">
            <div class="container_12">
                <div class="grid_2 suffix_2">Kontakt</div>
                <div class="grid_2 suffix_2">Support</div>
                <div class="grid_2">
                    <a href="http://twitter.com/aptomaops"><img src="img/twitter_button.png" /></a>
                </div>
            </div>
        </footer>

        </body>
</html>