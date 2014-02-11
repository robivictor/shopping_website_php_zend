<?php
namespace ProductPage\Form;

 use Zend\Form\Form;
 use Zend\Form\Element;
 use Zend\InputFilter;
 use Doctrine\ORM\EntityManager;
 use ProductPage\Controller\ProductPageController;
 class ProductPageForm extends Form
 {


     public function __construct($em)
     {
         // we want to ignore the name passed
         parent::__construct('productpage');
         

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));

         $this->add(array(     
             'type' => 'Zend\Form\Element\Select',       
             'name' => 'category',
             'attributes' =>  array(
             'id' => 'category',                
             'options' => $this->getOptionsForSelect($em),
             ),
             'options' => array(
                   'label' => 'Select Category',
              ), 
          )); 

         $this->add(array(
             'name' => 'product_name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Product Name',
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
             'name' => 'size',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Size',
             ),
         ));

 $this->add(array(
             'name' => 'colors',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Colors',
             ),
         ));

         $this->addFile('photo1_url', 'Photo1 URL');
         $this->addInputFilter('photo1_url');
         $this->addFile('photo2_url', 'Photo2 URL');
         $this->addInputFilter('photo2_url');
         $this->addFile('photo3_url', 'Photo3 URL');
         $this->addInputFilter('photo3_url');
         $this->addFile('photo4_url', 'Photo4 URL');
         $this->addInputFilter('photo4_url');

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
