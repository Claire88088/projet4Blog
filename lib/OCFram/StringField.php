<?php
namespace OCFram;

/**
 * Représente un champ de texte sur une ligne (input type =  text) dans un formulaire
 */
class StringField extends Field
{
  protected $maxLength;
  
  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><input type="text" name="'.$this->name.'"';
    
    if (!empty($this->value))
    {
      $widget .= ' value="'.htmlspecialchars($this->value).'"';
    }

    if ($this->required)
    {
    $widget .= ' required ';
    }

    if (!empty($this->maxLength))
    {
      $widget .= ' maxlength="'.$this->maxLength.'"';
    }
    
    return $widget .= ' />';
  }
  
  // setter
  public function setMaxLength($maxLength)
  {
    $maxLength = (int) $maxLength;
    
    if ($maxLength > 0)
    {
      $this->maxLength = $maxLength;
    }
    else
    {
      throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
    }
  }
}