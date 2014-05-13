<?php
/**
 * AdminJsController.php
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
use Zend\Mvc\Controller\AbstractActionController;


/**
 * Class AdminJsController
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
class AdminJsController extends AbstractActionController
{
    /**
     * adminAclApp
     *
     * @return void
     */
    public function indexAction()
    {
        $js = file_get_contents(
            __DIR__ . '/../../../view/js/rcmuser.admin.acl.app.js'
        );

        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->getHeaders()->addHeaders(
            array(
                'Content-Type' => 'application/javascript'
            )
        );
        $response->setContent($js);
        return $response;
    }
} 