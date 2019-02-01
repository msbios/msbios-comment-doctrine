<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Comment\Doctrine\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use MSBios\Comment\Doctrine\Entity\Comment;
use MSBios\Comment\Doctrine\Form\CommentForm;
use MSBios\Form\FormElementManagerAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\PluginManagerInterface;

/**
 * Class CommentController
 * @package MSBios\Comment\Doctrine\Controller
 */
class CommentController extends AbstractActionController implements ObjectManagerAwareInterface
{
    use FormElementManagerAwareTrait;
    use ProvidesObjectManager;

    /** @const EVENT_COMMENT */
    const EVENT_COMMENT = 'EVENT_COMMENT';

    /** @const EVENT_COMMENT_ERROR */
    const EVENT_COMMENT_ERROR = 'EVENT_COMMENT_ERROR';

    /**
     * CommentController constructor.
     *
     * @param PluginManagerInterface $formElementManager
     */
    public function __construct(PluginManagerInterface $formElementManager)
    {
        $this->setFormElementManager($formElementManager);
    }

    /**
     * @inheritdoc
     *
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        if ($this->getRequest()->isPost() && $identity = $this->identity()) {

            /** @var array $argv */
            $argv = [
                'form' => $this->getFormElementManager()->get(CommentForm::class),
                'data' => $this->params()->fromPost()
            ];

            if ($argv['form']->setData($argv['data'])->isValid()) {

                /** @var array $values */
                $values = $argv['form']->getData();

                /** @var ObjectManager $dem */
                $dem = $this->getObjectManager();

                $argv['entity'] = (new DoctrineObject($dem))
                    ->hydrate($values, new Comment);

                $argv['entity']->setAuthor(implode(' ', [
                    $identity->getFirstname(),
                    $identity->getLastname()
                ]));

                $argv['entity']->setAuthorip(
                    $this->getRequest()->getServer()->get('REMOTE_ADDR')
                );

                $dem->persist($argv['entity']);
                $dem->flush();

                $this->flashMessenger()
                    ->addSuccessMessage('Your comment has been added.');

                $this->getEventManager()
                    ->trigger(self::EVENT_COMMENT, $this, $argv);

                if ($redirect = $this->params()->fromRoute('redirect', $values['redirect'])) {
                    return $this->redirect()
                        ->toUrl(base64_decode($redirect));
                }
            } else {
                $this->getEventManager()
                    ->trigger(self::EVENT_COMMENT_ERROR, $this, $argv);
            }
        }

        return $this
            ->redirect()
            ->toRoute('home');
    }
}
