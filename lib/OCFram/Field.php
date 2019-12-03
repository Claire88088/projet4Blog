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
  protected $required;
  protected $validators = [];
  
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
    foreach ($this->validators as $validator)
    {
        if (!$validator->isValid($this->value))
        {
            $this->errorMessage = $validator->errorMessage();
            return false;
        }
    }

    return true;
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

  public function required()
  {
    return $this->required;
  }

  public function validators()
  {
    return $this->validators;
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

  public function setRequired($required)
  {
    if (is_string($required))
    {
      $this->required = $required;
    }
  }

  public function setValidators(array $validators)
  {
    foreach ($validators as $validator)
    {
        if ($validator instanceof Validator && !in_array($validator, $this->validators))
        {
            $this->validators[] = $validator;
        }
    } 
  }
}