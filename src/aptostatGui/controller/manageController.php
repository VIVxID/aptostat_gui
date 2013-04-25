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

$app->match('/admin/newIncident', function(Request $paramBag) use ($app) {

    try {

        /*
         *
         $incidents = new Incidents();
        $incidentList = $incidents->getIncidentsAsArray();


        if (isset($_POST["submitInc"])) {

        //API URL Incident
        $json_url = APIURL . "incident";

        //initializing curl
        $ch = curl_init($json_url);

        $arrayData = array(
        "title" => $_POST["name"],
        "flag" => $_POST["author"],
        "flag" => $_POST["flag"],
        "visibility" => 1);

        //Curl options

        $headers = array(
        "Accept: application/json",
        "Content-Type: application/json");

        $options = array(
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $jsonData,
        );

        //setting curl options
        curl_setopt_array($ch, $options);

        //getting results
        $result_json = curl_exec($ch);
        $result = json_decode($result_json, true);
        $incidents = $result["incident"]["incidents"];
        ksort($incidents);
        }
        ?>
         *
         */

        // Reports module
        try {
            $reportService = new aptostatGui\Service\ReportService();
            $currentReports = $reportService->getReportsAsArray();
        } catch (Exception $e) {
            $currentReports = null;
            $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        }

        $includeBag = array(
            'currentReports' => $currentReports,
        );

        return $app['twig']->render('newIncident.twig', $includeBag);
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

        if ($paramBag->request->get('hidden') == "true"){
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