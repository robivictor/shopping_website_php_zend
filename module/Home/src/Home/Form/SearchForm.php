<?php
namespace Home\Form;

 use Zend\Form\Form;
 use Zend\Form\Element;
 use Zend\InputFilter;

 class SearchForm extends Form
 {
     public function __construct($em)
     {
         // we want to ignore the name passed
         parent::__construct('home');

         //$this->add(array(
             
         //));
 
         $this->add(array(     
             'type' => 'Zend\Form\Element\Select',       
             'name' => 'category',
             'attributes' =>  array(
             'id' => 'category',                
             'options' => $this->getOptionsForSelect($em),
             ),
             'options' => array(
                   'label' => 'Category<br/>',
                   'scape' => false,
              ), 
          )); 

         $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'startprice',
             'options' => array(
                        'label' => 'Price',
                        'value_options' => array(
                            '0'   => '$0',
                            '25'  => '$25',
                            '50'  => '$50',
                            '75'  => '$75',
                            '100' => '$100',
                            '200' => '$200',
                            
                        ),
                )
        ));

         $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'endprice',
             'options' => array(
                        'label' => 'to',
                        'value_options' => array(
                            '25'   => '$25',
                            '50'  => '$50',
                            '75'  => '$75',
                            '100'  => '$100',
                            '200' => '$200',
                            'more' => 'more',
                            
                        ),
                )
        ));
         
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Search',
                 'class' => 'search-submit',
             ),
         ));
     }

    public function getOptionsForSelect($em)
    {
        $result = $em->getRepository('CategoryPage\Entity\CategoryPage')->findAll();

        $selectData = array();
        foreach ($result as $res) {
            $selectData[$res->id] = $res->category_display;
        }
        return $selectData;
    }

 }
?>
