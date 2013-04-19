<?php

namespace aptostatGui\Service;


class LiveService
{
    public function getLiveAsArray()
    {
        $apiService = new ApiService();
        $liveData = $apiService->getLive();

        foreach ($liveData as $service => $state) {
            $explodedServiceName = explode(" ",$service);
            $groupedLiveStatus[$explodedServiceName[0]][$explodedServiceName[1]] = $state;
        }

        $liveStatusAsArray = $this->setGroupState($groupedLiveStatus);

        return $liveStatusAsArray;
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
