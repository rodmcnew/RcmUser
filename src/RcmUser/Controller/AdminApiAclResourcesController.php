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

use Zend\Http\Response;
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
class AdminApiAclResourcesController extends AbstractAdminApiController
{
    /**
     * getList
     *
     * @return mixed|JsonModel
     */
    public function getList()
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-acl-administration')) {
            return $this->getNotAllowedResponse();
        }

        $aclResourceService = $this->getServiceLocator()->get(
            'RcmUser\Acl\Service\AclResourceService'
        );

        try {

            $resources = $aclResourceService->getResourcesWithNamespace();

        } catch (\Exception $e) {

            return $this->getExceptionResponse($e);
        }

        return new JsonModel($resources);
    }
}