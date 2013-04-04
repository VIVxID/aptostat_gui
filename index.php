<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../app/app.php';
if ($app instanceof Silex\Application) {
    $app->run();
}
