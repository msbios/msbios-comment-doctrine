<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Comment\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Comment\Doctrine\Controller\CommentController;
use MSBios\Comment\Doctrine\Form\CommentForm;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CommentControllerFactory
 * @package MSBios\Comment\Doctrine\Factory
 */
class CommentControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return CommentController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CommentController(
            $container->get(EntityManager::class),
            $container->get('FormElementManager')->get(CommentForm::class)
        );
    }
}
