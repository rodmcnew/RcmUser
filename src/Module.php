<?php

namespace RcmUser;

use Zend\Mvc\MvcEvent;

/**
 * Class Module
 *
 * Module
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Module
{
    /**
     * getConfig
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * onBootstrap
     *
     * @param MvcEvent $event event
     *
     * @return void
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceLocator = $application->getServiceManager();

        $modulePrepare = new ModulePrepare();

        $modulePrepare->__invoke($serviceLocator);
    }
}
