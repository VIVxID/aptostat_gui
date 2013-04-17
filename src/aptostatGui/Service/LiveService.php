<?php

namespace aptostatGui\Service;


class LiveService
{
    public function getLiveAsArray()
    {
        $liveData = $this->fetchDataFromApi();

        if (is_null($liveData)) {
            throw new \Exception('Could not fetch real-time data', 500);
        }

        foreach ($liveData as $service => $state) {
            $explodedServiceName = explode(" ",$service);
            $groupedLiveStatus[$explodedServiceName[0]][$explodedServiceName[1]] = $state;
        }

        $liveStatusAsArray = $this->setGroupState($groupedLiveStatus);

        return $liveStatusAsArray;
    }

    private function fetchDataFromApi()
    {
        $curl = curl_init();

        $options = array(
            CURLOPT_URL => APIURL . "api/live",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET"
        );

        curl_setopt_array($curl, $options);

        $result_json = curl_exec($curl);
        $LiveData = json_decode($result_json, true);
        ksort($LiveData);

        return $LiveData;
    }

    private function setGroupState($groupedLiveStatus)
    {
        $list = $groupedLiveStatus;

        foreach ($list as $groupName => $serviceGroups) {
            $groupState = 'up';
            foreach ($serviceGroups as $service) {
                if ($groupState != 'down'
                    && $service == 'warning'
                ) {
                    $groupState = 'warning';
                }
                if ($service == 'down') {
                    $groupState = 'down';
                }
            }
            $list[$groupName]['groupState'] = $groupState;

        }
        return $list;
    }
}
