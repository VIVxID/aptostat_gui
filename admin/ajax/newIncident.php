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

<script type="text/javascript">
    $(function() {
        $(".selectable").bind("mousedown", function(event) {
            event.metaKey = true;
        }).selectable({
                tolerance: 'fit',
                stop: function() {
                    selectedReports.length = 0;
                    var i = 0;
                    $(".ui-selected", $("#accordion2")).each(function() {
                        var itemId = $(this).attr('id');
                        var item = itemId.replace("report_", "");
                        selectedReports[i] = item;
                        i++;
                    });
                }
            });
    })
</script>