<?php
namespace Entity;

use \OCFram\Entity;

class News extends Entity
{
  protected $author,
            $title,
            $content,
            $creationDate,
            $updateDate;

  const AUTEUR_INVALIDE = 1;
  const TITRE_INVALIDE = 2;
  const CONTENU_INVALIDE = 3;

  public function isValid()
  {
    return !(empty($this->title) || empty($this->content));
  }


  // setters
  public function setAuthor($author)
  {
    if (!is_string($author) || empty($author))
    {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    }

    $this->author = $author;
  }

  public function setTitle($title)
  {
    if (!is_string($title) || empty($title))
    {
      $this->erreurs[] = self::TITRE_INVALIDE;
    }

    $this->title = $title;
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

  public function setUpdateDate(\DateTime $updateDate)
  {
    $this->updateDate = $updateDate;
  }

  // getters
  public function author()
  {
    return $this->author;
  }

  public function title()
  {
    return $this->title;
  }

  public function content()
  {
    return $this->content;
  }

  public function creationDate()
  {
    return $this->creationDate;
  }

  public function updateDate()
  {
    return $this->updateDate;
  }
}