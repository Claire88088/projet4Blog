<?php
namespace App\Backend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\News;
use FormBuilder\CommentFormBuilder;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des news');

    $manager = $this->managers->getManagerOf('News');

    $this->page->addVar('listeNews', $manager->getList());
    $this->page->addVar('nombreNews', $manager->count());
  }

  // gestion des news
  public function executeInsert(HTTPRequest $request)
  {
    if ($request->postExists('auteur'))
    {
      $this->processForm($request);
    }
    
    $this->page->addVar('title', 'Ajout d\'une news');
  }
  

  public function executeUpdate(HTTPRequest $request)
  {
    if ($request->postExists('auteur'))
    {
      $this->processForm($request);
    }
    else
    {
      $this->page->addVar('news', $this->managers->getManagerOf('News')->getUnique($request->getData('id')));
    }
    
    $this->page->addVar('title', 'Modification d\'une news');
  }


  /**
   * Méthode permettant de traiter le formulaire et d'enregistrer la news dans la BDD
   * utile à la fois pour insérer une nouvelle news (executeInsert) et modifier une news existante (executeUpdate)
   */
  public function processForm(HTTPRequest $request)
  {
    $news = new News([
      'auteur' => $request->postData('auteur'),
      'titre' => $request->postData('titre'),
      'contenu' => $request->postData('contenu')
    ]);
    
    // L'identifiant de la news est transmis si on veut la modifier.
    if ($request->postExists('id'))
    {
      $news->setId($request->postData('id'));
    }
    
    if ($news->isValid())
    {
      $this->managers->getManagerOf('News')->save($news);
      
      $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
    }
    else
    {
      $this->page->addVar('erreurs', $news->erreurs());
    }
    
    $this->page->addVar('news', $news);
  }


  public function executeDelete(HTTPRequest $request)
  {
    $newsId = $request->getData('id');
    
    $this->managers->getManagerOf('News')->delete($newsId);
    $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

    $this->app->user()->setFlash('La news a bien été supprimée !');

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
        'auteur' => $request->postData('pseudo'),
        'contenu' => $request->postData('contenu')
      ]);
    }
    else
    {
      $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
    }
    
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    if ($request->method() == 'POST' && $form->isValid())
    {
      $this->managers->getManagerOf('Comments')->save($comment);
      $this->app->user()->setFlash('Le commentaire a bien été modifié !'); 
      $this->app->httpResponse()->redirect('/admin/'); //redirect('/news-'.$request->postData('news').'.html');
    }
     
    $this->page->addVar('form', $form->createView());
  }

  public function executeDeleteComment(HTTPRequest $request)
  {
    $this->managers->getManagerOf('Comments')->delete($request->getData('id'));
    
    $this->app->user()->setFlash('Le commentaire a bien été supprimé !');
    
    $this->app->httpResponse()->redirect('.');
  }
}