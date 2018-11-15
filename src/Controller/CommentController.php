<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Comment\Doctrine\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use MSBios\Authentication\IdentityInterface;
use MSBios\Comment\Doctrine\Entity\Comment;
use MSBios\Comment\Doctrine\Form\CommentForm;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class CommentController
 * @package MSBios\Comment\Doctrine\Controller
 */
class CommentController extends AbstractActionController implements ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /** @var CommentForm */
    protected $form;

    /** @const EVENT_COMMENT */
    const EVENT_COMMENT = 'EVENT_COMMENT';

    /** @const EVENT_COMMENT_ERROR */
    const EVENT_COMMENT_ERROR = 'EVENT_COMMENT_ERROR';

    /**
     * CommentController constructor.
     * @param ObjectManager $objectManager
     * @param CommentForm $form
     */
    public function __construct(ObjectManager $objectManager, CommentForm $form)
    {
        $this->setObjectManager($objectManager);
        $this->form = $form;
    }

    /**
     * @return \Zend\Http\Response
     */
    public function indexAction()
    {
        if ($this->getRequest()->isPost() && $identity = $this->identity()) {
            if ($this->form->setData($this->params()->fromPost())->isValid()) {
                /** @var array $data */
                $data = $this->form->getData();

                /** @var ObjectManager $dem */
                $dem = $this->getObjectManager();

                /** @var EntityInterface $comment */
                $comment = (new DoctrineObject($dem))
                    ->hydrate($data, new Comment);

                /** @var IdentityInterface $identity */
                $comment->setAuthor(implode(' ', [
                    $identity->getFirstname(),
                    $identity->getLastname()
                ]));

                $comment->setAuthorip(
                    $this->getRequest()->getServer()->get('REMOTE_ADDR')
                );

                /** @var EntityInterface $object */
                $dem->persist($comment);
                $dem->flush();

                $this->flashMessenger()
                    ->addSuccessMessage('Your comment has been added.');

                $this->getEventManager()
                    ->trigger(self::EVENT_COMMENT, $this, ['form' => $this->form]);

                if ($redirect = $this->params()->fromRoute('redirect', $data['redirect'])) {
                    return $this->redirect()
                        ->toUrl(base64_decode($redirect));
                }
            } else {
                $this->getEventManager()
                    ->trigger(self::EVENT_COMMENT_ERROR, $this, ['form' => $this->form]);
            }
        }

        return $this->redirect()->toRoute('home');
    }
}
