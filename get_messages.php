<!DOCTYPE html>
<html>

    <?php
        include 'html_head.inc';
        include 'propel_bootstrap.inc';
    ?>
    
    <body>

        <div id="background">
        
        <!--HEADER-->
        
        <header id="header">
            <div id="header-content">
                <a href="http://apto.vlab.iu.hio.no/group_reports.php"><img id="logo" src="img/logo.png" /></a>
            </div>
        </header>
        
     
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
          
          
        
        <?php include 'admin_footer.inc'; ?>
        
    </body>
</html>