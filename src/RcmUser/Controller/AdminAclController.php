<?php
/**
 * AdminAclController.php
 *
 * AdminAclController
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Controller
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Controller;

use RcmUser\User\Entity\User;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;


/**
 * Class AdminAclController
 *
 * AdminAclController
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Controller
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AdminAclController extends AbstractAdminController
{
    /**
     * indexAction
     *
     * @return array
     */
    public function indexAction()
    {
        /* + TEST +++++++++++++++++++++++++ */
        echo "<pre>";
        $rcmUserService = $this->getServiceLocator()->get(
            'RcmUser\Service\RcmUserService'
        );
        $aclResourceService = $this->getServiceLocator()->get(
            'RcmUser\Acl\Service\AclResourceService'
        );
        /**
         * @var \RcmUser\Acl\Service\AuthorizeService $AuthorizeService
         */
        //$rcmUserService->getUserAuthAuthorizeService()
        //var_dump($userAuthorizAuthorizeService);
        //$acl = $userAuthorizeSerAuthorizeService
        //var_dump($acl->getResources());
        //var_dump($acl->getRoles());
        //var_dump($acl->getRoleRegistry());
        //var_dump($acl->getRules());

        //$bauthorize = $authorizeService->getAuthorize();
        //var_dump($bauthorize->getIdentity());
        //$acl = $bauthorize->getAcl();


        $user = new User();
        $user->setUsername('adminTest');
        $user->setPassword('123123123');
        //$user->setState('enabled');

        //$rcmUserService->createUser($user);
        $rcmUserService->clearIdentity();
        $rcmUserService->authenticate($user);
        //$rcmUserService->clearIdentity();
        //var_dump($rcmUserService->getIdentity());
        //
        //var_dump(
        //    "Has ACCESS: ",
        //    $this->rcmUserIsAllowed('rcmuser-acl-administration')
        //);
        echo "</pre>";
        /* - TEST ------------------------ */

        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-acl-administration')) {
            return $this->getNotAllowedResponse();
        }

        $viewArr = array();

        return $this->buildView($viewArr);
    }

    /**
     * buildView
     *
     * @param array $viewArr viewArr
     *
     * @return ViewModel
     */
    protected function buildView($viewArr = array())
    {
        $view = new ViewModel($viewArr);

        return $view;
    }

} 