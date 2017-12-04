<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Comment\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Interop\Container\ContainerInterface;
use MSBios\Comment\Doctrine\Entity\Comment;
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
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return (new CommentForm)
            //->setObject(new Comment)
            // ->setHydrator(new DoctrineObject($container->get(EntityManager::class)))
            ->setInputFilter($container->get('InputFilterManager')->get(CommentInputFilter::class));
    }
}
