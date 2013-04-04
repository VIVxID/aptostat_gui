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
        
        <div class="container_12">
            <h3 class="grid_1 suffix_4">Reports</h3>
            <h3 class="grid_2">Details</h3>
        </div>
        <div class="container_12">
            <div class="grid_5 listbox">
                <input type="checkbox"> Report 1 </input> <br />
                <input type="checkbox"> Report 2 </input> <br />
                <input type="checkbox"> Report 3 </input> <br />
                <input type="checkbox"> Report 4 </input> <br />
                <input type="checkbox"> Report 5 </input> <br />
                <input type="checkbox"> Report 6 </input> <br />
                <input type="checkbox"> Report 7 </input> <br />
                <input type="checkbox"> Report 8 </input> <br />
                <input type="checkbox"> Report 9 </input> <br />
                <input type="checkbox"> Report 10 </input> <br />
            </div>
            <div class="grid_6 listbox">
                <?php 
                    //Uthenting av report
                    
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
                    
                    print "Report ID: " . $result["report"]["idReport"] . "<br />";
                    print "Timestamp: " . $result["report"]["timestamp"] . "<br />";
                    print "Czech type: " . $result["report"]["checkType"] . "<br />";
                    print "Source name: " . $result["report"]["sourceName"] . "<br />";
                    print "Service name: " . $result["report"]["serviceName"] . "<br />";
                    print "Flag: " . $result["report"]["flag"] . "<br /><br />";
					print "Error message:<br />" . $result["report"]["errorMessage"];
                ?>
            </div>
        </div>
        
        <div class="container_12">
            <div class="grid_1 suffix_4">
                <input type="submit" value="Show this report" />
            </div>
            <div class="grid_1">
                <input type="submit" value="Group this report" />
            </div>
        </div>
        
        <div class="container_12">
            <h3 class="grid_2 suffix_2">To be grouped</h3>
            <h3 class="grid_2 suffix_2">In current group</h3>
            <h3 class="grid_2">Groups</h3>
        </div>    
        <div class="container_12">
            <div class="grid_4 listbox">
                <input type="checkbox"> Report 1 </input> <br />
                <input type="checkbox"> Report 2 </input> <br />
                <input type="checkbox"> Report 3 </input> <br />
            </div>
            <div class="grid_4 listbox">
                <input type="checkbox"> Report 1 </input>
            </div>
            <div class="grid_3 listbox">
                <input type="radio"> Report 1 </input> <br />
                <input type="radio"> Report 2 </input> <br />
                <input type="radio"> Report 3 </input> <br />
            </div>
            
        </div>

        <div class="container_12">
            <div class="grid_1">
                <input type="submit" value="Add to selected group" />
                <input type="submit" value="Remove" />
                <input type="submit" value="Clear all" />
            </div>
            
            <div class="grid_2 prefix_3">
                <input type="submit" value="Remove from group" />
            </div>
            
            <div class="grid_2 prefix_2">
                <input type="submit" value="Load group" />
                <input type="submit" value="Dissolve group" />
            </div>
        </div>
        
        <?php include 'admin_footer.inc'; ?>
        
    </body>
</html>