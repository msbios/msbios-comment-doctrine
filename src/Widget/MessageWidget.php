<?php
/**
 * @access
 */

namespace MSBios\Comment\Doctrine\Widget;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Comment\Doctrine\Entity\Comment;
use MSBios\Comment\Doctrine\Exception\InvalidArgumentException;
use MSBios\Comment\Doctrine\Form\CommentForm;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Widget\RendererWidgetAwareInterface;
use MSBios\Widget\RendererWidgetAwareTrait;
use MSBios\Widget\WidgetInterface;
use Zend\Form\FormElementManager\FormElementManagerV3Polyfill;
use Zend\Form\FormInterface;
use Zend\ServiceManager\PluginManagerInterface;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

/**
 * Class MessageWidget
 * @package MSBios\Comment\Doctrine\Widget
 */
class MessageWidget implements
    WidgetInterface,
    RendererWidgetAwareInterface,
    ObjectManagerAwareInterface
{
    use RendererWidgetAwareTrait;
    use ObjectManagerAwareTrait;

    /** @var PluginManagerInterface|FormElementManagerV3Polyfill */
    protected $formElementManager;

    /**
     * MessageWidget constructor.
     * @param ObjectManager $dem
     * @param PluginManagerInterface $formElementManager
     */
    public function __construct(ObjectManager $dem, PluginManagerInterface $formElementManager)
    {
        $this->setObjectManager($dem);
        $this->formElementManager = $formElementManager;
    }

    /**
     * @param null $data
     * @param array $defaultValues
     * @return string
     */
    public function output($data = null, array $defaultValues = [])
    {
        if (! isset($data['refId'], $data['refType'])) {
            throw new InvalidArgumentException('You missed some of the required parameters');
        }

        /** @var ObjectRepository $repository */
        $repository = $this->getObjectManager()
            ->getRepository(Comment::class);

        /** @var array $result */
        $result = $repository->findBy($data, [
            'postdate' => 'DESC'
        ]);

        /** @var array $defaultValues */
        $data = ArrayUtils::merge($data, $defaultValues);

        /** @var FormInterface|CommentForm $form */
        $form = $this->formElementManager
            ->get(CommentForm::class);
        $form->setData($data);

        /** @var ModelInterface $viewModel */
        $viewModel = new ViewModel([
            'form' => $form, 'comments' => $result
        ]);

        $viewModel->setTemplate('comment/messages');
        return $this->render($viewModel);
    }
}
