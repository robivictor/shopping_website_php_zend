<?php
namespace Home\Form;

 use Zend\Form\Form;

 class HomeForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('home');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));

         $this->add(array(
             'name' => 'type',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Type',
             ),
         ));
         $this->add(array(
             'name' => 'photo_url',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Photo Url',
             ),
         ));
         $this->add(array(
             'name' => 'link_url',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Link URL',
             ),
         ));

 $this->add(array(
             'name' => 'alt_text',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Alt Text',
             ),
         ));

 $this->add(array(
             'name' => 'title',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Title',
             ),
         ));

 $this->add(array(
             'name' => 'description1',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Description 1',
             ),
         ));

 $this->add(array(
             'name' => 'description2',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Description 2',
             ),
         ));

 $this->add(array(
             'name' => 'price',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Price',
             ),
         ));

         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
?>
