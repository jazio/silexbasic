<?php
//ini_set('display_errors', 0);
/**
 * author: Ovi Farcas
 * website: http://www.jazio.net
 */
/*============ Silex  ============*/
require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/boot.php';
require __DIR__.'/../config/dev.php';
require __DIR__.'/../src/controllers.php';

$app->run();