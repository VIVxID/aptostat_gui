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

    public function getSingleReportAsArray($id)
    {

        $apiService = new ApiService();
        $report = $apiService->getReportById($id);

        return $report;

    }

}
