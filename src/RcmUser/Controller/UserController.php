<?php
/**
 * UserController.php
 *
 * UserController
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

use RcmUser\JsonForm;
use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * UserController
 *
 * UserController
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
class UserController extends AbstractActionController
{
    /**
     * indexAction
     *
     * @return array
     */
    public function indexAction()
    {
        $test = array(
            'userController' => $this,
            'doTest' => false,
            'dumpUser' => false,
        );

        /** @var \RcmUser\Acl\Service\AclDataService $aclDS /
         $aclDS = $this->getServiceLocator()->get('RcmUser\Acl\AclDataService');
         var_dump($aclDS->getAllRules());
         /* */

        /** @var \RcmUser\User\Service\UserRoleService $userRoleService *
         $userRoleService = $this->getServiceLocator()->get(
         'RcmUser\User\Service\UserRoleService'
         );
         var_dump($userRoleService->getAllUserRoles());
         /* */

        /* User *
        var_dump($this->rcmUserGetCurrentUser());
        /* */

        /** @var \RcmUser\User\Service\UserDataService $userDataService */
        $userDataService = $this->getServiceLocator()->get(
            'RcmUser\User\Service\UserDataService'
        );

        //$result = $userDataService->getAllUsers();

        //var_dump($result);

        $user = new User();
        $user->setUsername('Meeee');
        $user->setPassword('123123123');
        $rolsProp = new UserRoleProperty();
        $rolsProp->setRole('customer');
        $rolsProp->setRole('user');
        $user->setProperty(UserRoleProperty::PROPERTY_KEY, $rolsProp);

        $userRes = $userDataService->createUser($user);

        var_dump($userRes);

        /** @var \RcmUser\Service\RcmUserService $rcmUserService *
        $rcmUserService = $this->getServiceLocator()->get(
            'RcmUser\Service\RcmUserService'
        );
        $allowed = $rcmUserService->isAllowed(
            'Sites.' . '4',
            'admin',
            '\Rcm\Acl\ResourceProvider'
        );
        /** @var \RcmUser\User\Entity\User $currentUser *
        $currentUser = $rcmUserService->getIdentity(null);

        var_dump($currentUser);

        $currentUser->setState('test');

        $rcmUserService->setIdentity($currentUser);

        $updatedSessUser = $rcmUserService->getIdentity(null);

        var_dump($updatedSessUser);
        /* */

        /** @var \RcmUser\Log\DoctrineLogger $logger *
        $logger = $this->getServiceLocator()->get(
            'RcmUser\Log\Logger'
        );

        $logger->info('TEST', array('SOMETEST','DATA'));
        /* */

        //var_export($this->getServiceLocator()->getCanonicalNames());
        /** @var \Zend\Log\WriterPluginManager $LogWriterManager */
        //$LogWriterManager = $this->getServiceLocator()->get('LogWriterManager');
        //print_r($LogWriterManager->getServiceLocator());

        /** @var \Zend\Log\ProcessorPluginManager $LogProcessorManager */
        //$LogProcessorManager = $this->getServiceLocator()->get('LogProcessorManager');
        //print_r($LogProcessorManager);

        return $test;
    }
}
