<?php

/**
 * Dev -- optional file to be included during development phase
 */
//it's important to set the error handling before initialize the $app
// Convert PHP Errors into Exceptions
// Read here why http://silex.sensiolabs.org/doc/cookbook/error_handler.html
// @TODO verify the paths, study lines
// http://stackoverflow.com/questions/23315742/how-to-debug-php-fatal-errors-in-silex-framework/23319793?noredirect=1#23319793
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;
use Symfony\Component\Debug\Debug;

// set the error handling
ini_set('display_errors', 1);
error_reporting(-1);
ErrorHandler::register();
if ('cli' !== php_sapi_name()) {
  ExceptionHandler::register();
}

// Enable PHP Error level
error_reporting(E_ALL);
//ini_set('display_errors',1);



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