<?php

// Index: CustomerFrontEnd
$app->get('/', function() use ($app) {
    $liveService = new aptostatGui\Service\LiveService();
    $uptimeService = new \aptostatGui\Service\UptimeService();
    $messageService = new \aptostatGui\Service\MessageService();
    $incidentService = new aptostatGui\Service\IncidentService();

    $includeBag = array(
        'realTime' => $liveService->getLiveAsArray(),
        'uptime' => $uptimeService->getUptimeAsArray(),
        'messageHistory' => $messageService->getMessageHistoryAsArray(3),
        'currentIncidents' => $incidentService->getCurrentIncidentsAsArray(),
    );

    return $app['twig']->render('customerIndex.twig', $includeBag);
});

$app->get('/admin', function() use ($app) {
    $token = $app['security']->getToken();

    $liveService = new \aptostatGui\Service\LiveService();
    $realTime = $liveService->getLiveAsArray();

    $uptimeService = new \aptostatGui\Service\UptimeService();
    $uptime = $uptimeService->getUptimeAsArray();

    $messageService = new \aptostatGui\Service\MessageService();
    $messageHistory = $messageService->getMessageHistoryAsArray(3);

    $incidentService = new aptostatGui\Service\IncidentService();
    $currentIncidents = $incidentService->getCurrentIncidentsAsArray();

    $includeBag = array(
        'realTime' => $realTime,
        'uptime' => $uptime,
        'messageHistory' => $messageHistory,
        'currentIncidents' => $currentIncidents,
        'username' => $token->getUserName(),
    );

    return $app['twig']->render('adminIndex.twig', $includeBag);
});