<?php
namespace Entity;

use \OCFram\Entity;

class Comment extends Entity
{
  protected $news, // id de la News
            $author,
            $content,
            $creationDate,
            $moderationDate,
            $isReported;

  const AUTEUR_INVALIDE = 1;
  const CONTENU_INVALIDE = 2;

  public function isValid()
  {
    return !(empty($this->author) || empty($this->content));
  }


  // setters
  public function setNews($news)
  {
    $this->news = (int) $news;
  }

  public function setAuthor($author)
  {
    if (!is_string($author) || empty($author))
    {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    }

    $this->author = $author;
  }

  public function setContent($content)
  {
    if (!is_string($content) || empty($content))
    {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    }

    $this->content = $content;
  }

  public function setCreationDate(\DateTime $creationDate)
  {
    $this->creationDate = $creationDate;
  }

  public function setModerationDate(\DateTime $moderationDate)
  {
    $this->moderationDate = $moderationDate;
  }

  public function setIsReported($isReported)
  {
    if (($isReported === 0) || ($isReported === 1))
    {
      $this->isReported = $isReported;
    }
  }


  // getters
  public function news()
  {
    return $this->news;
  }

  public function author()
  {
    return $this->author;
  }

  public function content()
  {
    return $this->content;
  }

  public function creationDate()
  {
    return $this->creationDate;
  }

  public function moderationDate()
  {
    return $this->moderationDate;
  }

  public function isReported()
  {
    return $this->isReported;
  }
}