<?php
/**
 * Module.php
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
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
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
class Module implements AutoloaderProviderInterface
{
    /**
     * getAutoloaderConfig
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' .
                    str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    /**
     * getConfig
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /* Not used
    public function getServiceConfig()
    {

        return array();
    }
    */

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
        $sm = $application->getServiceManager();
        $eventManager = $application->getEventManager();

        try {
            $listeners = $sm->get('RcmUser\Event\Listeners');
            foreach ($listeners as $listener) {
                $listener->attach($eventManager);
            }
        } catch (\Exception $e) {
            // no listeners
        }
    }
}
