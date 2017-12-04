<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Comment\Doctrine\Form;

use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

/**
 * Class CommentForm
 * @package MSBios\Comment\Doctrine\Form
 */
class CommentForm extends Form
{
    /** @const IDENTIFIER */
    const IDENTIFIER = self::class;

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->add([
            'type' => Textarea::class,
            'name' => 'message'
        ])->add([
            'type' => Checkbox::class,
            'name' => 'anonymously',
            'use_hidden_element' => false,
            'checked_value' => 1,
            'unchecked_value' => 0
        ])->add([
            'type' => Hidden::class,
            'name' => 'refId'
        ])->add([
            'type' => Hidden::class,
            'name' => 'refType'
        ])->add([
            'type' => Csrf::class,
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600,
                ],
            ],
        ])->add([
            'type' => Submit::class,
            'name' => 'handler',
            'attributes' => [
                'value' => self::IDENTIFIER
            ]
        ]);
    }
}
