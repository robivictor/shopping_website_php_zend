<?php

namespace Auth\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* @ORM\Entity
* @ORM\Table(name="users")
* @property string $username
* @property string $password
* @property string $email
*/
 
class User implements InputFilterAwareInterface
{

protected $inputFiter;

/**
* @ORM\Id
* @ORM\Column(type="integer");
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;
/**
* @ORM\Column(type="string");
*/
protected $username;
/**
* @ORM\Column(type="string");
*/
protected $password;
/**
* @ORM\Column(type="string");
*/
protected $email;

 
   public function __get($property)
   {
     return $this->$property;
   }
 
   public function __set($property, $value)
   {
     $this->$property = $value;
   }
 
   public function getArrayCopy()
   {
      return get_object_vars($this);
   }
 
   public function populate($data = array())
   {
      $this->id               = $data['id'];
      $this->username         = $data['username'];
      $this->password         = $data['password'];
      $this->email            = $data['email'];
   }
 
   public function setInputFilter(InputFilterInterface $inputFilter)
   {
      throw new \Exception("Not used");
   }
 
   public function getInputFilter()
   {
      if (!$this->inputFilter) 
      {
         
         $inputFilter = new InputFilter();
         $factory = new InputFactory();
 
         $inputFilter->add($factory->createInput(array(
             'name' => 'id',
             'required' => true,
             'filters' => array(
             array(
                 'name' => 'Int'),
             ),
          )));

         $inputFilter->add($factory->createInput(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array(
                 'name' => 'StripTags'),
                array(
                 'name' => 'StringTrim'),
            ),
           'validators' => array(
                array(
                 'name' => 'StringLength',
                 'options' => array(
                 'encoding' => 'UTF-8',
                 'min' => 1,
                 'max' => 40,
                 ),
               ),
          ),
       )));
       
       $inputFilter->add($factory->createInput(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array(
                 'name' => 'StripTags'),
                array(
                 'name' => 'StringTrim'),
            ),
           'validators' => array(
                array(
                 'name' => 'StringLength',
                 'options' => array(
                 'encoding' => 'UTF-8',
                 'min' => 1,
                 'max' => 40,
                 ),
               ),
          ),
       )));

       
       $inputFilter->add($factory->createInput(array(
            'name' => 'email',
            'required' => false,
            'filters' => array(
                array(
                 'name' => 'StripTags'),
                array(
                 'name' => 'StringTrim'),
            ),
           'validators' => array(
                array(
                 'name' => 'StringLength',
                 'options' => array(
                 'encoding' => 'UTF-8',
                 'min' => 1,
                 'max' => 60,
                 ),
               ),
          ),
       )));
       
       $this->inputFilter = $inputFilter;
      }

    return $this->inputFilter;
  }
}
?>
