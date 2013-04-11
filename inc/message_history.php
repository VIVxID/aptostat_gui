<?php

$messages = array();
$curl = curl_init();
$options = array(
    CURLOPT_URL => APIURL . "report",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET"
);

curl_setopt_array($curl, $options);

$response = json_decode(curl_exec($curl), true);

$checkList = $response["report"]["incidents"];

foreach ($checkList as $incident) {

    if (strtotime($incident["lastMessage"]["messageDate"]) > time()-259200) {

        $messages[$incident["lastMessage"]["messageDate"]] = array(
            "messageDate" => $incident["lastMessage"]["messageDate"],
            "messageText" => $incident["lastMessage"]["messageText"],
            "author" => $incident["lastMessage"]["messageAuthor"],
            "title" => $incident["incidentTitle"],
            "status" => $incident["lastMessage"]["status"]
        );
    }
}

rsort($messages);

if (empty($messages)) {

    echo '<div id="current_box" class="no_issues">';
    echo "<p class='all-clear'>No new messages.</p>";

} else {

    echo "<div id='current_box' class='error'>";
    echo "<h3>Message history - Last 3 days</h3>";
    echo "<table border='0' class='current_box_table'>";

    foreach ($messages as $messageDate => $message) {

        echo "<tr>";
        echo "<td><hr /></td>"
        echo "<td class='table-left'>".$message["title"]."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-left'>Last update:</td>";
        echo "<td class='table-right'>".$message["messageDate"]."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-left'>".$message["messageText"]."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-right'> - ".$message["author"]."</td>";
        echo "</tr>";

    }

    echo "</table>";

}

echo "</div>";