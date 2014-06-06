<?php
/**
 * UserController.php
 *
 * UserController
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

use RcmUser\JsonForm;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * UserController
 *
 * UserController
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
class UserController extends AbstractActionController
{
    /**
     * indexAction
     *
     * @return array
     */
    public function indexAction()
    {
        $test = array(
            'userController' => $this,
            'doTest' => false,
            'dumpUser' => false,
        );

        /** @var \RcmUser\Acl\Service\AclDataService $aclDS /
        $aclDS = $this->getServiceLocator()->get('RcmUser\Acl\AclDataService');
        var_dump($aclDS->getAllRules());
        /* */

        /** @var \RcmUser\User\Service\UserRoleService $userRoleService *
        $userRoleService = $this->getServiceLocator()->get(
            'RcmUser\User\Service\UserRoleService'
        );
        var_dump($userRoleService->getAllUserRoles());
        /* */

        var_dump($this->rcmUserGetCurrentUser());

        return $test;
    }
}
