<?php

namespace aptostatGui\Service;


class ReportService
{

    public function getReportsAsArray()
    {

        $apiService = new ApiService();
        $reports = $apiService->getReportList();

        foreach ($reports["reports"] as $report) {

            if ($report["flag"] != "RESOLVED") {
                $groups[$report["host"]][] = $report;
            }

        }
        ksort($groups);

        return $groups;

    }

}
