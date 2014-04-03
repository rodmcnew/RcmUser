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

    use RcmUser\User\Service\UserValidatorService;
    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

class UserValidator implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $infi = $serviceLocator->get('RcmUser\User\InputFilter');
        $service = new UserValidatorService($infi);

        return $service;
    }
}
