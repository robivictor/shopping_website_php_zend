<?php
namespace ShoppingCart\Form;

 use Zend\Form\Form;

 class CreditCardForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('shopping_cart');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
//select
         $this->add(array(
             'name' => 'card_type',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Card Type',
             ),
         ));

         $this->add(array(
             'name' => 'acct',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Card Number',
             ),
         ));
         $this->add(array(
             'name' => 'expmonth',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Month',
             ),
         ));   
      
	   $this->add(array(
             'name' => 'expyear',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Year',
             ),
         ));

	   $this->add(array(
             'name' => 'cvv2',
             'type' => 'Text',
             'options' => array(
                 'label' => 'CVV',
             ),
         ));
	   $this->add(array(
             'name' => 'first_name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'First Name',
             ),
         ));
	   $this->add(array(
             'name' => 'last_name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Last Name',
             ),
         ));
	   $this->add(array(
             'name' => 'street',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Street',
             ),
         ));
	   $this->add(array(
             'name' => 'city',
             'type' => 'Text',
             'options' => array(
                 'label' => 'City',
             ),
         ));
	   $this->add(array(
             'name' => 'state',
             'type' => 'Text',
             'options' => array(
                 'label' => 'State',
             ),
         ));
	   $this->add(array(
             'name' => 'country',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Country',
             ),
         ));
	   $this->add(array(
             'name' => 'zip',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Post Code',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Pay',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
?>
