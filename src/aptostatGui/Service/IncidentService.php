<?php

namespace aptostatGui\Service;


class IncidentService
{

    public function getUnresolvedIncidentsAsArray()
    {
        $apiService = new ApiService();
        $incidentList = $apiService->getIncidentList();
        $sortedList = array();

        if ($incidentList == 404) {
            return 404;
        }

        $filteredList = $this->filterByHidden($incidentList);

        foreach ($filteredList as $item) {
            if ($item["lastStatus"] != "RESOLVED" && $item["lastStatus"] != "INTERNAL" && $item["lastStatus"] != "IGNORED"){
                $dateKeys[strtotime($item["lastMessageTimestamp"])] = $item;
            }
        }

        if (isset($dateKeys)) {

            arsort($dateKeys);

            foreach ($dateKeys as $item) {
                $sortedList[] = $item;
            }

        }

        return $sortedList;
    }

    public function getResolvedIncidentsAsArray()
    {
        $apiService = new ApiService();
        $incidentList = $apiService->getIncidentList();
        $sortedList = array();

        if ($incidentList == 404) {
            return 404;
        }

        $filteredList = $this->filterByHidden($incidentList);

        foreach ($filteredList as $item) {
            if ($item["lastStatus"] == "RESOLVED"){
                $dateKeys[strtotime($item["lastMessageTimestamp"])] = $item;
            }
        }

        if (isset($dateKeys)) {

            arsort($dateKeys);

            foreach ($dateKeys as $item) {
                $sortedList[] = $item;
            }

        }

        return $sortedList;
    }

    private function filterByHidden($incidentList)
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
