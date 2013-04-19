<?php

namespace aptostatGui\Service;


class MessageService
{
    public function getMessageHistoryAsArray($numOfDaysBack)
    {
        $apiService = new ApiService();
        $incidentList = $apiService->getIncidentList();

        if ($incidentList == 404) {
            return 404;
        }

        return $this->formatMessageHistoryToArray($incidentList, $numOfDaysBack);
    }

    private function formatMessageHistoryToArray($incidentList, $numOfDaysBack)
    {
        foreach ($incidentList['incidents'] as $incident) {
            if (strtotime($incident['lastMessageTimestamp']) > strtotime('-' . $numOfDaysBack . ' days')) {
                $messages[$incident['lastMessageTimestamp']] = array(
                    'messageDate' => $incident['lastMessageTimestamp'],
                    'messageText' => $incident['lastMessageText'],
                    'author' => $incident['lastMessageAuthor'],
                    'title' => $incident['title'],
                    'status' => $incident['lastStatus']
                );
            }
        }

        if (!isset($messages)) {
            return 404;
        }

        rsort($messages);
        return $messages;
    }
}