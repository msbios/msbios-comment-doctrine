<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Comment\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Comment\Doctrine\Form\CommentForm;
use MSBios\Comment\Doctrine\InputFilter\CommentInputFilter;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CommentFormFactory
 * @package MSBios\Comment\Doctrine\Factory
 */
class CommentFormFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return object|\Zend\Form\Form
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return (new CommentForm)
            ->setInputFilter($container->get('InputFilterManager')->get(CommentInputFilter::class));
    }
}
