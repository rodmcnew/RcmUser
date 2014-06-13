<?php
/**
 * AdminApiUserController.php
 *
 * AdminApiUserController
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

use RcmUser\Acl\Entity\AclRule;
use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;
use RcmUser\User\Result;
use Zend\View\Model\JsonModel;

/**
 * Class AdminApiUserController
 *
 * AdminApiUserController
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
class AdminApiUserController extends AbstractAdminApiController
{

    /**
     * getList
     *
     * @return mixed|\Zend\Stdlib\ResponseInterface|JsonModel
     */
    public function getList()
    {
        if (!$this->isAllowed('rcmuser-user-administration', 'read')) {
            return $this->getNotAllowedResponse();
        }

        /** @var \RcmUser\User\Service\UserDataService $userDataService */
        $userDataService = $this->getServiceLocator()->get(
            'RcmUser\User\Service\UserDataService'
        );

        try {

            $result = $userDataService->getAllUsers(array());
        } catch (\Exception $e) {

            return $this->getExceptionResponse($e);
        }

        return $this->getJsonResponse($result);
    }

    /**
     * get
     *
     * @param string $id id
     *
     * @return mixed|JsonModel
     */
    public function get($id)
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-user-administration', 'read')) {
            return $this->getNotAllowedResponse();
        }

        /** @var \RcmUser\User\Service\UserDataService $userDataService */
        $userDataService = $this->getServiceLocator()->get(
            'RcmUser\User\Service\UserDataService'
        );

        try {

            $user = new User($id);

            $result = $userDataService->readUser($user);

        } catch (\Exception $e) {

            return $this->getExceptionResponse($e);
        }

        return $this->getJsonResponse($result);
    }

    /**
     * create
     *
     * @param mixed|AclRule $data data
     *
     * @return mixed|JsonModel
     */
    public function create($data)
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-user-administration', 'create')) {
            return $this->getNotAllowedResponse();
        }

        return $this->getJsonResponse(null);
    }

    /**
     * delete
     *
     * @param string $id id
     *
     * @return mixed|JsonModel
     */
    public function delete($id)
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-user-administration', 'delete')) {
            return $this->getNotAllowedResponse();
        }

        return $this->getJsonResponse(null);
    }

    /**
     * update
     *
     * @param mixed $id
     * @param mixed $data user array
     *
     * @return array|mixed
     */
    public function update($id, $data)
    {
        // ACCESS CHECK
        if (!$this->isAllowed('rcmuser-user-administration', 'update')) {
            return $this->getNotAllowedResponse();
        }

        /** @var \RcmUser\User\Service\UserDataService $userDataService */
        $userDataService = $this->getServiceLocator()->get(
            'RcmUser\User\Service\UserDataService'
        );

        // Populate user

        $user = new User();
        $user->populate($data, array('properties'));

        $properties = array();
        if (isset($data['properties'])) {
            $properties = $data['properties'];
        }

        if (isset($properties[UserRoleProperty::PROPERTY_KEY])) {
            $roles = $properties[UserRoleProperty::PROPERTY_KEY];
            $userRoleProperty = new UserRoleProperty();
            $userRoleProperty->populate($roles);
            $user->setProperty(UserRoleProperty::PROPERTY_KEY, $userRoleProperty);
        }

        // NO PASSWORD change ALLOWED?
        if (!$this->isAllowed('rcmuser-user-administration', 'update_credentials')) {

            if ($user->getPassword() !== null) {

                $result = new Result(
                    $user,
                    Result::CODE_FAIL,
                    "Not allowed to change username and password."
                );

                return $this->getJsonResponse($result);
            }

            $user->setUsername(null);
        }

        $result = $userDataService->updateUser($user);

        if($user->getUsername() === null){

            $result->setMessage(
                'Username was not update, was not allowed or empty.'
            );
        }

        return $this->getJsonResponse($result);
    }
} 