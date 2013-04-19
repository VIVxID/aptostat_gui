<?php

namespace aptostatGui\Service;


class UptimeService
{
    public function getUptimeAsArray()
    {
        $apiService = new ApiService();
        $uptime = $apiService->getUptime();

        foreach ($uptime as $hostname => $errors) {
            foreach ($errors as $timestamp => $downtime) {

                $uptimeStatusAsArray[$hostname][$timestamp] = array_sum($downtime);

            }
        }

        return $uptimeStatusAsArray;
    }
}
