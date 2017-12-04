<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Comment\Doctrine\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

/**
 * Class CommentInputFilter
 * @package MSBios\Comment\Doctrine\InputFilter
 */
class CommentInputFilter extends InputFilter
{
    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->add([
            'name' => 'message',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ], [
                    'name' => StripTags::class,
                ],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 500
                    ]
                ]
            ]
        ])->add([
            'name' => 'anonymously',
            'required' => true
        ])->add([
            'name' => 'refId',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ], [
                    'name' => StripTags::class,
                ], [
                    'name' => ToInt::class,
                ],
            ],
        ])->add([
            'name' => 'refType',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ], [
                    'name' => StripTags::class,
                ],
            ],
        ])->add([
            'name' => 'handler',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ], [
                    'name' => StripTags::class,
                ],
            ]
        ]);
    }
}
