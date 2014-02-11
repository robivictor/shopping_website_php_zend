<?php
namespace Auth\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Entity\User; 
use Auth\Form\LoginForm; 
use Auth\Form\UserForm; 
use Zend\Session\Container;     
use Zend\Crypt\Password\Bcrypt;

class AuthController extends AbstractActionController
{

protected $em;

    public function indexAction()
    {
        $form = new LoginForm();
         $form->get('submit')->setAttribute('label','Login');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $user = new User();
             $form->setInputFilter($user->getInputFilter());
             $form->setData($request->getPost());
 
             if ($form->isValid()) {
                $data = $form->getData();
                $user =  $this->getEntityManager()->getRepository('Auth\Entity\User')->findOneBy(array ('username'=> $data['username']));
                $bcrypt = new Bcrypt();
                $dbpassword = $user->password;
                $inpassword = $data['password'];
                try
                {
                   if ($bcrypt->verify($inpassword, $dbpassword))
                   {
                     $user_session = new Container('user');
		     $user_session->username = $user->username;
                     return $this->redirect()->toRoute('home');
                   }   
                }
                catch(Exception $e)
                {
                  
                }             
             }
         }
         return array('form' => $form);
    }
	
    public function loginAction()
    {
       



    }
	
    public function logoutAction()
    {
	
	
    }	
       
    public function addAction()
    {
         $form = new UserForm();
         $form->get('submit')->setAttribute('label','Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $user = new User();
             $form->setInputFilter($user->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $data =  $form->getData();
                 $bcrypt =  new Bcrypt();
                 $data['password'] = $bcrypt->create($data['password']); 
                 $user->populate($data);
                 $this->getEntityManager()->persist($user);
                 $this->getEntityManager()->flush();
                 return $this->redirect()->toRoute('login');
             }
         }
         return array('form' => $form);
    }
		 
    public function getEntityManager()
    {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
    }
}
