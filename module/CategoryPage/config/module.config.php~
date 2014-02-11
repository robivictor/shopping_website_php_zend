<?php
namespace CategoryPage;

return array(
     'controllers' => array(
            'invokables' => array(
                'CategoryPage\Controller\CategoryPage' => 'CategoryPage\Controller\CategoryPageController',
             ),
           ),
      'router' => array(
             'routes' => array(
                 'categorypage' => array(
                      'type' => 'segment',
                      'options' => array(
                         'route' => '/categorypage[/][:action][/:id]',
                         'constraints' => array(
                               'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                               'id'     => '[0-9]*',
                         ),
                         'defaults' => array(
                               'controller' => 'CategoryPage\Controller\CategoryPage',
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
                'categorypage' => __DIR__.'/../view',
            ),
           ),
      );
?>              
