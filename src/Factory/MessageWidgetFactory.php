<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Comment\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Comment\Doctrine\Widget\MessageWidget;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class MessageWidgetFactory
 * @package MSBios\Comment\Doctrine\Factory
 */
class MessageWidgetFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return MessageWidget
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MessageWidget(
            $container->get(EntityManager::class),
            $container->get('FormElementManager')
        );
    }
}
