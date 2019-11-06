<?php
namespace App\Frontend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \OCFram\Form;
use OCFram\MaxLengthValidator;
use OCFram\NotNullValidator;
use \OCFram\StringField;
use \OCFram\TextField;

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
    $this->page->addVar('title', 'Liste des '.$nombreNews.' dernières news');
    
    // On récupère le manager des news.
    $manager = $this->managers->getManagerOf('News');
    
    $listeNews = $manager->getList(0, $nombreNews);
    
    foreach ($listeNews as $news)
    {
      if (strlen($news->contenu()) > $nombreCaracteres)
      {
        $debut = substr($news->contenu(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $news->setContenu($debut);
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
    
    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
  } 
  

  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé, on crée le commentaire avec les valeurs du formulaire.
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'news' => $request->getData('news'),
        'auteur' => $request->postData('pseudo'),
        'contenu' => $request->postData('contenu')
      ]);
    }
    else 
    {
      $comment = new Comment;
    }

    $form = new Form($comment);
    
    $form->add(new StringField([
      'label' => 'Auteur',
      'name' => 'auteur',
      'maxlength' => 50,
      'validators' => [
        new MaxLengthValidator('L\'auteur spécifié est trop long (50 caractères maximum)', 50),
        new NotNullValidator('Merci de spécifier l\'auteur du commentaire'),
      ]
    ]))
    ->add(new TextField([
      'label' => 'Contenu',
      'name' => 'contenu',
      'rows' => 7,
      'cols' => 50,
    ]));
      
    if ($form->isValid())
    {
      // on enregistre le commentaire
      
      //$this->managers->getManagerOf('Comments')->save($comment);
      //$this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');  
      //$this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
    }
      
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView()); // on passe le formulaire généré à la vue.
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }
}