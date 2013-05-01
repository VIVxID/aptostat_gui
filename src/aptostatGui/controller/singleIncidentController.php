<?php

$app->get('/incident/{id}', function($id) use ($app) {
    try {
        $apiService = new aptostatGui\Service\ApiService();
        $incident = $apiService->getIncidentById($id);
        $connectedReports = $apiService->getConnectedReports($id);

        $includeBag = array(
            'incident' => $incident['incidents'],
            'connectedReports' => $connectedReports['reports'],
        );

        return $app['twig']->render('singleIncident.twig', $includeBag);

    } catch (Exception $e) {
        $app['monolog']->addDebug($e->getMessage() . ' in file ' . $e->getFile() . ' line ' . $e->getLine());
        return $e->getMessage();
    }
})
    ->bind('singleIncident');