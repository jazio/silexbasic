<?php

/**
 * author: Ovi Farcas
 * date: Apr 27 2014
 * website: http://www.jazio.net
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/../src/boot.php';
require __DIR__.'/../src/config.php';
require __DIR__.'/../src/debug.php';
require __DIR__.'/../src/controllers.php';

$app->run();