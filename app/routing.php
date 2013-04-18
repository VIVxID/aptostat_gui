<?php

// Index: CustomerFrontEnd
$app->get('/', function() use ($app) {
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

    return $app['twig']->render('index.twig', $includeBag);
});