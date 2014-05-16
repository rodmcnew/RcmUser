<?php
/**
 * AbstractAdminApiController.php
 *
 * AbstractAdminApiController
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
 * Class AbstractAdminApiController
 *
 * AbstractAdminApiController
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
class AbstractAdminApiController extends AbstractRestfulController
{
    /**
     * isAllowed
     *
     * @param string $resource  resource
     * @param string $privilege privilege
     *
     * @return mixed
     */
    public function isAllowed($resource = 'rcmuser', $privilege = null)
    {
        return $this->rcmUserIsAllowed($resource, $privilege);
    }

    /**
     * getNotAllowedResponse
     *
     * @return mixed
     */
    public function getNotAllowedResponse()
    {
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
} 