<?php
namespace ProductPage;

return array(
     'controllers' => array(
            'invokables' => array(
                'ProductPage\Controller\ProductPage' => 'ProductPage\Controller\ProductPageController',
             ),
           ),
      'router' => array(
             'routes' => array(
                 'productpage' => array(
                      'type' => 'segment',
                      'options' => array(
                         'route' => '/productpage[/][:action][/:id]',
                         'constraints' => array(
                               'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                               'id'     => '[0-9]*',
                         ),
                         'defaults' => array(
                               'controller' => 'ProductPage\Controller\ProductPage',
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
                'productpage' => __DIR__.'/../view',
            ),
           ),
      );
?>              
