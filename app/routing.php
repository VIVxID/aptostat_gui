<?php

// Index: CustomerFrontEnd
$app->get('/', function() use ($app) {
    $liveService = new \aptostatGui\Service\LiveService();
    $realTime = $liveService->getLiveAsArray();
    return $app['twig']->render('index.twig', array('realTime' => $realTime));
});