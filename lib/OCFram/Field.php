<?php
namespace OCFram;

abstract class Field
{
  // On utilise le trait Hydrator afin que nos objets Field puissent être hydratés
  use Hydrator;
  
  protected $errorMessage;
  protected $label;
  protected $name;
  protected $value;
  
  public function __construct(array $options = []) // $options = la liste des attributs avec leur valeur
  {
    if (!empty($options))
    {
      $this->hydrate($options);
    }
  }
  
  /**
   * Méthode permettant de renvoyer le code HTML du champ
   */
  abstract public function buildWidget();
  

  public function isValid()
  {
    // On écrira cette méthode plus tard.
  }
  

  // getters
  public function label()
  {
    return $this->label;
  }
  
  public function name()
  {
    return $this->name;
  }
  
  public function value()
  {
    return $this->value;
  }
  

  // setters
  public function setLabel($label)
  {
    if (is_string($label))
    {
      $this->label = $label;
    }
  }
  
  public function setName($name)
  {
    if (is_string($name))
    {
      $this->name = $name;
    }
  }
  
  public function setValue($value)
  {
    if (is_string($value))
    {
      $this->value = $value;
    }
  }
}