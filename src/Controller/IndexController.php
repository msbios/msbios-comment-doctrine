<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Comment\Doctrine\Controller;

use MSBios\Guard\GuardInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class IndexController
 * @package MSBios\Comment\Doctrine\Controller
 */
class IndexController extends AbstractActionController implements GuardInterface
{
    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {

            /** @var array $data */
            $data = $this->params()->fromPost();

            if ($this->comment()->validate($data)) {
                 $this->flashMessenger()->addSuccessMessage('Your comment has been added.');
                 return $this->redirect()->toRoute('home');
            }
        }

        return parent::indexAction();
    }
}
