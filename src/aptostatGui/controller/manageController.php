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
        $apiService = new aptostatGui\Service\ApiService();
        $currentIncidents = $apiService->getSortedIncidentList();
    } catch (Exception $e) {
        $currentIncidents = null;
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
    }


    $includeBag = array(
        'currentReports' => $currentReports,
        'incidentList' => $currentIncidents["incidents"],
        'showHidden' => "false",
    );

    return $app['twig']->render('manage.twig', $includeBag);
})
->bind('manage');

$app->match('/admin/newIncident', function(Request $paramBag) use ($app) {

    try {
        // Reports module
        try {
            $reportService = new aptostatGui\Service\ReportService();
            $currentReports = $reportService->getReportsAsArray();
        } catch (Exception $e) {
            $currentReports = null;
            $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        }

        // Create a status list
        try {
            $apiService = new aptostatGui\Service\ApiService();
            $reportList = $apiService->getReportList();

            foreach ($reportList['reports'] as $report) {
                $id = $report['id'];
                $status = $report['flag'];
                $statusList[$id] = $status;
            }

            $includeBag['statusList'] = $statusList;
        } catch (Exception $e) {
            $statusList = null;
            $app['monolog']->addDebug('Notice: Could not create conRepList');
        }

        $includeBag = array(
            'currentReports' => $currentReports,
            'statusList' => $statusList,
        );

        return $app['twig']->render('newIncident.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});

$app->match('/admin/addRemoveReports/{incidentId}', function(Request $paramBag, $incidentId) use ($app) {
    try {
        $apiService = new aptostatGui\Service\ApiService();

        $incident = $apiService->getIncidentById($incidentId);

        // Reports module
        try {
            $reportService = new aptostatGui\Service\ReportService();
            $currentReports = $reportService->getReportsAsArray();
        } catch (Exception $e) {
            $currentReports = null;
            $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        }

        // Connected reports list
        try {
            $reportService = new aptostatGui\Service\ReportService();
            $connectedReports = $reportService->getConnectedReportsAsArray($incidentId);
        } catch (Exception $e) {
            $connectedReports = null;
            $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        }

        // Create a list over connectedReports
        try {
            $list = $incident['incidents']['connectedReports'];

            foreach ($list as $key => $value) {
                $conRepList[] = $key;
            }

            $includeBag['conRepList'] = $conRepList;
        } catch (Exception $e) {
            $conRepList = null;
            $app['monolog']->addDebug('Notice: Could not create conRepList');
        }

        // Create a status list
        try {
            $reportList = $apiService->getReportList();

            foreach ($reportList['reports'] as $report) {
                $id = $report['id'];
                $status = $report['flag'];
                $statusList[$id] = $status;
            }

            $includeBag['statusList'] = $statusList;
        } catch (Exception $e) {
            $statusList = null;
            $app['monolog']->addDebug('Notice: Could not create conRepList');
        }

        $includeBag = array(
            'incident' => $incident['incidents'],
            'currentReports' => $currentReports,
            'connectedReports' => $connectedReports,
            'conRepList' => $conRepList,
            'statusList' => $statusList,
        );

        return $app['twig']->render('addRemoveReports.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
})
->bind('addRemoveReports');