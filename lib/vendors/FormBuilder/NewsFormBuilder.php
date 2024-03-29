<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class NewsFormBuilder extends FormBuilder
{
  public function build()
  {
    $title = new StringField([
      'label' => 'Titre',
      'name' => 'title',
      'maxLength' => 100,
      'validators' => [
        new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
        new NotNullValidator('Merci de spécifier le titre de l\'épisode'),
      ],
     ]);

    $title->setRequired(true);

    $content = new TextField(['label' => 'Contenu',
    'name' => 'content',
    'rows' => 8,
    'cols' => 60,
    'id' => 'newsContent',
    'validators' => [
      new NotNullValidator('Merci de spécifier le contenu de l\'épisode'),
    ],
    ]);
    $content->setRequired(true);

    $this->form
       ->add($title)
      ->add($content)
      ;
  }
}