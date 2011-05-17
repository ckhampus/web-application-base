<?php

require_once(__DIR__.'/silex/silex.phar');

$app = new Silex\Application();

$app->register(new Silex\Extension\MonologExtension(), array(
    'monolog.name' => 'app',
    'monolog.logfile' => __DIR__.'/log/development.log',
    'monolog.class_path' => __DIR__.'/vendor/monolog/src'
));

$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path' => __DIR__.'/views',
    'twig.options' => array(
        'cache' => __DIR__.'/cache',
        'debug' => true
    ),
    'twig.class_path' => __DIR__.'/vendor/twig/lib'
));

$app->get('/', function () {
    return 'Hello, World!'; 
});

return $app;