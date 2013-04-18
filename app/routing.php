<?php

// Index: CustomerFrontEnd
$app->get('/', function() use ($app) {
    $liveService = new aptostatGui\Service\LiveService();
    $realTime = $liveService->getLiveAsArray();

    $uptimeService = new \aptostatGui\Service\UptimeService();
    $uptime = $uptimeService->getUptimeAsArray();

    $messageService = new \aptostatGui\Service\MessageService();
    $messageHistory = $messageService->getMessageHistoryAsArray();

    $incidentService = new aptostatGui\Service\IncidentService();
    $currentIncidents = $incidentService->getCurrentIncidentsAsArray();

    $includeBag = array(
        'realTime' => $realTime,
        'uptime' => $uptime,
        'messageHistory' => $messageHistory,
        'currentIncidents' => $currentIncidents,
    );

    return $app['twig']->render('customerIndex.twig', $includeBag);
});


$app->get('/admin', function() use ($app) {
    $token = $app['security']->getToken();
    return 'Welcome ' . $token->getUserName();
});

// Index: CustomerFrontEnd
/*$app->get('/admin', function() use ($app) {

    $token = $app['security']->getToken();
    var_dump($token);
    $liveService = new \aptostatGui\Service\LiveService();
    $realTime = $liveService->getLiveAsArray();

    $uptimeService = new \aptostatGui\Service\UptimeService();
    $uptime = $uptimeService->getUptimeAsArray();

    $messageService = new \aptostatGui\Service\MessageService();
    $messageHistory = $messageService->getMessageHistoryAsArray();

    $includeBag = array(
        'realTime' => $realTime,
        'uptime' => $uptime,
        'messageHistory' => $messageHistory,
    );

    return $app['twig']->render('adminIndex.twig', $includeBag);
});*/