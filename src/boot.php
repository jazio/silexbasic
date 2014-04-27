<?php

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

// Mails
use Silex\Provider\SwiftmailerServiceProvider;



/*============ Register Service Providers ============*/
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
    'twig.class_path'   => __DIR__.'/vendor/twig/lib',
    ));

$app->register(new UrlGeneratorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'translator.messages' => array(),
    ));

$app->register(new SwiftmailerServiceProvider());
/*============ Layout ============*/
// Aparently is optional
$app->before(function () use ($app) {
    $app['twig']->addGlobal('layout', null);
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
});
