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
        'currentIncidents' => $currentIncidents,
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
            'reportData' => $report,
        );

        return $app['twig']->render('viewReport.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "fail";
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
        return "fail";
    }
});