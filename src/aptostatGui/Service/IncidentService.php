<?php

namespace aptostatGui\Service;


class IncidentService
{
    public function getCurrentIncidentsAsArray()
    {
        $apiService = new ApiService();
        $incidentList = $apiService->getIncidentList();

        if ($incidentList == 404) {
            return 404;
        }

        $filteredList = $this->filterByHidden($incidentList);

        foreach ($filteredList as $item) {
            $dateKeys[strtotime($item["lastMessageTimestamp"])] = $item;
        }

        arsort($dateKeys);

        foreach ($dateKeys as $item) {
            $sortedList[] = $item;
        }

        return $sortedList;
    }

    public function getHiddenIncidentsAsArray()
    {
        $apiService = new ApiService();
        $incidentList = $apiService->getIncidentList();

        if ($incidentList == 404) {
            return 404;
        }

        $filteredList = $this->filterByVisible($incidentList);

        foreach ($filteredList as $item) {
            $dateKeys[strtotime($item["lastMessageTimestamp"])] = $item;
        }

        arsort($dateKeys);

        foreach ($dateKeys as $item) {
            $sortedList[] = $item;
        }

        return $sortedList;
    }

    private function filterByHidden($incidentList)
    {
        foreach ($incidentList['incidents'] as $currentIncident) {
            if ($currentIncident["hidden"] != "false") {
                $checkList[] = $currentIncident;
            }
        }

        if (!isset($checkList)) {
            return 404;
        }

        return $checkList;
    }

    private function filterByVisible($incidentList)
    {
        foreach ($incidentList['incidents'] as $currentIncident) {
            if ($currentIncident["hidden"] != "true") {
                $checkList[] = $currentIncident;
            }
        }

        if (!isset($checkList)) {
            return 404;
        }

        return $checkList;

    }
}