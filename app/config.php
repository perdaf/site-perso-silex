<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

define('ROOT', __DIR__);
// Ce fichier es appeller en premier par index.php

// definition de la time zone
ini_set('date.timezone', 'America/Martinique');

// Ajout de l'autoloader
$loader = require_once ROOT.'/../vendor/autoload.php';

// Ajout du repertoir applicatif dans l'autoloader
$loader->add("App", dirname(ROOT));

// instentiation d'un objet silex/application
$app = new Silex\Application();

//------------------- Register ---------------
# url generator
$app->register(new Silex\Provider\RoutingServiceProvider());
# Session
$app->register(new Silex\Provider\SessionServiceProvider());
# Asset
$app->register(new Silex\Provider\AssetServiceProvider());
#validator
$app->register(new Silex\Provider\ValidatorServiceProvider());
#twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    "twig.path" => dirname(ROOT) . "/App/Views",
    'twig.options' => array('cache' => dirname(ROOT).'/cache', 'strict_variables' => true)
));
#Doctrine
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'cv',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ),
));

//--------- Register Service -----------
#pictureModels
$app['models.picture'] = function($app){
	return new MyCvApp\models\pictureModels($app['db']);
};
#contactModels
$app['models.contact'] = function($app){
	return new MyCvApp\Models\contactModels($app['db']);
};


// pour voir les erreurs en dev
$app['debug'] = true;


//redefine error route
$app->error(function (\Exception $e, Request $request, $code) {
    switch ($code) {
        case 404:
            $message = 'La page que vous chercher n\'existe pas.';
            break;
        default:
            $message = 'steeve We are sorry, but something went terribly wrong.';
    }

    return new Response($message);
});

//import des routes
require_once 'routes.php';

return $app;

