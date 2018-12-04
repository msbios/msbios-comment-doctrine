<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Comment\Doctrine;

use Zend\Router\Http\Method;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'router' => [
        'routes' => [
            'home' => [
                'may_terminate' => true,
                'child_routes' => [
                    'comment' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'comment[/[:redirect]]',
                            'defaults' => [
                                'controller' => Controller\CommentController::class,
                                'action' => 'index',
                            ],
                            'constraints' => [
                                'redirect' => '[a-zA-Z0-9+/]+={0,2}'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            [
                                'type' => Method::class,
                                'options' => [
                                    'verb' => 'post'
                                ]
                            ]
                        ]
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\CommentController::class =>
                Factory\CommentControllerFactory::class,
        ]
    ],

    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            Module::class => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    Entity::class =>
                        Module::class
                ]
            ],
        ],
    ],

    'form_elements' => [
        'factories' => [
            Form\CommentForm::class =>
                Factory\CommentFormFactory::class
        ]
    ],

    'input_filters' => [
        'factories' => [
            InputFilter\CommentInputFilter::class =>
                InvokableFactory::class
        ]
    ],

    'widget_manager' => [
        'factories' => [
            Widget\MessageWidget::class =>
                Factory\MessageWidgetFactory::class
        ]
    ],

    \MSBios\Widget\Module::class => [
        'template_map' => [
            'comment/messages' =>
                __DIR__ . '/../widget/comment/messages.phtml'
        ],
    ],
];
