<?php

// Index: CustomerFrontEnd
$app->get('/', function() use ($app) {
    $liveService = new \aptostatGui\Service\LiveService();
    $realTime = $liveService->getLiveAsArray();

    $messageService = new \aptostatGui\Service\MessageService();
    $messageHistory = $messageService->getMessageHistoryAsArray();



    $includeBag = array(
        'realTime' => $realTime,
        'messageHistory' => $messageHistory,
    );

    return $app['twig']->render('index.twig', $includeBag);
});