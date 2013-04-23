<?php
    include '../inc/apiurl.php';

    if (isset($_POST["title"])) {


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

        $arrayData = array(
            "title" => $_POST["name"],
            "flag" => $_POST["author"],
            "flag" => $_POST["flag"],
            "visibility" => 1);

        //Curl options

        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json");

        $options = array(
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $jsonData,
        );

        //setting curl options
        curl_setopt_array($ch, $options);

        //getting results
        $result_json = curl_exec($ch);
        $result = json_decode($result_json, true);
        $incidents = $result["incident"]["incidents"];
        ksort($incidents);
    }
?>

<div id="form">
    <form name="messageForm" action="" id="messageForm">
        <br />
        <?php
            echo "New incident <br /><br />";
            echo "<fieldset>";
            echo "<legend>Data</legend>";
            echo '<table border="0">';
            echo "<tr>";
            echo "<h4>Included reports: </h4><span id='select-result'>None</span>.";
        ?>
        </tr>
        </table>
        Flag: <select name="flag" id="fieldFlag">
            <option value="CRITICAL">Critical</option>
            <option value="WARNING">Warning</option>
            <option value="RESPONDING">Responding</option>
            <option value="RESOLVED">Resolved</option>
            <option value="IGNORED">Ignored</option>
            <option value="INTERNAL">Internal</option>
        </select>
        </fieldset>
        <br />
        <fieldset>
            <legend>Message</legend>
            Author: <input name="author" type="text" length="20" id="fieldAuthor" /><br />
            <textarea id="fieldMessage" name="message" rows="10" cols="50">Update message</textarea><br />
            <input type="submit" value="Submit" id="buttonSubmit" />
        </fieldset><br />
    </form>
</div>