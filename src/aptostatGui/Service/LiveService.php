<?php

namespace aptostatGui\Service;


class LiveService
{
    public function getLiveAsArray()
    {
        $liveData = $this->fetchDataFromApi();

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

        $result = json_decode(curl_exec($curl), true);

        if (isset($result['error'])) {
            throw new \Exception($result['error']['errorMessage'], $result['error']['statusCode']);
        }

        ksort($result);

        return $result;
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
