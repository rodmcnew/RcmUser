<?php
/**
 * AdminUserController.php
 *
 * AdminUserController
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
 * Class AdminUserController
 *
 * AdminUserController
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
class AdminUserController extends AbstractAdminController
{
    /**
     * indexAction - list
     *
     * @return array
     */
    public function indexAction()
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-user-administration')) {
            return $this->getNotAllowedResponse();
        }

        $viewArr = array();

        return $this->buildView($viewArr);
    }
} 