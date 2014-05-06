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
use Zend\Mvc\Controller\AbstractActionController;
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
class AdminAclController extends AbstractActionController
{
    /**
     * indexAction
     *
     * @return array
     */
    public function indexAction()
    {
        $viewArr = array(
            'errorMessage' => null,
        );

        /* + TEST +++++++++++++++++++++++++ */
        echo "<pre>";
        $rcmUserService = $this->getServiceLocator()->get(
            'RcmUser\Service\RcmUserService'
        );
        $aclResourceService = $this->getServiceLocator()->get(
            'RcmUser\Acl\Service\AclResourceService'
        );
        $userAuthorizeService = $rcmUserService->getUserAuthorizeService();

        $aclResourceService = $this->getServiceLocator()->get(
            'RcmUser\Acl\Service\AclResourceService'
        );
        $bauthorize = $userAuthorizeService->getAuthorize();
        $acl = $bauthorize->getAcl();

        $resources = $aclResourceService->getRuntimeResources();
        $resources = $acl->getResources();

        $rootResource = $aclResourceService->getRootResource();
        $rootPrivileges = $aclResourceService->getRootPrivilege();

        var_export($resources);



        $user = new User();
        $user->setUsername('adminTest');
        $user->setPassword('123123123');
        $user->setState('enabled');

        //$rcmUserService->createUser($user);
        $rcmUserService->authenticate($user);
        //$rcmUserService->clearIdentity();
        //var_dump($rcmUserService->getIdentity());
        //var_dump($this->rcmUserIsAllowed('acl-management'));
        echo "</pre>";
        /* - TEST ------------------------ */

        if (!$this->rcmUserIsAllowed('acl-management')) {

            $this->getResponse()->setStatusCode(401);

            return $this->getResponse();
        }

        return $this->buildView($viewArr);
    }

    protected function getResourceArray($resources, $rootResource, $rootPrivileges)
    {

    }

    protected function buildView($viewArr = array())
    {

        $view = new ViewModel($viewArr);

        return $view;
    }

} 