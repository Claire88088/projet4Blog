<?php
namespace App\Backend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\News;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \OCFram\FormHandler;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des épisodes et des commentaires');

    $manager = $this->managers->getManagerOf('News');

    $this->page->addVar('newsList', $manager->getList());
    $this->page->addVar('newsNumber', $manager->count());

    $manager = $this->managers->getManagerOf('Comments');

    $this->page->addVar('reportedCommentsList', $manager->getReportedList());
    $this->page->addVar('reportedCommentsNumber', $manager->countReported());
  }

  // gestion des news
  public function executeInsert(HTTPRequest $request)
  {
    $this->processForm($request);
    
    $this->page->addVar('title', 'Ajout d\'un nouvel épisode');
  }
  

  public function executeUpdate(HTTPRequest $request)
  {
    $this->processForm($request);
    
    $this->page->addVar('title', 'Modification d\'un épisode');
  }


  /**
   * Méthode permettant de traiter le formulaire et d'enregistrer la news dans la BDD
   * utile à la fois pour insérer une nouvelle news (executeInsert) et modifier une news existante (executeUpdate)
   */
  public function processForm(HTTPRequest $request)
  { 
    // Création de News avec des valeurs ou pas selon si le formulaire a été envoyé ou non et si la News est nouvelle ou non
    if ($request->method() == 'POST')
    {
      $news = new News([
        'author' => htmlspecialchars($request->postData('author')),
        'title' => htmlspecialchars($request->postData('title')),
        'content' => $request->postData('content')
      ]);

      if ($request->getExists('id'))
      {
        $news->setId($request->getData('id'));
      }
    }
    else
    {
      // L'identifiant de la news est transmis si on veut la modifier
      if ($request->getExists('id'))
      {
        $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
      }
      else
      {
        $news = new News;
      }
    }

    // Création d'un formulaire d'ajout/modification de news
    $formBuilder = new NewsFormBuilder($news);
    $formBuilder->build();

    $form = $formBuilder->form();

    // Utilisation du gestionnaire de formulaire pour traiter les données récupérées via le formulaire
    $formHandler = new FormHandler($form, $this->managers->getManagerOf('News'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash($news->isNew() ? 'L\'épisode a bien été ajouté !' : 'L\'épisode a bien été modifié !');
      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
  }


  public function executeDelete(HTTPRequest $request)
  {
    $newsId = $request->getData('id');
    
    $this->managers->getManagerOf('News')->delete($newsId);
    $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

    $this->app->user()->setFlash('L\'épisode a bien été supprimé !');

    $this->app->httpResponse()->redirect('.');
  }


  // gestion des commentaires
  public function executeUpdateComment(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Modification d\'un commentaire');
   
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'id' => $request->getData('id'),
        'author' => htmlspecialchars($request->postData('author')),
        'content' => htmlspecialchars($request->postData('content'))
      ]);
    }
    else
    {
      $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
    }
    
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été modifié !'); 
      $this->app->httpResponse()->redirect('/admin/');
    }
     
    $this->page->addVar('form', $form->createView());
  }

  public function executeDeleteComment(HTTPRequest $request)
  {
    $this->managers->getManagerOf('Comments')->delete($request->getData('id'));
    
    $this->app->user()->setFlash('Le commentaire a bien été supprimé !');
    
    $this->app->httpResponse()->redirect('.');
  }

  public function executeModerateComment(HTTPRequest $request)
  {
    $this->managers->getManagerOf('Comments')->moderate($request->getData('id'));

    $this->app->user()->setFlash('Le commentaire a bien été modéré !');
    
    $this->app->httpResponse()->redirect('.');
  }
}