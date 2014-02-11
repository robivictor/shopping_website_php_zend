<?php
namespace ProductPage;

use ProductPage\Model\ProductPage;
use ProductPage\Model\ProductPageTable;
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
                 'ProductPage\Model\ProductPageTable' =>  function($sm) {
                     $tableGateway = $sm->get('ProductPageTableGateway');
                     $table = new ProductPageTable($tableGateway);
                     return $table;
                 },
                 'ProductPageTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new ProductPage());
                     return new TableGateway('productpage', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }

?>
