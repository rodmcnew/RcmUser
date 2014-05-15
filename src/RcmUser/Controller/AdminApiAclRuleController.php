<?php
/**
 * AdminApiAclRuleController.php
 *
 * AdminApiAclRuleController
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

use Zend\View\Model\JsonModel;

/**
 * Class AdminApiAclRuleController
 *
 * AdminApiAclRuleController
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

class AdminApiAclRuleController extends AbstractAdminApiController
{

    /**
     * get
     *
     * @param mixed $id
     *
     * @return mixed|JsonModel
     */
    public function get($id)
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-acl-administration')) {
            return $this->getNotAllowedResponse();
        }

        return new JsonModel(array('get'.$id));
    }

    /**
     * create
     *
     * @param mixed $data
     *
     * @return mixed|JsonModel
     */
    public function create($data)
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-acl-administration')) {
            return $this->getNotAllowedResponse();
        }

        return new JsonModel(array('post', json_encode($data)));
    }

    /**
     * delete
     *
     * @param mixed $id
     *
     * @return mixed|JsonModel
     */
    public function delete($id)
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-acl-administration')) {
            return $this->getNotAllowedResponse();
        }

        return new JsonModel(array('delete ID: '.urldecode($id)));
    }
} 