<?php

// configure your app for the production environment

//@TODO Form templates
// Twig
$app['twig.path'] = __DIR__.'/../views';
$app['twig.options'] = array(
        'cache'            => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true
    );

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    // add custom globals, filters, tags, ...

return $twig;
}));

// Cache
$app['cache.path'] = __DIR__ . '/../cache';
$app['http_cache.cache_dir'] = $app['cache.path'] . '/http';
$app['twig.options.cache'] = $app['cache.path'] . '/twig';