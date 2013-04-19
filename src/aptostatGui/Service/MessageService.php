<?php

namespace aptostatGui\Service;


class MessageService
{
    public function getMessageHistoryAsArray()
    {
        $incidentList = $this->getDataFromApi();

        if ($incidentList == 404) {
            return 404;
        }

        return $this->formatMessageHistoryToArray($incidentList);
    }

    private function getDataFromApi()
    {
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . "api/incident",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
        );

        curl_setopt_array($curl, $options);

        $result = json_decode(curl_exec($curl), true);

        if (isset($result['error'])) {
            if ($result['error']['statusCode'] == 404) {
                return 404;
            } else {
                throw new \Exception($result['error']['errorMessage'], $result['error']['statusCode']);
            }
        }
        return $result;
    }

    private function formatMessageHistoryToArray($incidentList)
    {
        foreach ($incidentList["incidents"] as $incident) {

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
        return $messages;
    }
}