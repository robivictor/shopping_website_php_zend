<?php
namespace CategoryPage\Form;

 use Zend\Form\Form;

 class CategoryPageForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('categorypage');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));

         $this->add(array(
             'name' => 'category',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Category',
             ),
         ));

         $this->add(array(
             'name' => 'category_display',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Category Display Name',
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
