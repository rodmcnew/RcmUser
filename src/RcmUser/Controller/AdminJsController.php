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

use Zend\Http\Response;
use Zend\View\Model\ViewModel;


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
    public function indexAction()
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-acl-administration')) {
            return $this->getNotAllowedResponse();
        }

        $aclResourceService = $this->getServiceLocator()->get(
            'RcmUser\Acl\Service\AclResourceService'
        );
        $aclDataService = $this->getServiceLocator()->get(
            'RcmUser\Acl\AclDataService'
        );

        $resources = $aclResourceService->getResourcesWithNamespaced('.', true);

        $roles = $aclDataService->getRulesByRoles();

        $superAdminRole = $aclDataService->getSuperAdminRole();

        $viewModel = new ViewModel(array(
            'resources' => $resources,
            'roles' => $roles,
            'superAdminRole' => $superAdminRole,
        ));
        $viewModel->setTemplate('js/rcmuser.admin.acl.app.js');
        $viewModel->setTerminal(true);

        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->getHeaders()->addHeaders(
            array(
                'Content-Type' => 'application/javascript'
            )
        );

        return $viewModel;
    }
} 