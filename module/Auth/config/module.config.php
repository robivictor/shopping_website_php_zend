<?php
namespace Auth;

return array(
     'controllers' => array(
            'invokables' => array(
                'Auth\Controller\Auth' => 'Auth\Controller\AuthController',
             ),
           ),
      'router' => array(
             'routes' => array(
                 'login' => array(
                      'type' => 'segment',
                      'options' => array(
                         'route' => '/login[/][:action][/:id]',
                         'constraints' => array(
                               'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                               'id'     => '[0-9]*',
                         ),
                         'defaults' => array(
                               'controller' => 'Auth\Controller\Auth',
                               'action'     => 'index',
                          ),
                     ),
                   ),
                 ),
               ),       
         
       'doctrine' => array(
          'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
         
        'view_manager' => array(
        'template_map' => array(
                'layout/layout'  => __DIR__ . '/../view/layout/layout.phtml'
        ),
          'template_path_stack' => array(
                'login' => __DIR__.'/../view',
            ),
           ),
      );
?>              
