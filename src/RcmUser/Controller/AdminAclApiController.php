<?php
/**
 * AdminAclApiController.php
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
use Zend\Mvc\Controller\AbstractRestfulController;


/**
 * Class AdminAclApiController
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
class AdminAclApiController extends AbstractRestfulController
{

    public function fetchAllResourcesAction()
    {

    }

    public function fetchRulesByRolesAction()
    {
        $aclDataService = $this->getServiceLocator()->get(
            'RcmUser\Acl\AclDataService'
        );

        return json_encode($aclDataService->fetchAllRoles());
    }
} 