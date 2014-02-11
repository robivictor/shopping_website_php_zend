<?php
namespace ShoppingCart\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;  
use ShoppingCart\Form\ShoppingCartForm;
use Doctrine\ORM\EntityManager;
use ShoppingCart\Model\ShoppingCart;
use Home\Form\SearchForm;
use ShoppingCart\Form\CreditCardForm;
use ShoppingCart\Entity\CreditCard;

class ShoppingCartController extends AbstractActionController
{
protected $em;

    public function removeAction()
    {
       $shoppingcart = new ShoppingCart();
       $shoppingcart->startSession();
       $id =  $this->params('id');    
       $shoppingcart->removeItem($id,$number);
       return $this->redirect()->toRoute('shoppingcart', array(
                 'action' => 'show'
             ));
    }  
    public function addToCartAction()
    {
       $shoppingcart = new ShoppingCart();
       $shoppingcart->startSession();
       $id =  $this->params('id');
       $product = $this->getEntityManager()->getRepository('ProductPage\Entity\ProductPage')->findOneBy(array('id'=>$id));
       $shoppingcart->addItem($id,$product->product_name,$product->price,1);
       return $this->redirect()->toRoute('productpage', array(
                 'action' => 'index', 'id'=>$id
             ));

    }

    public function showAction()
    {
         $shoppingcart =  new ShoppingCart();
         $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
         $form = new SearchForm($ee);
return new ViewModel(array(
            'categories'   => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     )); 
    } 

   public function setEntityManager(EntityManager $em)
    {
      $this->em = $em;
    }

    public function initexpAction()
    {
       $sc = new ShoppingCart();
       $result = $sc->initExpressCheckout();
       if($result)
           $this->plugin('redirect')->toUrl($result);
       return false; 
      
    }

    public function creditcardAction()
    {
///
         $shoppingcart =  new ShoppingCart();
         $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
         $form = new SearchForm($ee);
///
         $creditform = new CreditCardForm();      
         $request = $this->getRequest();
         if ($request->isPost()) {
             $credit_card = new CreditCard();
             $creditform->setInputFilter($credit_card->getInputFilter());
             $post = array_merge_recursive(
                  $request->getPost()->toArray()
             );
             $creditform->setData($post);
             if ($creditform->isValid()) { 
                 $data = $creditform->getData(); 
                 $customer_data = array
				(
				'card_type' => $data['card_type'],
				'acct' => $data['acct'],				
		            'expdate' => $data['expmonth'].$data['expyear'], 
			 	'cvv2' => $data['cvv2'],
				'first_name' => $data['first_name'], 
				'last_name' => $data['last_name'],
				'street' => $data['street'],
				'city' => $data['city'],
				'state' => $data['state'],				
				'country_code' => $data['country'],
				'zip' => $data['zip'],
				'amt' => '3.00',
				'currency_code' => 'USD', 
				'desc' => 'Description'
				);  
    
                 $credit_card->populate($data);
                 $this->getEntityManager()->persist($credit_card);
                 $this->getEntityManager()->flush();
                 
                 $sc = new shoppingCart();
	           $payresults = $sc->processDirectPayment($customer_data);
                 return $this->redirect()->toRoute('shoppingcart', array(
                 'action' => 'paysuccess'
             ));
            }
         }
         $view =  new ViewModel(array(
            'categories'   => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
            'creditform'   => $creditform 
     )); 
         return $view;      
    }

    public function paysuccessAction()
    {
         $shoppingcart =  new ShoppingCart();
         $ee = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
         $form = new SearchForm($ee);
return new ViewModel(array(
            'categories'   => $this->getEntityManager()->getRepository('CategoryPage\Entity\CategoryPage')->findAll(),
            'shoppingcart' => $shoppingcart,
            'form'         => $form,
     )); 
    }

    public function processexpAction()
    {
        $sc = new shoppingCart();
        $result = $sc->processExpressCheckout();
//        if($result)
//        {
          return new ViewModel(array(
            'result' => $result
         )); 
//         }

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
