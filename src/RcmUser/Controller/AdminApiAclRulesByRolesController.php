<?php
/**
 * AdminApiAclRulesByRolesController.php
 *
 * AdminApiAclRulesByRolesController
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
use Zend\View\Model\JsonModel;


/**
 * Class AdminApiAclRulesByRolesController
 *
 * AdminApiAclRulesByRolesController
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
class AdminApiAclRulesByRolesController extends AbstractAdminApiController
{

    /**
     * getList
     *
     * @return mixed|\Zend\Stdlib\ResponseInterface|JsonModel
     */
    public function getList()
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-acl-administration')) {
            return $this->getNotAllowedResponse();
        }

        $aclDataService = $this->getServiceLocator()->get(
            'RcmUser\Acl\AclDataService'
        );

        $result = $aclDataService->fetchRulesByRoles();

        if (!$result->isSuccess()) {

            $response = $this->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_500);
            $response->setContent(json_encode($result));

            return $response;
        }

        return new JsonModel($result->getData());
    }
} 