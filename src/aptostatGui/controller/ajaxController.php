<?php

use Symfony\Component\HttpFoundation\Request;

$app->match('/admin/ajax/viewReport', function(Request $paramBag) use ($app) {

    try {
        $reportId = $paramBag->request->get('report');
        $apiService = new aptostatGui\Service\ApiService();

        $report = $apiService->getReportById($reportId);

        $includeBag = array(
            'report' => $report['reports'],
        );

        return $app['twig']->render('viewReport.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});


$app->match('/admin/ajax/viewIncident', function(Request $paramBag) use ($app) {

    try {
        $incidentId = $paramBag->request->get('incident');
        $apiService = new aptostatGui\Service\ApiService();

        $incident = $apiService->getIncidentById($incidentId);

        $includeBag = array(
            'incidentData' => $incident,
        );

        return $app['twig']->render('viewIncident.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});


$app->post('/admin/ajax/listIncident', function(Request $paramBag) use ($app) {

    try {
        $apiService = new aptostatGui\Service\ApiService();
        $incidentList = $apiService->getSortedIncidentList();

        $includeBag = array(
            'incidentList' => $incidentList['incidents'],
            'showHidden' => $paramBag->request->get('showHidden'),
        );

        return $app['twig']->render('listIncident.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});

$app->post('/admin/ajax/saveNewMessage', function(Request $paramBag) use ($app) {

    try {
        $incidentId = $paramBag->request->get('incident');
        $messageText = $paramBag->request->get('message');
        $messageAuthor = $paramBag->request->get('author');
        $messageFlag = $paramBag->request->get('flag');
        $messageHidden = $paramBag->request->get('hidden');

        if ($messageHidden == "true") {
            $hidden = true;
        } else {
            $hidden = false;
        }

        $apiService = new aptostatGui\Service\ApiService();

        $apiService->postMessage($incidentId,$messageAuthor,$messageFlag,$messageText,$hidden);

        $includeBag = array(
            "messageSent" => true
        );

        return $app['twig']->render('newMessage.twig', $includeBag);
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

$app->post('/admin/ajax/editIncident', function(Request $paramBag) use ($app) {
    try {
        $incidentId = $paramBag->request->get('incident');
        $apiService = new aptostatGui\Service\ApiService();

        $incident = $apiService->getIncidentById($incidentId);

        $includeBag = array(
            'incident' => $incident['incidents'],
        );

        return $app['twig']->render('editIncident.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});

$app->post('/admin/ajax/NewIncident', function(Request $paramBag) use ($app) {

    try {
        $incidentId = $paramBag->request->get('incident');
        $messageText = $paramBag->request->get('message');
        $messageAuthor = $paramBag->request->get('author');
        $messageFlag = $paramBag->request->get('flag');
        $messageHidden = $paramBag->request->get('hidden');

        if ($messageHidden == "true") {
            $hidden = true;
        } else {
            $hidden = false;
        }

        $apiService = new aptostatGui\Service\ApiService();

        $apiService->postMessage($incidentId,$messageAuthor,$messageFlag,$messageText,$hidden);

        $includeBag = array(
            "messageSent" => true
        );

        return $app['twig']->render('newMessage.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});
