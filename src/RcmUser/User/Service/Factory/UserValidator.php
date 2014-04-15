<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Service\Factory;

use Zend\InputFilter\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserValidator implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $service = new \RcmUser\User\Data\UserValidator();

        $config = $serviceLocator->get('RcmUser\User\Config')->get('InputFilter', array());
        $userInputFilterClass = 'RcmUser\User\InputFilter\UserInputFilter';
        $factory = new Factory();

        $service->setUserInputFilterConfig($config);
        $service->setUserInputFilterClass($userInputFilterClass);
        $service->setUserInputFilterFactory($factory);

        return $service;
    }
}
