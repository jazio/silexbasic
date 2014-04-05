<?php
/**
 * author: Ovi Farcas
 * website: http://www.jazio.net
 */
/*============ Dependencies ============*/
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

/*============ Register Service Providers ============*/
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

/*============ Controllers ============*/

// Homepage
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig',array(
    'welcome' => $welcome, // not set yet
    ));
}
);

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
        'date'   => '03-03-2014',
        'author' => 'Andrei Plesu',
        'title'  => 'Despre frumusetea uitata a vietii',
        'body'   => 'Lore ipsum1',
        ),
    2 => array(
        'date'   => '02-04-2014',
        'author' => 'Gabriel Liiceanu',
        'title'  => 'Jurnal de la Paltinis',
        'body'   => 'Lore ipsum2',
        ),
    );

$app->get('/blog', function () use ($blogPosts) {
    $output = '';
    foreach ($blogPosts as $blog) {
        $output .= '<h2>'.$blog['title'].'</h2>';
        $output .= '<i>'.$blog['author'].'</i>'.' ' .'<small>'.$blog['date'].'</small>';
        $output .= '<p>'.$blog['body'].'</p>';
    }
    return $output;
}
);
// Blog Post Overview with Twig Template

$app->get('/blog/{id}', function ($id) use ($blogPosts, $app) {
    return $app['twig']->render('blog.twig',array(
        'title' => $blogPosts[$id]['title'],
        'author' => $blogPosts[$id]['author'],
        'date' => $blogPosts[$id]['date'],
        'body' => $blogPosts[$id]['body'],
        ));
    
}
);
//var_dump($app);
//@todo
///blog/id
//header redirect
//404
$app->run();