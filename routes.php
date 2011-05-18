<?php

$app = require_once('app.php');

$app->get('/', function () {
    return 'Hello, World!'; 
});

return $app;