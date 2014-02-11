<?php
namespace CategoryPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;  
use CategoryPage\Form\CategoryPageForm;
use Doctrine\ORM\EntityManager;
use CategoryPage\Entity\CategoryPage;
use ShoppingCart\Model\ShoppingCart;
use Home\Form\SearchForm;

class CategoryPageController extends AbstractActionController
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
            'products'     => $this->getEntityManager()->getRepository('ProductPage\Entity\ProductPage')->findBy(array('category_id'=>$id)),
            'categories'   => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form, 
     ));
    }

    public function addAction()
    {
         $form = new CategoryPageForm();
         $form->get('submit')->setAttribute('label','Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $categorypage = new CategoryPage();
             $form->setInputFilter($categorypage->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $categorypage->populate($form->getData());
                 $this->getEntityManager()->persist($categorypage);
                 $this->getEntityManager()->flush();

                 // Redirect to list of cusomers
                 return $this->redirect()->toRoute('categorypage');
             }
         }
         return array('form' => $form);

    }

    public function editAction()
    {
    $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
         if (!$id) {
             return $this->redirect()->toRoute('categorypage', array(
                 'action' => 'add'
             ));
         }

    $categorypage = $this->getEntityManager()->find('CategoryPage\Entity\CategoryPage',$id);
        
    $form  = new CategoryPageForm();
    $form->setBindOnValidate(false);
    $form->bind($categorypage);
    $form->get('submit')->setAttribute('label', 'Edit');

    $request = $this->getRequest();
    if ($request->isPost()) {
           $form->setData($request->getPost());
           if ($form->isValid()) {
                 $form->bindValues();
                 $this->getEntityManager()->flush();
                 // Redirect to list of category-page
                 return $this->redirect()->toRoute('categorypage');
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
           return $this->redirect()->toRoute('categorypage');
      }
      $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $categorypage = $this->getEntityManager()->find('CategoryPage\Entity\CategoryPage',$id);
                 if ($categorypage) {
                    $this->getEntityManager()->remove($categorypage);
                    $this->getEntityManager()->flush();
                 }
              }
           
             return $this->redirect()->toRoute('categorypage');
         }

         return array(
             'id'    => $id,
             'categorypage' => $this->getEntityManager()->find('CategoryPage\Entity\CategoryPage',$id));
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
}
?>
