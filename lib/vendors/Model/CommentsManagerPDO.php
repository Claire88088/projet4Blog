<?php
namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{ 
  // Select
  public function getListOf($news)
  {
    if (!ctype_digit($news))
    {
      throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
    }
    
    $q = $this->dao->prepare('SELECT id, news_id, author, content, creationDate, moderationDate, isReported FROM comments WHERE news_id = :news ORDER BY creationDate DESC');
    $q->bindValue(':news', $news, \PDO::PARAM_INT);
    $q->execute();
    
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
    
    $comments = $q->fetchAll();
    
    foreach ($comments as $comment)
    {
      $comment->setCreationDate(new \DateTime($comment->creationDate()));
    }
    
    return $comments;
  }

  public function get($id)
  {
    $q = $this->dao->prepare('SELECT id, news_id, author, content FROM comments WHERE id = :id');
    $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $q->execute();
    
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
    
    return $q->fetch();
  }

  public function getReportedList()
  {
    $q = $this->dao->prepare('SELECT id, news_id, author, content, creationDate FROM comments WHERE isReported = 1 ORDER BY creationDate DESC');
    $q->execute();

    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

    $reportedComments = $q->fetchAll();
    
    foreach ($reportedComments as $reportedComment)
    {
      $reportedComment->setCreationDate(new \DateTime($reportedComment->creationDate()));
    }
    
    return $reportedComments;
  }

  // Create
  protected function add(Comment $comment)
  {
    $q = $this->dao->prepare('INSERT INTO comments SET news_id = :news, author = :author, content = :content, creationDate = NOW()');
    
    $q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
    $q->bindValue(':author', $comment->author());
    $q->bindValue(':content', $comment->content());
    
    $q->execute();
    
    $comment->setId($this->dao->lastInsertId());
  }
  

  // Update
  protected function modify(Comment $comment)
  {
    $q = $this->dao->prepare('UPDATE comments SET author = :author, content = :content WHERE id = :id');
    
    $q->bindValue(':author', $comment->author());
    $q->bindValue(':content', $comment->content());
    $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
    
    $q->execute();
  }
  
  
  // Delete
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
  }

  public function deleteFromNews($news)
  {
    $this->dao->exec('DELETE FROM comments WHERE news_id = '.(int) $news);
  }

  // Count
  public function countReported()
  {
    return $this->dao->query('SELECT COUNT(*) FROM comments WHERE isReported = 1')->fetchColumn();
  }

  // Signaler
  public function report($id)
  {
    $this->dao->exec('UPDATE comments SET isReported = 1 WHERE id = '.(int) $id);
  }

  // Modérer
  public function moderate($id)
  {
    $this->dao->exec('UPDATE comments SET moderationDate = NOW(), isReported = 0 WHERE id = '.(int) $id);
  }
}