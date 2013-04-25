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

        $includeBag = array(
            'currentReports' => $currentReports,
        );

        return $app['twig']->render('newIncident.twig', $includeBag);
    } catch (\Exception $e) {
        $app['monolog']->addCritical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
        return "Something went wrong. Please try again.";
    }
});