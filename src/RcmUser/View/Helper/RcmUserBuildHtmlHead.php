<?php
/**
 * RcmUserBuildHtmlHead.php
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\View\Helper
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\View\Helper;

use Zend\View\Helper\AbstractHelper;


/**
 * Class RcmUserBuildHtmlHead
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\View\Helper
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class RcmUserBuildHtmlHead extends AbstractHelper
{
    /**
     * __invoke
     *
     * @param array $options options
     *
     * @return mixed
     */
    public function __invoke($options = array())
    {
        $view = $this->getView();

        $view->rcmIncludeAngularJs(
            array(
                'js' => array(
                    'angular-ui/bootstrap/ui-bootstrap-tpls-0.11.0.min.js'
                ),
                //'css' => array(
                //    'angular-ui/bootstrap/assets/bootstrap-responsive.css'
                //)
            )
        );

        $view->rcmIncludeTwitterBootstrap(
            array(
                'css' => array(
                    'css/bootstrap-theme.css',
                )
            )
        );
    }
} 