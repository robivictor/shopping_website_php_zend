<?php
namespace Home;

use Home\Model\Home;
use Home\Model\HomeTable;
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
                 'Home\Model\HomeTable' =>  function($sm) {
                     $tableGateway = $sm->get('HomeTableGateway');
                     $table = new HomeTable($tableGateway);
                     return $table;
                 },
                 'HomeTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Home());
                     return new TableGateway('home', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }

?>
