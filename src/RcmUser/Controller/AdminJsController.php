<?php
/**
 * AdminJsController.php
 *
 * LongDescHere
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

use
    RcmUser\Provider\RcmUserAclResourceProvider;
use
    RcmUser\User\Entity\UserRoleProperty;
use
    Zend\Http\Response;
use
    Zend\View\Model\ViewModel;

/**
 * Class AdminJsController
 *
 * LongDescHere
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
class AdminJsController extends AbstractAdminController
{
    /**
     * adminAclApp
     *
     * @return void
     */
    public function adminAclAction()
    {
        // ACCESS CHECK
        if (!$this->isAllowed(
            RcmUserAclResourceProvider::RESOURCE_ID_ACL,
            'read'
        )
        ) {
            return $this->getNotAllowedResponse();
        }

        /** @var $aclDataService \RcmUser\Acl\Service\AclDataService */
        $aclDataService = $this->getServiceLocator()->get(
            'RcmUser\Acl\AclDataService'
        );

        $superAdminRoleId = $aclDataService->getSuperAdminRoleId()->getData();
        $guestRoleId = $aclDataService->getGuestRoleId()->getData();

        $viewModel = new ViewModel([
            'superAdminRoleId' => $superAdminRoleId,
            'guestRoleId' => $guestRoleId,
        ]);
        $viewModel->setTemplate('js/rcmuser.admin.acl.app.js');
        $viewModel->setTerminal(true);

        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->getHeaders()->addHeaders(
            [
                'Content-Type' => 'application/javascript'
            ]
        );

        return $viewModel;
    }

    /**
     * adminUsersAction
     *
     * @return void
     */
    public function adminUsersAction()
    {
        // ACCESS CHECK
        if (!$this->isAllowed(
            RcmUserAclResourceProvider::RESOURCE_ID_USER,
            'read'
        )
        ) {
            return $this->getNotAllowedResponse();
        }

        /** @var \RcmUser\User\Service\UserDataService $userDataService */
        $userDataService = $this->getServiceLocator()->get(
            'RcmUser\User\Service\UserDataService'
        );

        /** @var \RcmUser\Acl\Service\AclDataService $aclDataService */
        $aclDataService = $this->getServiceLocator()->get(
            'RcmUser\Acl\AclDataService'
        );

        $rolePropertyId = UserRoleProperty::PROPERTY_KEY;

        $viewModel = new ViewModel([
            'rolePropertyId' => $rolePropertyId,
        ]);

        $viewModel->setTemplate('js/rcmuser.admin.users.app.js');
        $viewModel->setTerminal(true);

        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->getHeaders()->addHeaders(
            [
                'Content-Type' => 'application/javascript'
            ]
        );

        return $viewModel;
    }

    /**
     * adminUsersAction
     *
     * @return void
     */
    public function adminUserRolesAction()
    {
        // ACCESS CHECK
        if (!$this->isAllowed(
            RcmUserAclResourceProvider::RESOURCE_ID_USER,
            'read'
        )
        ) {
            return $this->getNotAllowedResponse();
        }

        $viewModel = new ViewModel([]);

        $viewModel->setTemplate('js/rcmuser.admin.user.role.app.js');
        $viewModel->setTerminal(true);

        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->getHeaders()->addHeaders(
            [
                'Content-Type' => 'application/javascript'
            ]
        );

        return $viewModel;
    }
}
