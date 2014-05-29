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

use RcmUser\Provider\RcmUserAclResourceProvider;
use RcmUser\Result;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

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
     * @param string $resourceId resourceId
     * @param string $privilege  privilege
     *
     * @return mixed
     */
    public function isAllowed($resourceId = 'rcmuser', $privilege = null)
    {
        return $this->rcmUserIsAllowed(
            $resourceId, $privilege, RcmUserAclResourceProvider::PROVIDER_ID
        );
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

    /**
     * getExceptionResponse
     *
     * @param \Exception $e e
     *
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function getExceptionResponse(\Exception $e)
    {
        $result = new Result(
            null,
            $e->getCode(),
            $e->getMessage()
        );
        /*
        . " | " .$e->getFile() .
         ":" . $e->getLine() .
         " | " . $e->getTraceAsString()
        */

        $response = $this->getResponse();
        $response->setContent(json_encode($result));

        return $response;
    }

    /**
     * getJsonResponse
     *
     * @param Result $result result
     *
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function getJsonResponse($result)
    {
        $view = new JsonModel();
        $view->setTerminal(true);

        $response = $this->getResponse();
        $response->getHeaders()->addHeaders(
            array(
                'Content-Type' => 'application/json'
            )
        );
        $response->setContent(json_encode($result));

        return $response;
    }
} 