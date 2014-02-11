<?php
namespace CategoryPage;

use CategoryPage\Model\CategoryPage;
use CategoryPage\Model\CategoryPageTable;
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
                 'CategoryPage\Model\CategoryPageTable' =>  function($sm) {
                     $tableGateway = $sm->get('CategoryPageTableGateway');
                     $table = new CategoryPageTable($tableGateway);
                     return $table;
                 },
                 'CategoryPageTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new CategoryPage());
                     return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }

?>
