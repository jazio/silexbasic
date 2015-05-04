<?php

//@todo study Silex/Application.
//@todo https://github.com/sgomez/miniblog study to include dev...
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;



// Register Service Providers.
$app->register(new HttpCacheServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new DoctrineServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TranslationServiceProvider());
$app->register(new SwiftmailerServiceProvider());

// Global Layout.
$app->before(function () use ($app) {
    $app['twig']->addGlobal('layout', null);
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
});
