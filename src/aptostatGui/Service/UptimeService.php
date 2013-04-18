<?php

namespace aptostatGui\Service;


class UptimeService
{
    public function getUptimeAsArray()
    {
        $liveData = $this->fetchDataFromApi();
        $uptimeStatusAsArray = array();

        if (is_null($liveData)) {
            throw new \Exception('Could not fetch real-time data', 500);
        }

        foreach ($liveData as $hostname => $errors) {
            foreach ($errors as $timestamp => $downtime) {

                $uptimeStatusAsArray[$hostname][$timestamp] = array_sum($downtime);

            }
        }

        return $uptimeStatusAsArray;
    }

    private function fetchDataFromApi()
    {
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => APIURL . "api/uptime",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
        );

        curl_setopt_array($curl, $options);
        $uptimeData = json_decode(curl_exec($curl),true);
        ksort($uptimeData);

        return $uptimeData;
    }
}
