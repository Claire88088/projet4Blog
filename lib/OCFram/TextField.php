<?php
namespace OCFram;

/**
 * Représente un textarea dans un formulaire
 */
class TextField extends Field
{
  protected $cols;
  protected $rows;
  protected $id;
  
  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><textarea name="'.$this->name.'"';

    if (!empty($this->id))
    {
      $widget .= ' id="'.$this->id.'"';
    }

    if ($this->required)
    {
    $widget .= ' required ';
    }

    if (!empty($this->cols))
    {
      $widget .= ' cols="'.$this->cols.'"';
    }
    
    if (!empty($this->rows))
    {
      $widget .= ' rows="'.$this->rows.'"';
    }
    
    $widget .= '>';
    
    if (!empty($this->value))
    {
      $widget .= htmlspecialchars($this->value);
    }
    
    return $widget.'</textarea>';
  }
  

  // setters
  public function setCols($cols)
  {
    $cols = (int) $cols;
    
    if ($cols > 0)
    {
      $this->cols = $cols;
    }
  }
  
  public function setRows($rows)
  {
    $rows = (int) $rows;
    
    if ($rows > 0)
    {
      $this->rows = $rows;
    }
  }

  public function setId($id)
  {
    if (is_string($id))
    {
      $this->id = $id;
    }
  }
}