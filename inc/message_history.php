<?php

$messages = array();
$curl = curl_init();
$options = array(
    CURLOPT_URL => APIURL . "incident",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET"
);

curl_setopt_array($curl, $options);

$response = json_decode(curl_exec($curl), true);

$checkList = $response["incidents"];

foreach ($checkList as $incident) {

    if (strtotime($incident["lastMessageTimestamp"]) > time()-259200) {

        $messages[$incident["lastMessageTimestamp"]] = array(
            "messageDate" => $incident["lastMessageTimestamp"],
            "messageText" => $incident["lastMessageText"],
            "author" => $incident["lastMessageAuthor"],
            "title" => $incident["title"],
            "status" => $incident["lastStatus"]
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
        echo "<td><hr /></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-left'><h5>".$message["title"]."</h5></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-left'><h5>Last update: ".$message["messageDate"]."</h5></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-left'>".$message["messageText"]."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='table-left'> - ".$message["author"]."</td>";
        echo "</tr>";

    }

    echo "</table>";

}

echo "</div>";