<?php
/**
 * ViewHelperRcmUserHtmlHeadFactory.php
 *
 * ViewHelperRcmUserHtmlHeadFactory
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\view
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\view;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Class ViewHelperRcmUserHtmlHeadFactory
 *
 * ViewHelperRcmUserHtmlHeadFactory
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\view
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */

class ViewHelperRcmUserHtmlHeadFactory implements FactoryInterface
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $mgr mgr
     *
     * @return mixed|RcmUserIsAllowed
     */
    public function createService(ServiceLocatorInterface $mgr)
{
    $serviceLocator = $mgr->getServiceLocator();
    $rcmHtmlHeadService = $serviceLocator->get(
        'RcmUser\View\Service\RcmHtmlHeadService'
    );

    $service = new RcmUserBuildHtmlHead($rcmHtmlHeadService);

    return $service;
}
}