<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Comment\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Comment\Doctrine\Controller\Plugin\CommentPlugin;
use MSBios\Comment\Doctrine\Form\CommentForm;
use Zend\Mvc\Plugin\Identity\Identity;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CommentPluginFactory
 * @package MSBios\Comment\Doctrine\Factory
 */
class CommentPluginFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return CommentPlugin
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CommentPlugin(
            $container->get('FormElementManager')->get(CommentForm::class),
            $container->get('ControllerPluginManager')->get(Identity::class),
            $container->get('Request')
        );
    }
}
