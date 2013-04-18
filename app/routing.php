<?php

// Index: CustomerFrontEnd
$app->get('/', function() use ($app) {
    $liveService = new aptostatGui\Service\LiveService();
    $realTime = $liveService->getLiveAsArray();

    $messageService = new aptostatGui\Service\MessageService();
    $messageHistory = $messageService->getMessageHistoryAsArray();

    $incidentService = new aptostatGui\Service\IncidentService();
    $currentIncidents = array('mah' => 'bah');
    //$currentIncidents = $incidentService->getCurrentIncidentAsArray();

    $includeBag = array(
        'realTime' => $realTime,
        'messageHistory' => $messageHistory,
        'currentIncidents' => $currentIncidents,
    );

    return $app['twig']->render('index.twig', $includeBag);
});