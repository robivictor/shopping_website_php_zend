<?php
namespace MemberLogin\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class MemberLogin implements InputFilterAwareInterface
{
  public $id;
  public $name;
  public $quantity;
  public $price;
  protected $inputFilter; 
  
  public function exchangeArray($data)
  {
    $this->id  =(!empty($data['id']))? $data['id'] : null;
    $this->name =(!empty($data['name']))? $data['name'] : null;
    $this->quantity = (!empty($data['quantity']))? $data['quantity']: 0;
    $this->price = (!empty($data['price']))? $data['price']: 0.0;
  }

  public function getArrayCopy()
  {
         return get_object_vars($this);
  }

  public function setInputFilter(InputFilterInterface $inputFilter)
  {
         throw new \Exception("Not used");
     }

  public function getInputFilter()
  {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'name',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 80,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'price',
                 'required' => true
             ));
               
              $inputFilter->add(array(
                 'name'     => 'quantity',
                 'required' => true,
                 'filters'  => array(
                      array('name' => 'Int'),
                 ),
             ));


             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
   }
}
?>
