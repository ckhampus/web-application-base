<?php

require_once(__DIR__.'/silex/silex.phar');

// Create new main application
$app = new Silex\Application();

// Register Monolog extension for logging
$app->register(new Silex\Extension\MonologExtension(), array(
    'monolog.name' => 'app',
    'monolog.logfile' => __DIR__.'/log/development.log',
    'monolog.class_path' => __DIR__.'/vendor/monolog/src'
));

// Register Twig extension for templating
$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path' => __DIR__.'/views',
    'twig.options' => array(
        'cache' => __DIR__.'/cache',
        'debug' => true
    ),
    'twig.class_path' => __DIR__.'/vendor/twig/lib'
));

// Add mongo as a service
$app['mongo.config'] = array(
    'host' => 'localhost',
    'port' => 27017,
    'database' => 'database'
);

$app['mongo'] = $app->share(function () use ($app) {
    $c = $app['mongo.config'];
    $m = new \Mongo(sprintf('mongodb://%s:%s', $c['host'], $c['port'])); 
});

$app['mongo.database'] = $app->share(function () use ($app) {
    $m = $app['mongo'];
    $c = $app['mongo.config'];
    return $m->selectDB($c['database']);
});

// Mount admin application and share services
$app->mount('/admin', fucntion () use ($app) {
    $admin  = new Silex\LazyApplication(__DIR__.'/admin.php');
    $admin['service'] = $admin->share(function () use ($app) {
        return $app['service'];
    });
    
    return $admin;
});

return $app;