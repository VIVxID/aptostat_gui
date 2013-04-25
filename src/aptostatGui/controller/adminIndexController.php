<?php

$app->get('/admin', function() use ($app) {

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

    $token = $app['security']->getToken();

    $includeBag = array(
        'realTime' => $realTime,
        'uptime' => $uptime,
        'messageHistory' => $messageHistory,
        'currentIncidents' => $currentIncidents,
        'username' => $token->getUserName(),
    );

    return $app['twig']->render('adminIndex.twig', $includeBag);
})
->bind('admin');