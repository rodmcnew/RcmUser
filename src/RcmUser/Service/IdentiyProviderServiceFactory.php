<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Service;

use RcmUser\Provider\Identity\Provider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IdentiyProviderServiceFactory implements FactoryInterface
{
    /**
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $tableGateway \Zend\Db\TableGateway\TableGateway */
        //$tableGateway = new TableGateway('user_role_linker', $serviceLocator->get('zfcuser_zend_db_adapter'));
        /* @var $userService \ZfcUser\Service\User */
        //$userService = $serviceLocator->get('zfcuser_user_service');
        //$config      = $serviceLocator->get('BjyAuthorize\Config');

        //$provider = new ZfcUserZendDb($tableGateway, $userService);

        //$provider->setDefaultRole($config['default_role']);

        return new Provider();
    }
}