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
        var_dump($acl->getResources());
        var_dump($acl->getRoles());
        //var_dump($acl->getRules());

        $user = new User();
        $user->setUsername('adminTest');
        $user->setPassword('123123123');
        //$user->setState('enabled');

        //$rcmUserService->createUser($user);
        $rcmUserService->clearIdentity();
        $rcmUserService->authenticate($user);
        //$rcmUserService->clearIdentity();
        var_dump($rcmUserService->getIdentity());
        var_dump("Has ACCESS: ", $this->rcmUserIsAllowed('rcmuser-acl-administration'));
        echo "</pre>";
        /* - TEST ------------------------ */

        if (!$this->rcmUserIsAllowed('rcmuser-acl-administration')) {

            $response = $this->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_401);
            $response->setContent($response->renderStatusLine());

            return $response;
        }

        $viewArr = array();

        $aclResourceService = $this->getServiceLocator()->get(
            'RcmUser\Acl\Service\AclResourceService'
        );

        $aclDataService = $this->getServiceLocator()->get(
            'RcmUser\Acl\AclDataService'
        );

        $rules = $aclDataService->fetchRulesAll()->getData();
        var_dump($rules);

        $resources = $aclResourceService->getResources(true);
        var_dump($resources);

        $roles = $aclDataService->fetchAllRoles();
        var_dump($roles);


        //$viewArr['resources'] = $this->getResourceArray(
        //    $resources,
        //    $rootResource
        //);
        // @todo get level
        $viewArr['roles'] = $roles->getData();

        return $this->buildView($viewArr);
    }

    /**
     * getResourceArray - recursive call to get resources for view friendly array
     * @return array
     */
    protected function getResourceArray() {

    }

    protected function buildView($viewArr = array())
    {
        $view = new ViewModel($viewArr);

        return $view;
    }

} 