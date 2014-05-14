<?php
/**
 * AdminApiAclResourcesController.php
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

use RcmUser\Result;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;


/**
 * Class AdminApiAclResourcesController
 *
 * AdminApiAclResourcesController
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
class AdminApiAclResourcesController extends AbstractRestfulController
{

    /**
     * getList
     *
     * @return mixed|JsonModel
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

        $aclResourceService = $this->getServiceLocator()->get(
            'RcmUser\Acl\Service\AclResourceService'
        );

        $resources = $aclResourceService->getNamespacedResources('.', true);

        return new JsonModel($resources);
    }
} 