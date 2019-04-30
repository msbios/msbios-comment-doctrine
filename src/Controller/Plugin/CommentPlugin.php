<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Comment\Doctrine\Controller\Plugin;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use MSBios\Authentication\IdentityInterface;
use MSBios\Comment\Doctrine\Entity\Comment;
use MSBios\Resource\Doctrine\EntityInterface;
use Zend\Form\FormInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Controller\Plugin\PluginInterface;
use Zend\Stdlib\RequestInterface;

/**
 * Class CommentPlugin
 * @package MSBios\Comment\Doctrine\Controller\Plugin
 */
class CommentPlugin extends AbstractPlugin implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    /** @var FormInterface */
    protected $form;

    /** @var PluginInterface */
    protected $identity;

    /** @var RequestInterface */
    protected $request;

    /**
     * CommentPlugin constructor.
     *
     * @param FormInterface $form
     * @param PluginInterface $identity
     * @param RequestInterface $request
     */
    public function __construct(FormInterface $form, PluginInterface $identity, RequestInterface $request)
    {
        $this->form = $form;
        $this->identity = $identity;
        $this->request = $request;
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data)
    {
        if ($this->form->setData($data)->isValid()) {

            /** @var array $value */
            $value = $this->form->getData();

            /** @var HydratorInterface $hydrator */
            $hydrator = new DoctrineObject($this->getObjectManager());

            /** @var EntityInterface $object */
            $object = $hydrator->hydrate($value, new Comment);

            /** @var IdentityInterface $identity */
            $identity = ($this->identity)();
            $object->setAuthor(implode(' ', [
                $identity->getFirstname(),
                $identity->getLastname()
            ]));

            $object->setAuthorip(
                $this->request->getServer()->get('REMOTE_ADDR')
            );

            /** @var ObjectManager $objectManager */
            $objectManager = $this->getObjectManager();

            /** @var EntityInterface $object */
            $objectManager->persist($object);
            $objectManager->flush();

            return true;
        }

        return false;
    }

    /**
     * @return array|object
     */
    public function values()
    {
        return $this->form->isValid() ?
            $this->form->getData() : [];
    }
}
