<?php
namespace MyCvApp\Controllers;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;
use MyCvApp\Models\contactModels;
use MyCvApp\Models\pictureModels;


class HomeController implements ControllerProviderInterface {
  
  public function connect(Application $app) {
    $factory=$app['controllers_factory'];
    $factory->get('/','MyCvApp\Controllers\HomeController::index')->bind('index');
    $factory->post('/contact','MyCvApp\Controllers\HomeController::contact')->bind('contact');
    return $factory;
  }
 
  // index methode
  public function index(Application $app) {
    $picture = $app['models.picture']->findRandPictures();
    return $app["twig"]->render("home.twig", ['data'=> $picture]);
  	// return $app["twig"]->render("home.twig");
    
  }

  // contact methode
  public function contact(Application $app){
    if(!empty($_POST)){
      
      $post = array_map('trim', array_map('strip_tags', $_POST));

      $verifications = new Assert\Collection(array(
        'name' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2))),
        'email' => new Assert\Email(),
        'message' => new Assert\Length(array('min' => 5)),
       ));

      $errors = $app['validator']->validate($post, $verifications);

      if(count($errors) <= 0){

      $mes = $app['models.contact']->saveContact($post['name'], $post['email'], $post['message']);

        return $app->json(['status' => 'success', 'message' => $mes]);
        // return $app->json(['status' => 'success', 'message' => 'Votre message est bien parti']);
        
      }else{
        // foreach ($errors as $error)
        //  {
        //     $errorsArray[] = array(
        //         'elementId' => str_replace('data.', '', $error->getPropertyPath()),
        //         'errorMessage' => $error->getMessage(),
        //     );
        // }
        // $err = array_filter($errorsArray);
        // $errorsString = implode('<br>',$err);
        // $errorsString = (string)$errors;
        return $app->json(['status' => 'error', 'message' => 'Erreur dans le formulaire, le nom es obligatoire et doit faire plus de 2 caractéres,l\'Email es obligatoire et de la forme \'votre@email.fr\', Le message doit faire plus de 15 caractéres']);
        // return 'Cooolllll';
      }

    }
  }


}//-------end of HomeController ---------