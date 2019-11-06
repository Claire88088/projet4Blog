<?php
namespace OCFram;

abstract class Entity implements \ArrayAccess
{
  use Hydrator; // utilisation du trait Hydrator pour remplacer la méthode hydrate() : permet d'hydrater les entités
  
  protected $erreurs = [],
            $id;          

  public function __construct(array $donnees = [])
  {
    if (!empty($donnees))
    {
      $this->hydrate($donnees);
    }
  }

  public function isNew()
  {
    return empty($this->id);
  }


  // getters
  public function erreurs()
  {
    return $this->erreurs;
  }

  public function id()
  {
    return $this->id;
  }


  // setter
  public function setId($id)
  {
    $this->id = (int) $id;
  }


  // gestion des propriétés non encore définies
  public function offsetGet($var)
  {
    if (isset($this->$var) && is_callable([$this, $var]))
    {
      return $this->$var();
    }
  }

  public function offsetSet($var, $value)
  {
    $method = 'set'.ucfirst($var);

    if (isset($this->$var) && is_callable([$this, $method]))
    {
      $this->$method($value);
    }
  }

  public function offsetExists($var)
  {
    return isset($this->$var) && is_callable([$this, $var]);
  }

  public function offsetUnset($var)
  {
    throw new \Exception('Impossible de supprimer une quelconque valeur');
  }
}