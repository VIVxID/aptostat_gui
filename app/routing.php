<?php

// Index: CustomerFrontEnd
$app->get('/', function() use ($app) {
    $liveService = new \aptostatGui\Service\LiveService();
    $realTime = $liveService->getLiveAsArray();

    $includeBag = array(
        'realTime' => $realTime,
    );

    return $app['twig']->render('index.twig', $includeBag);
});