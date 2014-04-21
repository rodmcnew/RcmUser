<?php
/**
 * DataPrepEventListeners.php
 *
 * DataPrepEventListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Service\Factory;

use RcmUser\User\Event\CreateUserPreDataPrepListener;
use RcmUser\User\Event\CreateUserPreListener;
use RcmUser\User\Event\CreateUserPreValidatorListener;
use RcmUser\User\Event\UpdateUserPreDataPrepListener;
use RcmUser\User\Event\UpdateUserPreListener;
use RcmUser\User\Event\UpdateUserPrePrepListener;
use RcmUser\User\Event\UpdateUserPreValidatorListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DataPrepEventListeners
 *
 * DataPrepEventListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service\Factory
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class DataPrepEventListeners implements FactoryInterface
{

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return array
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dps = $serviceLocator->get('RcmUser\User\Data\UserDataPreparer');

        $listeners = array();

        $createUserPreDataPrepListener = new CreateUserPreDataPrepListener();
        $createUserPreDataPrepListener->setUserDataPreparer($dps);
        $listeners[] = $createUserPreDataPrepListener;

        $updateUserPreDataPrepListener = new UpdateUserPreDataPrepListener();
        $updateUserPreDataPrepListener->setUserDataPreparer($dps);
        $listeners[] = $updateUserPreDataPrepListener;

        return $listeners;
    }
}
