<?php

use

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

$app->post('/admin/ajax/viewReport', function() use ($app) {

    $reportId = $;

    //getting results
    $result_json = curl_exec($ch);
    $result = json_decode($result_json, true);

    print "Report ID: " . $result["reports"]["id"] . "<br />";
    print "Timestamp: " . $result["reports"]["createdTimestamp"] . "<br />";
    print "Last update: " . $result["reports"]["lastUpdatedTimestamp"] . "<br />";
    print "Check type: " . $result["reports"]["checkType"] . "<br />";
    print "Source name: " . $result["reports"]["source"] . "<br />";
    print "Service name: " . $result["reports"]["host"] . "<br />";
    print "Flag: " . $result["reports"]["flag"] . "<br /><br />";
    print "Error message:<br />" . $result["reports"]["errorMessage"];
});

$app->post('/admin/ajax/viewIncident', function() use ($app) {
    return "The monster of alot incident";
});