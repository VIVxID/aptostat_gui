<?php

namespace aptostatGui\Service;


class MessageService
{
    public function getMessageHistoryAsArray($numOfDaysBack)
    {
        $apiService = new ApiService();
        $messageList = $apiService->getMessageList();

        return $this->formatMessageHistoryToArray($messageList, $numOfDaysBack);
    }

    private function formatMessageHistoryToArray($messageList, $numOfDaysBack)
    {
        foreach ($messageList['message'] as $message) {
            if (strtotime($message['timestamp']) > strtotime('-' . $numOfDaysBack . ' days')
            ) {
                $formattedMessageList[$message['timestamp']] = array(
                    'messageId' => $message['id'],
                    'incidentId' => $message['connectedToIncident'],
                    'messageDate' => $message['timestamp'],
                    'messageText' => $message['messageText'],
                    'author' => $message['author'],
                    'status' => $message['flag']
                );
            }
        }



        if (!isset($formattedMessageList)) {
            throw new \Exception('No messages which are public', 404);
        }


        rsort($formattedMessageList);
        return $formattedMessageList;
    }
}