<?php

namespace aptostatGui\Service;


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

    public function getIncidentById($id)
    {
        return $this->getDataFromApi('api/incident/' . $id);
    }

    public function getUptime()
    {
        return $this->getDataFromApi('api/uptime');
    }

    public function getLive()
    {
        return $this->getDataFromApi('api/live');
    }

    private function getDataFromApi($subUrl)
    {
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . $subUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
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
}