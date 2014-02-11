<?php
namespace Home\Form;

 use Zend\Form\Form;
 use Zend\Form\Element;
 use Zend\InputFilter;

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
             'type' => 'Zend\Form\Element\Select',
             'name' => 'type',
             'options' => array(
                        'label' => 'Select Item Type',
                        'value_options' => array(
               'product'       => 'product',
               'slider_product' => 'slider_product',
               'bottom_product' => 'bottom_product',      
                        ),
                )
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
             'name' => 'item_id',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Item ID',
             ),
         ));

         $this->addFile('photo_url', 'Add Photo');
         $this->addInputFilter('photo_url');

         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }


    public function addFile($name,$label)
    {
        // File Input
        $file = new Element\File($name);
        $file->setLabel($label)
             ->setAttribute('id', $name);
        $this->add($file);
    }

    public function addInputFilter($name)
    {
        $inputFilter = new InputFilter\InputFilter();

        // File Input
        $fileInput = new InputFilter\FileInput($name);
        $fileInput->setRequired(true);
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => "/home/uplaod/fff.pgd",
            )
        );
        $inputFilter->add($fileInput);

        $this->setInputFilter($inputFilter);
    }

 }
?>
