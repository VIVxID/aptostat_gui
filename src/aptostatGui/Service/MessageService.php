<?php

namespace aptostatGui\Service;


class MessageService
{
    public function getMessageHistoryAsArray($numOfDaysBack)
    {
        $apiService = new ApiService();
        $incidentList = $apiService->getIncidentList();

        return $this->formatMessageHistoryToArray($incidentList, $numOfDaysBack);
    }

    private function formatMessageHistoryToArray($incidentList, $numOfDaysBack)
    {
        foreach ($incidentList['incidents'] as $incident) {
            if (strtotime($incident['lastMessageTimestamp']) > strtotime('-' . $numOfDaysBack . ' days')
                && !$incident['hidden']
            ) {
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
            throw new \Exception('No messages which are public', 404);
        }

        rsort($messages);
        return $messages;
    }
}