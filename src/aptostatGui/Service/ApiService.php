<?php

namespace aptostatGui\Service;


use Symfony\Component\Security\Acl\Exception\Exception;

class ApiService
{
    public function getReportList()
    {
        return $this->getDataFromApi('api/report');
    }

    public function getReportById($id)
    {
        return $this->getDataFromApi('api/report/' . $id);
    }

    public function getIncidentList()
    {
        return $this->getDataFromApi('api/incident');
    }

    public function getSortedIncidentList()
    {
        $list = $this->getDataFromApi('api/incident');
        foreach ($list["incidents"] as $item) {
            $dateKeys[strtotime($item["lastMessageTimestamp"])] = $item;
        }

        arsort($dateKeys);

        foreach ($dateKeys as $item) {
            $out["incidents"][] = $item;
        }

        return $out;

    }

    public function getIncidentById($id)
    {
        return $this->getDataFromApi('api/incident/' . $id);
    }

    public function getMessageList()
    {
        return $this->getDataFromApi('api/message?showHidden=1');
    }

    public function getMessageById($id)
    {
        return $this->getDataFromApi('api/message' . $id);
    }

    public function getUptime()
    {
        return $this->getDataFromApi('api/uptime');
    }

    public function getLive()
    {
        return $this->getDataFromApi('api/live');
    }

    public function postIncident($title, $author, $flag, $messageText, $reports, $hidden = false)
    {
        $postDataAsArray = array(
            'title' => $title,
            'author' => $author,
            'flag' => $flag,
            'messageText' => $messageText,
            'reports' => $reports,
            'hidden' => $hidden,
        );

        return $this->postDataToApi('api/incident', $postDataAsArray);
    }

    public function postMessage($incidentId, $author, $flag, $messageText, $hidden = false)
    {
        $postDataAsArray = array(
            'author' => $author,
            'flag' => $flag,
            'messageText' => $messageText,
            'hidden' => $hidden,
        );

        $subUrl = 'api/incident/' . $incidentId . '/message';

        return $this->postDataToApi($subUrl, $postDataAsArray);
    }

    public function modifyMessageById($messageId, $author = null, $flag = null, $messageText = null, $hidden = null)
    {
        if (!is_null($author)) {
            $putDataAsArray['author'] = $author;
        }

        if (!is_null($flag)) {
            $putDataAsArray['flag'] = $flag;
        }

        if (!is_null($messageText)) {
            $putDataAsArray['messageText'] = $messageText;
        }

        if (!is_null($hidden)) {
            $putDataAsArray['hidden'] = $hidden;
        }

        if (!isset($putDataAsArray)) {
            throw new Exception('No valid parameters has been passed', 400);
        }

        $subUrl = 'api/message/' . $messageId;

        return $this->putDataToApi($subUrl, $putDataAsArray);
    }

    public function modifyReportById($reportId, $flag = null, $hidden = null)
    {

        if (!is_null($flag)) {
            $putDataAsArray['flag'] = $flag;
        }

        if (!is_null($hidden)) {
            $putDataAsArray['hidden'] = $hidden;
        }

        if (!isset($putDataAsArray)) {
            throw new Exception('No valid parameters has been passed', 400);
        }

        $subUrl = 'api/report/' . $reportId;

        return $this->putDataToApi($subUrl, $putDataAsArray);
    }

    public function addReportToIncidentById($incidentId, $reports)
    {
        $putDataAsArray['reportAction'] = 'add';
        $putDataAsArray['reports'] = $reports;

        $subUrl = 'api/incident/' . $incidentId;

        return $this->putDataToApi($subUrl, $putDataAsArray);
    }

    public function removeReportToIncidentById($incidentId, $reports)
    {
        $putDataAsArray['reportAction'] = 'remove';
        $putDataAsArray['reports'] = $reports;

        $subUrl = 'api/incident/' . $incidentId;

        return $this->putDataToApi($subUrl, $putDataAsArray);
    }

    public function modifyIncidentTitleById($incidentId, $title)
    {
        $putDataAsArray['title'] = $title;
        $subUrl = 'api/incident/' . $incidentId;

        return $this->putDataToApi($subUrl, $putDataAsArray);
    }

    private function getDataFromApi($subUrl)
    {
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . $subUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        );

        curl_setopt_array($curl, $options);

        $result = json_decode(curl_exec($curl), true);

        if (is_null($result)) {
            throw new \Exception('Failed to connect to API server', 500);
        }

        if (isset($result['error'])) {
            throw new \Exception($result['error']['errorMessage'], $result['error']['statusCode']);
        }
        return $result;
    }

    private function postDataToApi($subUrl, $postDataAsArray)
    {
        $postDataAsJson = json_encode($postDataAsArray);

        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . $subUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postDataAsJson,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postDataAsJson),
            ),
        );

        curl_setopt_array($curl, $options);

        $response = json_decode(curl_exec($curl), true);

        if (is_null($response)) {
            throw new \Exception('Failed to connect to API server', 500);
        }

        if (isset($response['error'])) {
            throw new \Exception($response['error']['errorMessage'], $response['error']['statusCode']);
        }
        return $response;
    }

    private function putDataToApi($subUrl, $putDataAsArray)
    {
        $putDataAsJson = json_encode($putDataAsArray);

        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . $subUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $putDataAsJson,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($putDataAsJson),
            ),
        );

        curl_setopt_array($curl, $options);

        $response = json_decode(curl_exec($curl), true);

        if (is_null($response)) {
            throw new \Exception('Failed to connect to API server', 500);
        }

        if (isset($response['error'])) {
            throw new \Exception($response['error']['errorMessage'], $response['error']['statusCode']);
        }
        return $response;
    }
}