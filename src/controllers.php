<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;
// Mails
use Silex\Provider\SwiftmailerServiceProvider;

// Application Object
$app = new Application();

// REMOVE ON PRODUCTION
require __DIR__.'/../config/dev.php';

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

    try {
     $yamlQuestions = file_get_contents(__DIR__.'/../data/data.yml');
     $questions = Yaml::parse($yamlQuestions);

 } catch (Exception $e) {
    return $e;
}
return $app['twig']->render('about.twig',array(
    'pageTitle' => 'About',
    'questions' => $questions,
    ));
})->bind('about');

// Contact
$app->match('/feedback', function (Request $request) use ($app) {

    $data = array(
     'name' => 'Your name',
     'email' => 'your@email.com',
     'message' => 'Message',
     );


    $form = $app['form.factory']->createBuilder('form', $data)
    ->add('name', 'text', array(
        'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 10))),
        ))
    ->add('email', 'email', array(
        'constraints' => array(new Assert\NotBlank(), new Assert\Email()),
        'label'       => 'A custom label : ',
        'attr' => array('class' => 'span5', 'placeholder' => 'email constraints')
        ))
    ->add('message', 'textarea')
    ->getForm();

    //$request = $app['request'];
    $formStatus = 'Please fill up the form 0';
    $bgFormStatus = '';
    if ($request->isMethod('POST'))
    {
        $form->handleRequest($request);
        
        if ($form->isSubmitted())
        {
            if ($form->isValid()) 
            {
                $data = $form->getData();
                $bgFormStatus = 'bg-success';
                $formStatus = 'Form is submitted and valid';
            }
        }
        else {
         $bgFormStatus = 'bg-info';
         $formStatus = 'Please fill up the form'; 
     }
 }    


 return $app['twig']->render('feedback.twig',array(
    'pageTitle' => 'Feedback',
    'formStatus' => $formStatus,
    'bgFormStatus' => $bgFormStatus,
    'form' => $form->createView(),
    ));
})
->bind('feedback');





// Contact
$app->match('/contact', function (Request $request) use ($app) {

    $data = array(
     'name' => 'Your name',
     'subject' => 'Subject here', 
     'email' => 'ovidiufarcas@gmail.com',
     'message' => 'Message',
     );


    $form = $app['form.factory']->createBuilder('form', $data)
    ->add('name', 'text', array(
        'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 10))),
        ))
    ->add('email', 'email', array(
        'constraints' => array(new Assert\NotBlank(), new Assert\Email()),
        'label'       => 'A custom label from email : ',
        'attr' => array('class' => 'span5', 'placeholder' => 'email constraints')
        ))
    ->add('subject', 'text', array(
        'constraints' => array(new Assert\NotBlank)
        ))
    ->add('message', 'textarea', array(
        'constraints' => array(new Assert\NotBlank)
        ))
    ->getForm();

    $request = $app['request'];
    $formStatus = 'Please fill up the form 0';
    $bgFormStatus = '';
    if ($request->isMethod('POST'))
    {
        $form->handleRequest($request);
        
        if ($form->isSubmitted())
        {
            if ($form->isValid()) 
            {



                $bgFormStatus = 'bg-success';
                $formStatus = 'Form is submitted and valid';


                // Get form submitted values
                $fields = $form->getData();

                    // Create the mail
    $message = \Swift_Message::newInstance()
        ->setSubject($fields['subject'])
        ->setFrom(array('farcaso@gmail.com'))
        ->setTo($fields['email'])
        ->setBody($fields['message'], 'text/html')
    ;

    // @TODO Set headers: From, Reply-To

    // Send the mail
    $app['mailer']->send($message);

    // @TODO remove to render twig, add a flag OK variable
    return 'Mail envoyé a ' . $fields['email'];

    }
}
else {
 $bgFormStatus = 'bg-info';
 $formStatus = 'Please fill up the form'; 
}
}    


return $app['twig']->render('contact.twig',array(
    'pageTitle' => 'Contact',
    'formStatus' => $formStatus,
    'bgFormStatus' => $bgFormStatus,
    'form' => $form->createView(),
    ));
})
->bind('contact');
// Contact
// Error Handlers
$app->error(function (\Exception $e) use ($app) {
    return new Response('<h2>Wooops, page not found!</h2>');
});