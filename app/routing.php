<?php

// End user front-end
$app->get('/', function() use ($app) {
    return $app['twig']->render('index.twig');
});