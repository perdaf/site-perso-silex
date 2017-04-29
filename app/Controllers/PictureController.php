<?php
namespace MyCvApp\Controllers;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use MyCvApp\Models\pictureModels;

class pictureController implements ControllerProviderInterface {
 
  public function connect(Application $app) {
    $factory=$app['controllers_factory'];
    $factory->get('/','MyCvApp\Controllers\PictureController::findAll');
    // $factory->get('/insert','MyCvApp\Controllers\PictureController::insert');
    return $factory;
  }

  public function findRandPictures(Application $app) {
    $picture = $app['models.picture']->findRandPictures();
    return $app["twig"]->render("home.twig", ['data'=> $picture['name']]);
  }

  // public function insert(Application $app) {
  //   $name = 'test1';
  //   $cat = '3D';
  //   $url = 'chemin de l\'image';

  //   $app['models.picture']->insertPictures($name, $cat, $url);
  //   return 'picture save';
  // }

}