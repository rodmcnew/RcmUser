<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Db;


use RcmUser\Acl\Entity\Role;
use RcmUser\Db\DoctrineMapper;
use RcmUser\User\Entity\UserInterface;
use RcmUser\Result;

class DoctrineUserRolesDataMapper extends DoctrineMapper implements UserRolesDataMapperInterface
{
    public function add(UserInterface $user, Role $role)
    {
        return new Result(array('me','and','doctrine', 'more'), Result::CODE_SUCCESS);
    }

    public function remove(UserInterface $user, Role $role)
    {
        return new Result(array('me','doctrine'), Result::CODE_SUCCESS);
    }

    public function create(UserInterface $user, $roles = array())
    {
        return new Result(array('me','and','doctrine'), Result::CODE_SUCCESS);
    }

    public function read(UserInterface $user)
    {

        return new Result(array('r.user'), Result::CODE_SUCCESS);
    }

    public function update(UserInterface $user, $roles = array())
    {
        return new Result(array('new','with','doctrine2'), Result::CODE_SUCCESS);
    }

    public function delete(UserInterface $user)
    {
        return new Result(array(), Result::CODE_SUCCESS);
    }

    /**
     * @param UserInterface $user
     *
     * @return Result
     */
    public function getValidUserInstance(UserInterface $user)
    {

        if (!($user instanceof DoctrineUser)) {

            $doctrineUser = new DoctrineUser();
            $doctrineUser->populate($user);

            $user = $doctrineUser;
        }

        return new Result($user);
    }
} 