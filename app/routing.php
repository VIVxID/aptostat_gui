<?php

// Index: CustomerFrontEnd
$app->get('/', function() use ($app) {
    $liveService = new \aptostatGui\Service\LiveService();
    $realTime = $liveService->getLiveAsArray();

    $uptimeService = new \aptostatGui\Service\UptimeService();
    $uptime = $uptimeService->getUptimeAsArray();

    $includeBag = array(
        'realTime' => $realTime,
        'uptime' => $uptime
    );

    return $app['twig']->render('index.twig', $includeBag);
});