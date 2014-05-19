<?php
/**
 * AbstractAdminController.php
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

use RcmUser\Provider\RcmUserAclResourceProvider;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;


/**
 * Class AbstractAdminController
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
class AbstractAdminController extends AbstractActionController
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
        return $this->rcmUserIsAllowed($resource, $privilege, RcmUserAclResourceProvider::PROVIDER_ID);
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
        $response->setContent($response->renderStatusLine());

        return $response;
    }
} 