<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Comment;

abstract class CommentsManager extends Manager
{
  /**
   * Méthode permettant de récupérer une liste de commentaires.
   * @param $news La news sur laquelle on veut récupérer les commentaires
   * @return array
   */
  abstract public function getListOf($news);
  
  /**
   * Méthode permettant d'obtenir un commentaire spécifique.
   * @param $id L'identifiant du commentaire
   * @return Comment
   */
  abstract public function get($id);

  /**
   * Méthode permettant de récupérer la liste des commentaires signalés.
   * @return array
   */
  abstract public function getReportedList();

  /**
   * Méthode permettant d'ajouter un commentaire
   * @param $comment Le commentaire à ajouter
   * @return void
   */
  abstract protected function add(Comment $comment);
  
  /**
   * Méthode permettant d'enregistrer un commentaire.
   * @param $comment Le commentaire à enregistrer
   * @return void
   */
  public function save(Comment $comment)
  {
    if ($comment->isValid())
    {
      $comment->isNew() ? $this->add($comment) : $this->modify($comment);
    }
    else
    {
      throw new \RuntimeException('Le commentaire doit être validé pour être enregistré');
    }
  }

  /**
   * Méthode permettant de modifier un commentaire.
   * @param $comment Le commentaire à modifier
   * @return void
   */
  abstract protected function modify(Comment $comment); 

  /**
   * Méthode permettant de supprimer un commentaire.
   * @param $id L'identifiant du commentaire à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant de supprimer tous les commentaires liés à une news
   * @param $news L'identifiant de la news dont les commentaires doivent être supprimés
   * @return void
   */
  abstract public function deleteFromNews($news);

  /**
   * Méthode renvoyant le nombre de commentaires signalés total.
   * @return int
   */
  abstract public function countReported();

  /** 
   * Méthode permettant de signaler un commentaire
   * @param $id L'identifiant du commentaire à signaler
   * @return void
   */
  abstract public function report($id);

  /**
   * Méthode permettant de modérer un commentaire
   * @param $id L'identifiant du commentaire à modérer
   * @return void
   */
  abstract public function moderate($id);
}