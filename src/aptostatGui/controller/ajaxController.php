<?php

use Symfony\Component\HttpFoundation\Request;

$app->match('/admin/ajax/viewReport', function(Request $paramBag) use ($app) {

    try {
        $reportId = $paramBag->request->get('report');
        $reportService = new aptostatGui\Service\ReportService();

        $report = $reportService->getSingleReportAsArray($reportId);

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

$app->post('/admin/ajax/saveEditMessage', function(Request $paramBag) use ($app) {

    try {
        $messageId = $paramBag->request->get('messageId');
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

        $apiService->modifyMessageById($messageId,$messageAuthor,$messageFlag,$messageText,$messageHidden);

        $includeBag = array(
            "messageEdited" => true
        );

        return $app['twig']->render('editMessage.twig', $includeBag);
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

$app->post('/admin/ajax/editMessage', function(Request $paramBag) use ($app) {
    try {
        $incidentId = $paramBag->request->get('incident');
        $apiService = new aptostatGui\Service\ApiService();

        $incident = $apiService->getIncidentById($incidentId);

        $includeBag = array(
            'incident' => $incident['incidents'],
        );

        return $app['twig']->render('editMessage.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});

$app->post('/admin/ajax/saveNewIncident', function(Request $paramBag) use ($app) {

    try {
        $incidentTitle = $paramBag->request->get('title');
        $messageText = $paramBag->request->get('message');
        $messageAuthor = $paramBag->request->get('author');
        $messageFlag = $paramBag->request->get('flag');
        $incidentReports = $paramBag->request->get('reports');
        $messageHidden = $paramBag->request->get('hidden');

        if ($messageHidden == "true") {
            $hidden = true;
        } else {
            $hidden = false;
        }

        $apiService = new aptostatGui\Service\ApiService();

        $app['monolog']->addDebug('Calling postIncident method...');
        $apiService->postIncident($incidentTitle,$messageAuthor,$messageFlag,$messageText,$incidentReports,$hidden);

        $app['monolog']->addDebug('postIncident method successfully passed');

        $includeBag = array(
            "incidentCreated" => true,
        );

        $app['monolog']->addDebug('About to render out newIncident.twig');

        return "";
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return $app->json("Fail", 400);
    }
});

$app->post('/admin/ajax/editTitle', function(Request $paramBag) use ($app) {

    try {
        $incidentId = $paramBag->request->get('incident');
        $title = $paramBag->request->get('title');

        $apiService = new aptostatGui\Service\ApiService();

        $apiService->modifyIncidentTitleById($incidentId, $title);

        $includeBag = array(
            "titleEdited" => true
        );

        return $app['twig']->render('editTitle.twig', $includeBag);
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

$app->match('/admin/ajax/newIncidentResponse', function(Request $paramBag) use ($app) {
    try {
        if ($paramBag->request->get('status') == 400) {
            $response = false;
        } else {
            $response = true;
        }

        $includeBag = array(
            'status' => $response,
        );

        return $app['twig']->render('newIncidentResponse.twig', $includeBag);
    } catch (\Exception $e) {
        return "Something went wrong. Please try again.";
    }
});

$app->post('/admin/ajax/modifyReportConnectedToIncident', function(Request $paramBag) use ($app) {
    try {
        $incidentId = $paramBag->request->get('incidentId');
        $oldList = $paramBag->request->get('oldList');
        $newList = $paramBag->request->get('newList');

        $apiService = new aptostatGui\Service\ApiService();

        if (!empty($oldList)) {
            $apiService->removeReportToIncidentById($incidentId, $oldList);
        }

        $apiService->addReportToIncidentById($incidentId, $newList);

        return true;
    } catch (\Exception $e) {
        $app['monolog']->addDebug($e->getMessage());
        return "Something went wrong. Please try again.";
    }
});