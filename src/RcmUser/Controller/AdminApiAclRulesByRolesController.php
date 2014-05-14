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

use RcmUser\Result;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
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
class AdminApiAclRulesByRolesController extends AbstractRestfulController
{

    /**
     * getList
     *
     * @return mixed|\Zend\Stdlib\ResponseInterface|JsonModel
     */
    public function getList()
    {
        if (!$this->rcmUserIsAllowed('rcmuser-acl-administration')) {

            $response = $this->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_401);
            $result = new Result(
                null,
                Result::CODE_FAIL,
                $response->renderStatusLine()
            );
            $response->setContent(json_encode($result));

            return $response;
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