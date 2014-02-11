<?php
namespace ShoppingCart;

use ShoppingCart\Model\ShoppingCart;
use ShoppingCart\Model\ShoppingCartTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
  public function getAutoloaderConfig()
  {
      return array('Zend\Loader\ClassMapAutoloader' => array(
                    __DIR__.'/autoload_classmap.php',
                    ),
                    'Zend\Loader\StandardAutoLoader' => array(
                           'namespaces' => array(
                         __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                         ),
                        ),
                       );
  }  
 
  public function getConfig()
  {
      return include __DIR__.'/config/module.config.php';
  }
  
  public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'ShoppingCart\Model\ShoppingCartTable' =>  function($sm) {
                     $tableGateway = $sm->get('ShoppingCartTableGateway');
                     $table = new ShoppingCartTable($tableGateway);
                     return $table;
                 },
                 'ShoppingCartTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new ShoppingCart());
                     return new TableGateway('shopping_cart', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }

?>
