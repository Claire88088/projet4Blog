<?php
namespace App\Backend\Modules\Connexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class ConnexionController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Connexion');
    $this->page->addVar('description', 'Connexion à l\'administration du blog de Jean Forteroche');
    
    if ($request->postExists('login'))
    {
      $login = htmlspecialchars($request->postData('login'));
      $password = htmlspecialchars($request->postData('password'));
      
      if ($login == $this->app->config()->get('login') && password_verify($password, $this->app->config()->get('pass')))
      {
        $this->app->user()->setAuthenticated(true);
        $this->app->httpResponse()->redirect('.');
      }
      else
      {
        $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
      }
    }
  }
}