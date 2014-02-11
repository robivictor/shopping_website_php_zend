<?php

namespace Home\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;  
use Home\Form\HomeForm;
use Home\Form\SearchForm;
use Doctrine\ORM\EntityManager;
use Home\Entity\Home;
use ShoppingCart\Model\ShoppingCart;
use Zend\Session\Container;

class HomeController extends AbstractActionController
{
protected $em;

    public function indexAction()
    {
     $shoppingcart =  new ShoppingCart();
     $shoppingcart->startSession(); 
     $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
     $form = new SearchForm($ee);                
         return new ViewModel(array(
            'products' => $this->getEntityManager()->getRepository('Home\Entity\Home')->findBy(array('type'=>'product')),
            'slider_products' => $this->getEntityManager()->getRepository('Home\Entity\Home')->findBy(array('type'=>'slider_product')),
            'categories' => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'bottom_products' => $this->getEntityManager()->getRepository('Home\Entity\Home')->findBy(array('type'=>'bottom_product')),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     ));
    }

    public function addAction()
    {
         $user_session = new Container('user');
         $user_session->username = $user->username;
         $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
         $form = new HomeForm($ee);
         $form->get('submit')->setAttribute('label','Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $home = new Home();
             $form->setInputFilter($home->getInputFilter());
             $post = array_merge_recursive(
                 $request->getPost()->toArray(),
                 $request->getFiles()->toArray()
             );
             $form->setData($post);

             if ($form->isValid()) {
                 $data =  $form->getData();
                 $ph = $data['title'].'homeph';
                 $temp = explode(".", $data['photo_url']['name']);
                 $ext = end($temp);
                 $this->uploadFile($data['photo_url'],$ph);
                 $data['photo_url'] = "/img/".$ph.".".$ext;     
                 $home->populate($data);
                 $this->getEntityManager()->persist($home);
                 $this->getEntityManager()->flush();

                 // Redirect to list of cusomers
                 return $this->redirect()->toRoute('home');
             }
         }
         return array('form' => $form);

    }

    public function editAction()
    {
    $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
         if (!$id) {
             return $this->redirect()->toRoute('home', array(
                 'action' => 'add'
             ));
         }

    $home = $this->getEntityManager()->find('Home\Entity\Home',$id);
        
    $form  = new HomeForm();
    $form->setBindOnValidate(false);
    $form->bind($home);
    $form->get('submit')->setAttribute('label', 'Edit');

    $request = $this->getRequest();
    if ($request->isPost()) {
           $form->setData($request->getPost());
           if ($form->isValid()) {
                 $form->bindValues();
                 $this->getEntityManager()->flush();
                 // Redirect to list of home
                 return $this->redirect()->toRoute('home');
             }
         }
         return array(
             'id' => $id,
             'form' => $form,
         );
    }

    public function deleteAction()
    {
      $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
      if (!$id) {
           return $this->redirect()->toRoute('home');
      }
      $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $home = $this->getEntityManager()->find('Home\Entity\Home',$id);
                 if ($home) {
                    $this->getEntityManager()->remove($home);
                    $this->getEntityManager()->flush();
                 }
              }
           
             return $this->redirect()->toRoute('home');
         }

         return array(
             'id'    => $id,
             'home' => $this->getEntityManager()->find('Home\Entity\Home',$id));
     
    }
    
    public function showAction()
    {
    }

    public function searchAction()
    {
         $shoppingcart =  new ShoppingCart();
         $shoppingcart->startSession();       
         $request = $this->getRequest();
         $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
         $form = new SearchForm($ee);
         $categoryid = $request->getPost('category');
         $startprice = $request->getPost('startprice');
         $endprice   = $request->getPost('endprice'); 
         if($endprice=='more')
              $endprice = 10000;
         $query = $this->getEntityManager()->createQuery("SELECT u FROM ProductPage\Entity\ProductPage u WHERE u.category = ?1 AND  u.price BETWEEN ?2 AND ?3");
         $query->setParameter(1,$categoryid);
         $query->setParameter(2,$startprice);
         $query->setParameter(3,$endprice);
         return new ViewModel(array(
            'products'     => $query->getREsult(),
            'categories'   => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     ));            
    }

    public function supportAction()
    {
     $shoppingcart =  new ShoppingCart();
     $shoppingcart->startSession(); 
     $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
     $form = new SearchForm($ee);                
     return new ViewModel(array(
          'categories' => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     ));
    }

    public function myaccountAction()
    {
     $shoppingcart =  new ShoppingCart();
     $shoppingcart->startSession(); 
     $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
     $form = new SearchForm($ee);                
     return new ViewModel(array(
          'categories' => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     ));
    }

    public function thestoreAction()
    {
     $shoppingcart =  new ShoppingCart();
     $shoppingcart->startSession(); 
     $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
     $form = new SearchForm($ee);                
     return new ViewModel(array(
          'categories' => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     ));
    }

    public function contactAction()
    {
     $shoppingcart =  new ShoppingCart();
     $shoppingcart->startSession(); 
     $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
     $form = new SearchForm($ee);                
     return new ViewModel(array(
          'categories' => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     ));
    }

    public function setEntityManager(EntityManager $em)
    {
      $this->em = $em;
    }

    public function getEntityManager()
    {
    if (null === $this->em) {
       $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }
    return $this->em;
    }  

    public function uploadFile($file,$file_name)
    {
     $err = false;
     $allowedExts = array("gif","jpeg", "jpg", "png");
     $temp = explode(".", $file['name']);
     $extension = end($temp);
if ((($file["type"] == "image/gif")
|| ($file["type"] == "image/jpeg")
|| ($file["type"] == "image/jpg")
|| ($file["type"] == "image/pjpeg")
|| ($file["type"] == "image/x-png")
|| ($file["type"] == "image/png"))
&& in_array($extension, $allowedExts))
  {
  if ($file["error"] > 0)
    {
     $err = true;
    }
  else
    {
    if (file_exists("/img/" . $file['name']))
      {
       $err = true;
      }
    else
      {
      move_uploaded_file($file['tmp_name'],
      "/var/www/shoppinonline/public/img/" .$file_name.".".$extension);//change upload directory 
      $err = false;
      }
    }
   }
   else
   {
     $err =  true;
   }
   return $err;
 }     
}
?>
