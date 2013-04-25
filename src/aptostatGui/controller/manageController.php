<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/admin/manage', function() use ($app) {

    // Reports module
    try {
        $reportService = new aptostatGui\Service\ReportService();
        $currentReports = $reportService->getReportsAsArray();
    } catch (Exception $e) {
        $currentReports = null;
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
    }

    // Incidents module
    try {
        $incidentService = new aptostatGui\Service\IncidentService();
        $currentIncidents = $incidentService->getCurrentIncidentsAsArray();
    } catch (Exception $e) {
        $currentIncidents = null;
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
    }


    $includeBag = array(
        'currentReports' => $currentReports,
        'incidentList' => $currentIncidents,
        'showHidden' => false,
    );

    return $app['twig']->render('manage.twig', $includeBag);
})
->bind('manage');

$app->post('/admin/ajax/viewReport', function(Request $paramBag) use ($app) {

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


$app->post('/admin/ajax/viewIncident', function(Request $paramBag) use ($app) {

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


$app->post('/admin/ajax/newMessage', function(Request $paramBag) use ($app) {

    try {
        $incidentId = $paramBag->request->get('incident');
        $apiService = new aptostatGui\Service\ApiService();

        $incident = $apiService->getIncidentById($incidentId);

        $includeBag = array(
            'incidentData' => $incident,
        );

        return $app['twig']->render('newMessage.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});

$app->post('/admin/ajax/executeNewMessage', function(Request $paramBag) use ($app) {

    try {
        $incidentId = $paramBag->request->get('incident');
        $messageText = $paramBag->request->get('message');
        $messageAuthor = $paramBag->request->get('author');
        $messageFlag = $paramBag->request->get('flag');

        $apiService = new aptostatGui\Service\ApiService();

        $apiService->postMessage($incidentId,$messageAuthor,$messageFlag,$messageText,false);

        $includeBag = array(
            "messageSent" => true
        );

        return $app['twig']->render('newMessage.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});