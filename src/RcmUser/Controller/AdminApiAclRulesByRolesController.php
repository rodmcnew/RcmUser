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

class AdminApiAclRulesByRolesController extends AbstractRestfulController {

    public function getList(){

        $aclDataService = $this->getServiceLocator()->get(
            'RcmUser\Acl\AclDataService'
        );

        $result = $aclDataService->fetchAllRoles();

        $response = array();

        if($result->isSuccess()){

            $roles = $result->getData();
            foreach($roles as $key => $role){

                $roleId = $role->getRoleId();
                $response[$roleId] = array();
                $response[$roleId]['role'] = $role;
                $result = $aclDataService->fetchRulesByRole($role->getRoleId());
                if($result->isSuccess()){

                    $response[$roleId]['rules'] = $result->getData();
                } else {

                    $response[$roleId]['rules'] = array();
                }
            }
        }

        return new JsonModel($response);
    }
} 