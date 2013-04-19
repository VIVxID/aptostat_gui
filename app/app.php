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

// Register twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['twig.path'],
    'twig.options' => $app['twig.options'],
));
$app['twig']->addExtension(new Twig_Extensions_Extension_Debug());

// Set tmp monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.name' => $app['monolog.name'],
    'monolog.level' => $app['monolog.level'],
    'monolog.logfile' => $app['monolog.logfile'],

));


//TODO: Cleanup security
// Set up security
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admins' => array(
            'pattern' => '^/admin',
            'http' => true,
            'users' => array(
                // raw password is foo
                'admin' => array('ROLE_ADMIN', '0beec7b5ea3f0fdbc95d0dd47f3c5bc275da8a33'),
                'nox' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
            ),
        ),

    )
));
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

$app['security.encoder.digest'] = $app->share(function ($app) {
    // use the sha1 algorithm
    // don't base64 encode the password
    // use only 1 iteration
    return new MessageDigestPasswordEncoder('sha1', false, 1);
});

// Constants
define('APIURL', $app['api.url']);

// Map routes to controllers
include __DIR__ . '/routing.php';

return $app;
