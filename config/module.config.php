<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'SanUpload\Controller\Profile' => 'SanUpload\Controller\ProfileController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'SanUpload' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/upload',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'SanUpload\Controller',
                        'controller'    => 'Profile',
                        'action'        => 'add',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'SanUpload' => __DIR__ . '/../view',
        ),
    ),
);
