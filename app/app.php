<?php
$startTime = microtime(true);
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpKernel\Debug\ErrorHandler;
ErrorHandler::register(); // Convert errors to exceptions

// Set up default config
$config = array(
    'debug' => true,
    'timer.start' => $startTime,
    'monolog.name' => 'aptostat',
    'monolog.level' => \Monolog\Logger::DEBUG,
    'monolog.logfile' => __DIR__.'/log/dev.log',
    'twig.path' => __DIR__ . '/../src/aptostatGui/views',
    'twig.options' => array('debug' => true),
    'api.url' => 'http://aptoapi.vlab.iu.hio.no/',
);

// Apply custom config if available
if (file_exists(__DIR__ . '/config.php')) {
    include __DIR__ . '/config.php';
}

// Initialize Application
$app = new Silex\Application($config);

// Set error reporting on
if ($app['debug']) {
    error_reporting(E_ALL);
}

// Register twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['twig.path'],
    'twig.options' => $app['twig.options'],
));
$app['twig']->addExtension(new Twig_Extensions_Extension_Debug());

// Register Url-generator
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Set tmp monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.name' => $app['monolog.name'],
    'monolog.level' => $app['monolog.level'],
    'monolog.logfile' => $app['monolog.logfile'],
));

// Set up basic security
include 'security.php';

// Constants
define('APIURL', $app['api.url']);

// Map routes to controllers
include __DIR__ . '/routing.php';

return $app;
