<?php

namespace ProductPage\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;  
use ProductPage\Form\ProductPageForm;
use Doctrine\ORM\EntityManager;
use ProductPage\Entity\ProductPage;
use ShoppingCart\Model\ShoppingCart;
use Home\Form\SearchForm;

class ProductPageController extends AbstractActionController
{
protected $em;

    public function indexAction()
    {
     $shoppingcart =  new ShoppingCart();
     $shoppingcart->startSession();
     $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
     $form = new SearchForm($ee);
     $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
         return new ViewModel(array(
            'product'      => $this->getEntityManager()->getRepository('ProductPage\Entity\ProductPage')->findOneBy(array('id'=>$id)),
            'categories'   => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     ));
    }

    public function addAction()
    {
     
         $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
         $form = new ProductPageForm($ee);
         $form->get('submit')->setAttribute('label','Add');
         
         $request = $this->getRequest();
         if ($request->isPost()) {
             $productpage = new ProductPage();
             $form->setInputFilter($productpage->getInputFilter());
             $post = array_merge_recursive(
                  $request->getPost()->toArray(),
                  $request->getFiles()->toArray()
             );
             
             $form->setData($post);

             if ($form->isValid()) { 
                 $data = $form->getData();
                 $ph1 = $data['product_name'].'ph1';
                 $ph2 = $data['product_name'].'ph2';
                 $ph3 = $data['product_name'].'ph3';
                 $ph4 = $data['product_name'].'ph4';
                 $temp1 = explode(".", $data['photo1_url']['name']);
                 $ext1 = end($temp1);
                 $temp2 = explode(".", $data['photo2_url']['name']);
                 $ext2 = end($temp2);
                 $temp3 = explode(".", $data['photo3_url']['name']);
                 $ext3 = end($temp3);
                 $temp4 = explode(".", $data['photo4_url']['name']);
                 $ext4 = end($temp4);
                 $ress = $this->uploadFile($data['photo1_url'],$ph1);
                 $this->uploadFile($data['photo2_url'],$ph2);
                 $this->uploadFile($data['photo3_url'],$ph3);
                 $this->uploadFile($data['photo4_url'],$ph4);
                 $data['photo1_url'] = ((string)$ress)."/yaoweb/img/".$ph1.".".$ext1;
                 $data['photo2_url'] = "/yaoweb/img/".$ph2.".".$ext2;
                 $data['photo3_url'] = "/yaoweb/img/".$ph3.".".$ext3;
                 $data['photo4_url'] = "/yaoweb/img/".$ph4.".".$ext4;
                 $productpage->populate($data);
                 $this->getEntityManager()->persist($productpage);
                 $this->getEntityManager()->flush();

                 // Redirect to list of cusomers
                 return $this->redirect()->toRoute('productpage');
             }
         }
         return array('form' => $form);

    }

    public function editAction()
    {
    $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
         if (!$id) {
             return $this->redirect()->toRoute('productpage', array(
                 'action' => 'add'
             ));
         }

    $productpage = $this->getEntityManager()->find('ProductPage\Entity\ProductPage',$id);
        
    $form  = new ProductPageForm();
    $form->setBindOnValidate(false);
    $form->bind($productpage);
    $form->get('submit')->setAttribute('label', 'Edit');

    $request = $this->getRequest();
    if ($request->isPost()) {
           $form->setData($request->getPost());
           if ($form->isValid()) {
                 $form->bindValues();
                 $this->getEntityManager()->flush();
                 // Redirect to list of productpage
                 return $this->redirect()->toRoute('productpage');
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
           return $this->redirect()->toRoute('productpage');
      }
      $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $productpage = $this->getEntityManager()->find('ProductPage\Entity\ProductPage',$id);
                 if ($productpage) {
                    $this->getEntityManager()->remove($productpage);
                    $this->getEntityManager()->flush();
                 }
              }
           
             return $this->redirect()->toRoute('productpage');
         }

         return array(
             'id'    => $id,
             'productpage' => $this->getEntityManager()->find('ProductPage\Entity\ProductPage',$id));
     
    }
    
    public function showAction()
    {
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
    if (file_exists($_SERVER['DOCUMENT_ROOT']."/img/".$file_name.".".$extension))
      {
       $err = true;
      }
    else
      {
     $k = move_uploaded_file($file['tmp_name'],
      $_SERVER['DOCUMENT_ROOT']."/img/".$file_name.".".$extension);
      $err = false;
      }
    }
   }
   else
   {
     $err =  true;
   }
   return $file['error'];
 }   
}
?>
