<?php
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admins' => array(
            'pattern' => '^/admin',
            'http' => true,
            'users' => array(
                // Sha1 hash, no base64 encode, 1 iteration, no salt. Basic of the basics
                'admin' => array('ROLE_ADMIN', '5b6d9bf5c4b891f1799e577ee99b19b608f47c67'),
                'nox' => array('ROLE_ADMIN', 'e4409822ba1d95bebcec2dfaf8f8b3d2e7c8291e'),
            ),
        ),
    ),
));

// use the sha1 algorithm
// don't base64 encode the password
// use only 1 iteration
$app['security.encoder.digest'] = $app->share(function ($app) {
    return new MessageDigestPasswordEncoder('sha1', false, 1);
});