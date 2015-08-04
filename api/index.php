<?
/* load composer requires */
require 'vendor/autoload.php';

/* Initiate the Slim app */
$app = new \Slim\Slim();

/* root directory GET request */ 
$app->get('/', function ($name) {
    echo "This will do stuff eventually.";
});

/* run it, so routes actually route */
$app->run();