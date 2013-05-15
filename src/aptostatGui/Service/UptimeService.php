<?php

namespace aptostatGui\Service;


class UptimeService
{
    public function getUptimeAsArray()
    {
        $apiService = new ApiService();
        $uptime = $apiService->getUptime();

        return $uptime;
    }
}
