<?php
namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager
{
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, title, content, creation_date, update_date FROM news ORDER BY id DESC';
    
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
    
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    $listeNews = $requete->fetchAll();
    
    foreach ($listeNews as $news)
    {
      $news->setCreationDate(new \DateTime($news->creationDate()));
      $news->setUpdateDate(new \DateTime($news->updateDate()));
    }
    
    $requete->closeCursor();
    
    return $listeNews;
  }

  
  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, title, content, creation_date, update_date FROM news WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();
    
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    if ($news = $requete->fetch())
    {
      $news->setCreationDate(new \DateTime($news->creationDate()));
      $news->setUpdateDate(new \DateTime($news->updateDate()));
      
      return $news;
    }
    
    return null;
  }


  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
  }


  protected function add(News $news)
  {
    $requete = $this->dao->prepare('INSERT INTO news SET title = :title, content = :content, creation_date = NOW(), update_date = NOW()');
    
    $requete->bindValue(':title', $news->title());
    $requete->bindValue(':content', $news->content());
    
    $requete->execute();
  }


  protected function modify(News $news)
  {
    $requete = $this->dao->prepare('UPDATE news SET title = :title, content = :content, update_date = NOW() WHERE id = :id');
    
    $requete->bindValue(':title', $news->title());
    $requete->bindValue(':content', $news->content());
    $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);
    
    $requete->execute();
  }


  public function delete($id)
  {
    $this->dao->exec('DELETE FROM news WHERE id = '.(int) $id);
  }
}