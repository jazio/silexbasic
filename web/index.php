<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

// Register Service Providers
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

// Controllers
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig',array(
    'welcome' => $welcome, // not set yet
    ));
}
);

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello ' . $app->escape($name);
}
);

$app->get('/hellotwig/{name}', function ($name) use ($app) {
    return $app['twig']->render('hello.html', array(
    		'name' => $name,
    	));
});
//var_dump($app);
$app->run();