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
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Widget\RendererWidgetAwareInterface;
use MSBios\Widget\RendererWidgetAwareTrait;
use MSBios\Widget\WidgetInterface;
use Zend\Form\FormInterface;
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

    /** @var  FormInterface */
    protected $formElement;

    /**
     * MessageWidget constructor.
     * @param ObjectManager $dem
     * @param FormInterface $formElement
     */
    public function __construct(ObjectManager $dem, FormInterface $formElement)
    {
        $this->setObjectManager($dem);
        $this->formElement = $formElement;
    }

    /**
     * @param null $data
     * @return string
     * @throws \Exception
     */
    public function output($data = null)
    {
        if (! isset($data['refid'], $data['reftype'])) {
            throw new InvalidArgumentException('You missed some of the required parameters');
        }

        /** @var ObjectRepository $repository */
        $repository = $this->getObjectManager()
            ->getRepository(Comment::class);

        /** @var array $defaultValues */
        $defaultValues = [
            'refId' => $data['refid'],
            'refType' => $data['reftype']
        ];

        /** @var array $result */
        $result = $repository->findBy($defaultValues, [
            'postdate' => 'DESC'
        ]);

        /** @var ModelInterface $viewModel */
        $viewModel = new ViewModel([
            'form' => $this->formElement->setData($defaultValues),
            'comments' => $result
        ]);

        $viewModel->setTemplate('comment/messages');
        return $this->render($viewModel);
    }
}
