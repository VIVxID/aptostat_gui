<?php

$app->get('/', function() use ($app) {

    // Real-time status module
    try {
        $liveService = new aptostatGui\Service\LiveService();
        $realTime = $liveService->getLiveAsArray();
    } catch (Exception $e) {
        $realTime = null;
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
    }

    // Last 7 days uptime table
    try {
        $uptimeService = new \aptostatGui\Service\UptimeService();
        $uptime = $uptimeService->getUptimeAsArray();
    } catch (Exception $e) {
        $uptime = null;
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
    }

    // Last messages past 3 days module
    try {
        $messageService = new \aptostatGui\Service\MessageService();
        $messageHistory = $messageService->getMessageHistoryAsArray(3);
    } catch (Exception $e) {
        $messageHistory = null;
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
    }

    // Current incidents module
    try {
        $incidentService = new aptostatGui\Service\IncidentService();
        $currentIncidents = $incidentService->getCurrentIncidentsAsArray();
    } catch (Exception $e) {
        $currentIncidents = null;
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
    }

    $includeBag = array(
        'realTime' => $realTime,
        'uptime' => $uptime,
        'messageHistory' => $messageHistory,
        'currentIncidents' => $currentIncidents,
    );

    return $app['twig']->render('customerIndex.twig', $includeBag);
})
->bind('index');