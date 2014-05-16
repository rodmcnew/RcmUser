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

class RcmUserBuildHtmlHead extends AbstractHelper {
    
    protected $rcmHtmlHeadService;

    public function __construct(RcmHtmlHeadService $rcmHtmlHeadService){

        $this->setRcmHtmlHeadService($rcmHtmlHeadService);
    }

    /**
     * setRcmHtmlHeadService
     *
     * @param $rcmHtmlHeadService
     *
     * @return void
     */
    public function setRcmHtmlHeadService($rcmHtmlHeadService)
    {
        $this->rcmHtmlHeadService = $rcmHtmlHeadService;
    }

    /**
     * getRcmHtmlHeadService
     *
     * @return mixed
     */
    public function getRcmHtmlHeadService()
    {
        return $this->rcmHtmlHeadService;
    }

    /**
     * __invoke
     *
     * @param       $view    view
     * @param array $options options
     *
     * @return mixed
     */
    public function __invoke($view, $options = array())
    {
        return $this->getRcmHtmlHeadService()->build($view, $options);
    }
} 