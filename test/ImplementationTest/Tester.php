<?php
/**
 * Tester.php
 *
 * Tester
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUserTest
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\ImplementationTest;

use RcmUser\User\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Class Tester
 *
 * This is a full implementation test... This is NOT for PROD
 * - Will write real data to data storage
 * - Will create users, create access and authenticate users
 * - Should only be used to verify configuration and implementation
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUserTest
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Tester implements ServiceLocatorAwareInterface
{
    public static function testAll(
        ServiceLocatorInterface $serviceLocator,
        $params = array()
    ) {
        $message = '';

        $message .= self::testCase1($serviceLocator, $params);
        $message .= self::testCase2($serviceLocator, $params);
        $message .= self::testCase3($serviceLocator, $params);

        return $message;
    }

    /**
     * testCase1
     * - Create new user with minimal good data
     * - Update all user fields with good data
     * -
     * expect success
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     * @param array                   $params         params
     *
     * @return string
     */
    public static function testCase1(
        ServiceLocatorInterface $serviceLocator,
        $params = array()
    ) {
        $startTime = time();

        $tester = new Tester($serviceLocator);
        $tester->testId = __FUNCTION__;

        $user = self::parseParam($params, 'user');

        if (empty($user)) {
            $user = new User();

            $user->setUsername('testCase_1');
            $user->setPassword('pass_testCase_1_word1');
        }

        $tester->addMessage("Initial test user: " . var_export($user, true));
        $user = $tester->rcmUserService->buildUser($user);
        $tester->addMessage("->buildUser result: " . var_export($user, true));

        //$tester->addMessage("Read before we create, just to check:");
        //$tester->testReadUser($user);

        $tester->addMessage("Create test user:");
        $user = $tester->testCreateUser($user);

        if (empty($user)) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        $tester->addMessage("Read after create:");
        $user = $tester->testReadUser($user);

        if (empty($user) || empty($user->getId())) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        $tester->addMessage("Update password:");
        $user->setPassword('pass_testCase_1_word2');
        $user = $tester->testUpdateUser($user);

        if (empty($user)) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        $tester->addMessage("Update state:");
        $user->setState('testCase');
        $user = $tester->testUpdateUser($user);

        if (empty($user)) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        $tester->addMessage("Update username:");
        $user->setUsername('testCase_1.1');
        $user = $tester->testUpdateUser($user);

        if (empty($user)) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        $tester->addMessage("Read before delete - make sure data is correct:");
        $user = $tester->testReadUser($user);

        if (empty($user) || empty($user->getId())) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        $tester->addMessage("Clean up test user:");
        $user = $tester->testDeleteUser($user);

        if (empty($user)) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        $tester->addMessage("Read attempt after delete - make sure data is gone:");
        $user = $tester->testReadUser($user);

        if (!empty($user)) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        $tester->addMessage(
            "TEST SUCCESS: [" . __FUNCTION__ . "] Time to complete:" . (time()
                - $startTime) . "sec"
        );

        return $tester->getMessage();
    }

    /**
     * testCase2
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param array                   $params
     *
     * @return string
     */
    public static function testCase2(
        ServiceLocatorInterface $serviceLocator,
        $params = array()
    ) {
        $startTime = time();

        $tester = new Tester($serviceLocator);
        $tester->testId = __FUNCTION__;

        $testUserId = null;

        $user = self::parseParam($params, 'user');
        $password = self::parseParam(
            $params, 'userPlainTextPassword', 'pass_testCase_2_word1'
        );
var_dump('mnmnmn',$user);
        // build new user if
        if (empty($user)) {
            $user = new User();
            $user->setUsername('testCase_2');
            $user->setPassword($password);
            $tester->addMessage("Create test user: " . var_export($user, true));
            $user = $tester->rcmUserService->buildUser($user);
            $tester->addMessage("->buildUser result: " . var_export($user, true));
            $user = $tester->testCreateUser($user);
            if (empty($user)) {
                $tester->addMessage("TEST FAILED");
                return $tester->getMessage();
            }
            $testUserId = $user->getId();
        }

        // clean up session
        $tester->addMessage(
            "Get current session user: " . var_export(
                $tester->rcmUserService->getIdentity(), true
            )
        );
        $tester->addMessage(
            "Log Out current session user: " . var_export(
                $tester->rcmUserService->clearIdentity(), true
            )
        );
        // should not be a session user
        if (!empty($tester->rcmUserService->getIdentity()->getId())) {
            $tester->addMessage("TEST FAILED");

            return $tester->getMessage();
        }

        // validate without login
        $user->setPassword($password);
        $tester->addMessage(
            "Test validate without login: " . var_export($user, true)
        );
        $user = $tester->testValidateCredentials($user);
        if (empty($user)) {
            $tester->addMessage("TEST FAILED");
            return $tester->getMessage();
        }
        // should not be a session user
        if (!empty($tester->rcmUserService->getIdentity()->getId())) {
            $tester->addMessage("TEST FAILED");
            return $tester->getMessage();
        }

        $user->setPassword($password);
        $tester->addMessage("Test authentication: ");
        $user = $tester->testAuthenticate($user);
        if (empty($user) || empty($user->getId())) {
            $tester->addMessage("TEST FAILED");
            return $tester->getMessage();
        }
        if (empty($tester->rcmUserService->getIdentity()->getId())) {
            $tester->addMessage("TEST FAILED");
            return $tester->getMessage();
        }

        //
        $tester->addMessage("Test logout: ");
        $tester->rcmUserService->clearIdentity();
        // should not be a session user
        if (!empty($tester->rcmUserService->getIdentity()->getId())) {
            $tester->addMessage("TEST FAILED");
            return $tester->getMessage();
        }

        // clean up user if we created it
        if ($testUserId !== null) {
            $tester->addMessage("Clean up test user:");
            $user = $tester->testDeleteUser($user);
            if (empty($user)) {
                $tester->addMessage("TEST FAILED");
                return $tester->getMessage();
            }
        }

        $tester->addMessage(
            "TEST SUCCESS: [" . __FUNCTION__ . "] Time to complete:" . (time()
                - $startTime) . "sec"
        );

        return $tester->getMessage();
    }

    public static function testCase3(
        ServiceLocatorInterface $serviceLocator,
        $params = array()
    ) {
        $startTime = time();

        $tester = new Tester($serviceLocator);
        $tester->testId = __FUNCTION__;

        $testUserId = null;

        $user = self::parseParam($params, 'user');
        $password = self::parseParam(
            $params, 'userPlainTextPassword', 'pass_testCase_3_word1'
        );
        $userRoles = self::parseParam(
            $params, 'userRoles', array('admin')
        );

        // build new user if
        if (empty($user)) {
            $user = new User();
            $user->setUsername('testCase_3');
            $user->setPassword($password);
            $tester->addMessage("Create test user: " . var_export($user, true));
            $user = $tester->rcmUserService->buildUser($user);
            $user->setProperty('RcmUser\Acl\UserRoles', $userRoles);
            $tester->addMessage("->buildUser result: " . var_export($user, true));
            $user = $tester->testCreateUser($user);
            if (empty($user)) {
                $tester->addMessage("TEST FAILED");
                return $tester->getMessage();
            }

            $testUserId = $user->getId();
        }

        $resource = self::parseParam($params, 'resource', 'RcmUser');
        $privilage = self::parseParam($params, 'privilage', '');

        $user->setPassword($password);
        $tester->addMessage("Log in user: ");
        $user = $tester->testAuthenticate($user);
        if (empty($user) || empty($user->getId())) {
            $tester->addMessage("TEST FAILED");
            return $tester->getMessage();
        }

        $tester->addMessage("Verify logged in: ");
        $user = $tester->rcmUserService->getIdentity();
        if (empty($user->getId())) {
            $tester->addMessage("TEST FAILED");
            return $tester->getMessage();
        }

        $properties = $user->getProperty('RcmUser\Acl\UserRoles', 'NOT SET');
        if($properties === 'NOT SET'){
            $tester->addMessage("TEST FAILED");
            return $tester->getMessage();
        }

        $tester->addMessage("Current user roles: " . var_export($properties, true));


        /* ACL VALUES */
        $tester->addMessage("ACL Roles (from BJY): " . var_export($tester->bjyAuthService->getAcl()->getRoles(), true));
        $tester->addMessage("ACL Resources (from BJY): " . var_export($tester->bjyAuthService->getAcl()->getResources(), true));

        /* ACL CHECK */
        /* BJY Check *
        echo "\nACL CHECK: viewHelper->isAllowed($resource, $privilage) = ";
        var_export($this->isAllowed($resource, $privilage));
        echo "\nACL CHECK: controllerPlugin->isAllowed($resource, $privilage) = ";
        var_export($this->userController->isAllowed($resource, $privilage));
        /* */
        /* RcmUser */
        $tester->addMessage("ACL CHECK: rcmUserService->rcmUserIsAllowed($resource, $privilage) = " . json_encode($tester->rcmUserService->IsAllowed($resource, $privilage)));
        /* *
        $tester->addMessage("ACL CHECK: viewHelper->rcmUserIsAllowed($resource, $privilage) = ";
        var_export($tester->rcmUserIsAllowed($resource, $privilage));
        $tester->addMessage("nACL CHECK: controllerPlugin->rcmUserIsAllowed($resource, $privilage) = ";
        var_export($tester->userController->rcmUserIsAllowed($resource, $privilage));
        /* */


        // clean up user if we created it
        if ($testUserId !== null) {
            $tester->addMessage("Clean up test user:");
            $user = $tester->testDeleteUser($user);
            if (empty($user)) {
                $tester->addMessage("TEST FAILED");

                return $tester->getMessage();
            }
        }

        $tester->addMessage(
            "TEST SUCCESS: [" . __FUNCTION__ . "] Time to complete:" . (time()
                - $startTime) . "sec"
        );

        return $tester->getMessage();
    }

    /* ********************** */

    public static function createTestUser()
    {


    }

    public static function deleteTestUser()
    {


    }

    /**
     * parseParam
     *
     * @param      $params
     * @param      $key
     * @param null $default
     *
     * @return null
     */
    public static function parseParam($params, $key, $default = null)
    {
        if (isset($params[$key])) {

            return $params[$key];
        }

        return $default;
    }

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var \RcmUser\Service\RcmUserService'
     */
    protected $rcmUserService;

    /**
     * @var \BjyAuthorize\Service\Authorize
     */
    protected $bjyAuthService;

    /**
     * @var string
     */
    protected $message = '';

    public $testId = '';

    /**
     * __construct
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {

        $this->setServiceLocator($serviceLocator);

        $this->rcmUserService = $this->getServiceLocator()
            ->get('RcmUser\Service\RcmUserService');

        $this->bjyAuthService = $this->getServiceLocator()
            ->get('BjyAuthorize\Service\Authorize');
    }

    /**
     * setServiceLocator
     *
     * @param ServiceLocatorInterface $serviceLocator serviceLocator
     *
     * @return void
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * getServiceLocator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }


    /**
     * testReadUser
     *
     * @param User $user
     *
     * @return bool
     */
    public function testReadUser(User $user)
    {
        /* READ */
        $result = $this->rcmUserService->readUser($user);

        $this->addMessage("** READ **");

        if (!$result->isSuccess()) {

            $this->addMessage(" ERROR: " . var_export($result->getMessages(), true));

            return null;
        }

        $this->addMessage(" SUCCESS: " . var_export($result->getUser(), true));

        return $result->getUser();
        /* */
    }

    /**
     * testCreateUser
     *
     * @param User $user
     *
     * @return bool
     */
    public function testCreateUser(User $user)
    {
        /* CREATE */
        $result = $this->rcmUserService->createUser($user);

        $this->addMessage("** CREATE **");

        if (!$result->isSuccess()) {

            $this->addMessage(" ERROR: " . var_export($result->getMessages(), true));

            return null;
        }

        $this->addMessage(" SUCCESS: " . var_export($result->getUser(), true));

        return $result->getUser();
        /* */
    }

    /**
     * testUpdateUser
     *
     * @param User $user
     *
     * @return bool
     */
    public function testUpdateUser(User $user)
    {
        /* CREATE */
        $result = $this->rcmUserService->updateUser($user);

        $this->addMessage("** UPDATE **");

        if (!$result->isSuccess()) {

            $this->addMessage(" ERROR: " . var_export($result->getMessages(), true));

            return null;
        }

        $this->addMessage(" SUCCESS: " . var_export($result->getUser(), true));

        return $result->getUser();
        /* */
    }

    /**
     * testDeleteUser
     *
     * @param User $user
     *
     * @return bool
     */
    public function testDeleteUser(User $user)
    {
        /* CREATE */
        $result = $this->rcmUserService->deleteUser($user);

        $this->addMessage("DELETE");

        if (!$result->isSuccess()) {

            $this->addMessage(" ERROR: " . var_export($result->getMessages(), true));

            return null;
        }

        $this->addMessage(" SUCCESS: " . var_export($result->getUser(), true));

        return $result->getUser();
        /* */
    }

    public function testValidateCredentials(User $user)
    {

        /* AUTH CHECK */
        $authResult = $this->rcmUserService->validateCredentials($user);

        if (!$authResult->isValid()) {

            $this->addMessage(
                " ERROR: " . var_export($authResult->getMessages(), true)
            );

            return null;
        }

        $this->addMessage(
            " SUCCESS: " . var_export($authResult->getIdentity(), true)
        );

        return $authResult->getIdentity();
        /* */
    }

    public function testAuthenticate(User $user)
    {

        /* AUTH CHECK */
        $authResult = $this->rcmUserService->authenticate($user);

        if (!$authResult->isValid()) {

            $this->addMessage(
                " ERROR: " . var_export($authResult->getMessages(), true)
            );

            return null;
        }

        $this->addMessage(
            " SUCCESS: " . var_export($authResult->getIdentity(), true)
        );

        return $authResult->getIdentity();
        /* */
    }


    /* ********************** */
    /**
     * addMessage
     *
     * @param string $message message
     *
     * @return void
     */
    public function addMessage($message)
    {
        $this->message .= "\n[" . $this->testId . "] - " . $message . "\n";
    }

    /**
     * getMessage
     *
     * @param bool $clear
     *
     * @return string
     */
    public function getMessage($clear = true)
    {
        $message = $this->message;

        if ($clear) {
            $this->clearMessage();
        }

        return $message;
    }

    /**
     * clearMessage
     *
     * @return void
     */
    public function clearMessage()
    {
        $this->message = '';
    }

} 