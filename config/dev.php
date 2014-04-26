<?php

/**
 * Dev -- optional file to be included during development phase
 */
// Convert PHP Errors into Exceptions
// Read here why http://silex.sensiolabs.org/doc/cookbook/error_handler.html
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\Debug;

// Include the prod configuration
require __DIR__.'/prod.php';

// Enable PHP Error level
error_reporting(E_ALL);
//ini_set('display_errors',1);

// Enable debug mode
$app['debug'] = true;

// Handle fatal errors
ErrorHandler::register();

Debug::enable();




// @TODO -- STUDY PROFILER
/* 
use Silex\Provider\WebProfilerServiceProvider;

$app->register($p = new WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../cache/profiler',
));
$app->mount('/_profiler', $p);
*/



// @TODO -- STUDY ENABLING MONOLOG LOGS
/*
use Silex\Provider\WebProfilerServiceProvider;

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../logs/silex_dev.log',
));
*/