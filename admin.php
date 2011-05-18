<?php

$app = new Silex\Application();

$app->register(new Silex\Extension\SessionExtension());

$app->get('/', function () use ($app) {
   return 'Hello, Admin!'; 
});

return $app;