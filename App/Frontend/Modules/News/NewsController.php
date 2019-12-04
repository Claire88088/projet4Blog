<?php
namespace App\Frontend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use FormBuilder\CommentFormBuilder;
use \OCFram\FormHandler;

class NewsController extends BackController
{
  /**
   * Méthode permettant l'affichage de la liste des news
   */
  public function executeIndex(HTTPRequest $request)
  {
    $nombreNews = $this->app->config()->get('nombre_news');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
    
    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombreNews.' derniers épisodes');
    
    // On récupère le manager des news.
    $manager = $this->managers->getManagerOf('News');
    
    $listeNews = $manager->getList(0, $nombreNews);
    
    foreach ($listeNews as $news)
    {
      // on enlève les balises HTML permettant la mise en page pour éviter les bugs d'affichage des résumés
      $contentWithoutTags = strip_tags($news->content());

      if (strlen($contentWithoutTags > $nombreCaracteres))
      {
        $debut = substr($contentWithoutTags, 0, $nombreCaracteres);
        
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $news->setContent($debut); 
      }
    }
    
    // On ajoute la variable $listeNews à la vue.
    $this->page->addVar('listeNews', $listeNews);
  }

  /**
   * Méthode permettant l'affichage d'une news et de ses commentaires
   */
  public function executeShow(HTTPRequest $request)
  {
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
    
    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }
    
    $this->page->addVar('title', $news->title());
    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
  } 
  

  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé, on créé un nouveau commentaire avec les valeurs du formulaire
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'news' => $request->getData('news'),
        'author' => htmlspecialchars($request->postData('author')),
        'content' => htmlspecialchars($request->postData('content'))
      ]);
    }
    else
    {
      $comment = new Comment;
    }

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
      $this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
    }

    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }

  public function executeReportComment(HTTPRequest $request)
  {
    // récupération de l'id du comment à signaler
    $id = $request->getData('comment_id');

    // modification de isReported du comment stocké en BDD : Manager->report($id)
    $this->managers->getManagerOf('Comments')->report($id);

    // phrase d'info : Le commentaire a bien été signalé
    $this->app->user()->setFlash('Le commentaire a bien été signalé, merci !');
    
    // redirection vers la page news-id.html
    $this->app->httpResponse()->redirect('news-'.$request->getData('news_id').'.html');
  }
}