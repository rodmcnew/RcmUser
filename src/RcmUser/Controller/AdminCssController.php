<?php
/**
 * AdminCssController.php
 *
 * AdminCssController
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
use Zend\View\Model\ViewModel;


/**
 * Class AdminCssController
 *
 * AdminCssController
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
class AdminCssController extends AbstractAdminController
{
    /**
     * adminAclApp
     *
     * @return void
     */
    public function indexAction()
    {
        $viewModel = new ViewModel();

        $viewModel->setTemplate('css/styles.css');
        $viewModel->setTerminal(true);

        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->getHeaders()->addHeaders(
            array(
                'Content-Type' => 'text/css'
            )
        );

        return $viewModel;
    }
} 