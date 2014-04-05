<?php
ini_set('display_errors', 0);
/**
 * author: Ovi Farcas
 * website: http://www.jazio.net
 */
/*============ Dependencies ============*/
require_once __DIR__.'/../vendor/autoload.php';

// Exceptions
use Symfony\Component\HttpFoundation\Response;
// path() usage in twig
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

// Application Object
$app = new Silex\Application();

$app['debug'] = true;

/*============ Register Service Providers ============*/
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
    'twig.class_path'   => __DIR__.'/vendor/twig/lib',
));

$app->register(new UrlGeneratorServiceProvider());


/*============ Layout ============*/
// Aparently is optional
$app->before(function () use ($app) {
    $app['twig']->addGlobal('layout', null);
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
});

/*============ Controllers ============*/

// Homepage
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig',array(
    'welcome' => 'Welcome to my homepage', // not set yet
    )); 
})->bind('homepage');

// Hello without template
$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello ' . $app->escape($name);
}
);

// Hello with template
$app->get('/hellotwig/{name}', function ($name) use ($app) {
    return $app['twig']->render('hello.html', array(
            'name' => $name,
        ));
});

// Blog Post Overview
/* The below array could be fetched from a json file or database*/
$blogPosts = array(
    1 => array(
        'bid' => '1',
        'date'   => '03-03-2014',
        'author' => 'Andrei Plesu',
        'title'  => 'Despre frumusetea uitata a vietii',
        'body'   => 'Lore ipsum1',
        ),
    2 => array(
        'bid' => '2',
        'date'   => '02-04-2014',
        'author' => 'Gabriel Liiceanu',
        'title'  => 'Jurnal de la Paltinis',
        'body'   => 'Lore ipsum2',
        ),
    );

$app->get('/blog', function () use ($blogPosts, $app) {
    return $app['twig']->render('blog.twig', array(
            'posts' => $blogPosts,
        ));   
// Optional nameroutes to be used with UrlGenerator Provider 
})->bind('blog');

// Blog Post Overview with Twig Template
$app->get('/blog/{id}', function ($id) use ($blogPosts, $app) {
    return $app['twig']->render('blogpost.twig',array(
        'title'  => $blogPosts[$id]['title'],
        'author' => $blogPosts[$id]['author'],
        'date'   => $blogPosts[$id]['date'],
        'body'   => $blogPosts[$id]['body'],
        ));
    
})->bind('blogpost');

// Works
$app->get('/works', function () use ($app) {
    return $app['twig']->render('works.twig',array(
        'pageTitle' => 'Works',
        ));
})->bind('works');

// Contact
$app->get('/about', function () use ($app) {
    return $app['twig']->render('about.twig',array(
        'pageTitle' => 'About',
        ));
})->bind('about');

// Contact
$app->get('/contact', function () use ($app) {
    return $app['twig']->render('contact.twig',array(
        'pageTitle' => 'Contact',
        ));
})->bind('contact');
// Contact
// Error Handlers
$app->error(function (\Exception $e) use ($app) {
    return new Response('<h2>Wooops, page not found!</h2>');
});
//var_dump($app);
//@todo

//header redirect
//create a menu
//yml for blog posts, see translation
$app->run();