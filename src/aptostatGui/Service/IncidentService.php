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

        return $filteredList;
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
}