<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Comment\Doctrine;

use MSBios\Doctrine\Initializer\ObjectManagerInitializer;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'types' => [
                    // ...
                ],
            ],
        ],

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
                    Entity::class => Module::class
                ]
            ],
        ],

        'entity_resolver' => [
            'orm_default' => [
                'resolvers' => [
                    // ...
                ],
            ],
        ],
    ],

    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\CommentPlugin::class =>
                Factory\CommentPluginFactory::class,
        ],
        'aliases' => [
            'comment' =>
                Controller\Plugin\CommentPlugin::class
        ],
        'initializers' => [
            new ObjectManagerInitializer
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
