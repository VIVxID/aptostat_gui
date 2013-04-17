<?php
$startTime = microtime(true);
require_once __DIR__ . '/../vendor/autoload.php';

// Set error reporting on
error_reporting(E_ALL);

use Symfony\Component\HttpKernel\Debug\ErrorHandler;
ErrorHandler::register(); // Convert errors to exceptions

// Set up default config
$config = array(
    'debug' => true,
    'timer.start' => $startTime,
    'timer.threshold_info' => 1000,
    'timer.threshold_warning' => 5000,
    'api.url' => 'http://aptoapi.vlab.iu.hio.no/',
);

// Apply custom config if available
if (file_exists(__DIR__ . '/config.php')) {
    include __DIR__ . '/config.php';
}

// Initialize Application
$app = new Silex\Application($config);

// Register twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../src/aptostatGui/views',
    'twig.options' => array('debug' => true),
));
$app['twig']->addExtension(new Twig_Extensions_Extension_Debug());

// Set tmp monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.name' => 'aptostat',
    'monolog.level' => \Monolog\Logger::DEBUG,
    'monolog.logfile' => __DIR__.'/log/dev.log',

));

// Map routes to controllers
include __DIR__ . '/routing.php';

return $app;
