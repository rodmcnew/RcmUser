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
        $resources = $acl->getResources();
        var_dump($resources);

        $user = new User();
        $user->setUsername('adminTest');
        $user->setPassword('123123123');
        //$user->setState('enabled');

        //$rcmUserService->createUser($user);
        //$rcmUserService->clearIdentity();
        $rcmUserService->authenticate($user);
        //$rcmUserService->clearIdentity();
        //var_dump($rcmUserService->getIdentity());
        var_dump("Has ACCESS: ", $this->rcmUserIsAllowed('role-administration', 'read'));
        echo "</pre>";
        /* - TEST ------------------------ */

        if (!$this->rcmUserIsAllowed('role-administration')) {

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

        $resources = $aclResourceService->getRuntimeResources();
        var_dump($resources);
        $rootResource = $aclResourceService->getRootResource();
        $rootPrivileges = $aclResourceService->getRootPrivilege();
        $roles = $aclDataService->fetchAllRoles();

        $viewArr['resources'] = $this->getResourceArray(
            $resources,
            $rootResource,
            $rootPrivileges
        );
        $viewArr['rootResource'] = $rootResource;
        $viewArr['rootPrivileges'] = $rootPrivileges;
        // @todo get level
        $viewArr['roles'] = $roles->getData();

        var_dump($viewArr['resources']);

        return $this->buildView($viewArr);
    }

    /**
     * getResourceArray - recursive call to get resources for view friendly array
     *
     * @param       $resources
     * @param       $rootResource
     * @param       $rootPrivileges
     * @param array $parsedResources
     * @param int   $level
     *
     * @return array
     */
    protected function getResourceArray(
        $resources,
        $rootResource,
        $rootPrivileges,
        $parsedResources = array(),
        $level = 0
    ) {
        foreach ($resources as $key => $val) {

            if (!in_array($val, $rootPrivileges)) {

                $parsedResources[$key] = array(
                    'level' => $level,
                    'rules' => $this->getServiceLocator()
                            ->get('RcmUser\Acl\AclDataService')
                            ->fetchByResource($key)->getData(),
                );
            }

            if (is_array($val) && !empty($val)) {

                $nextLevel = $level + 1;
                $parsedResources = $this->getResourceArray(
                    $val,
                    $rootResource,
                    $rootPrivileges,
                    $parsedResources,
                    $nextLevel
                );
            }
        }

        return $parsedResources;
    }

    protected function buildView($viewArr = array())
    {
        $view = new ViewModel($viewArr);

        return $view;
    }

} 