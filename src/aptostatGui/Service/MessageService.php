<?php

namespace aptostatGui\Service;


class MessageService
{
    public function getMessageHistoryAsArray($numOfDaysBack)
    {
        $apiService = new ApiService();
        $messageList = $apiService->getMessageList();

        $incidentService = new IncidentService();
        $incidents = $incidentService->getResolvedIncidentsAsArray();

        return $this->formatMessageHistoryToArray($messageList, $numOfDaysBack, $incidents);
    }

    private function formatMessageHistoryToArray($messageList, $numOfDaysBack, $incidents)
    {
        foreach ($incidents as $incident) {

            if ($incident["lastStatus"] == "RESOLVED"){

                $formattedMessageList[$incident["id"]]["title"] = $incident["title"];
                $formattedMessageList[$incident["id"]]["id"] = $incident["id"];
                $formattedMessageList[$incident["id"]]["messages"] = array();

                foreach ($messageList['message'] as $message) {
                    if ($message["connectedToIncident"] == $incident["id"]) {
                        if (strtotime($incident['lastMessageTimestamp']) > strtotime('-' . $numOfDaysBack . ' days')) {

                            $formattedMessageList[$incident['id']]["messages"][] = array(
                                'messageId' => $message['id'],
                                'messageDate' => $message['timestamp'],
                                'messageText' => $message['messageText'],
                                'author' => $message['author'],
                                'status' => $message['flag']
                            );
                        }
                    }
                }
            }
        }


        if (!isset($formattedMessageList)) {
            throw new \Exception('No messages which are public', 404);
        }


        rsort($formattedMessageList);
        return $formattedMessageList;
    }
}