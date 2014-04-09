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


use RcmUser\Acl\Entity\AclRole;
use RcmUser\Db\DoctrineMapper;
use RcmUser\User\Entity\UserInterface;
use RcmUser\Result;

class DoctrineUserRoleDataMapper extends DoctrineMapper implements UserRolesDataMapperInterface
{
    public function add(UserInterface $user, AclRole $role)
    {
        /* EXAMPLE
                $user = $this->getEntityManager()->find($this->getEntityClass(), $id);
                if (empty($user)) {

                    return new Result(null, Result::CODE_FAIL, 'User could not be found by id.');
                }

                // This is so we get a fresh user every time
                $this->getEntityManager()->refresh($user);

                return new Result($user);
        */
        return new Result(array('me', 'and', 'doctrine', 'more'), Result::CODE_SUCCESS);
    }

    public function remove(UserInterface $user, AclRole $role)
    {
        return new Result(array('me', 'doctrine'), Result::CODE_SUCCESS);
    }

    public function create(UserInterface $user, $roles = array())
    {
        return new Result(array('me', 'and', 'doctrine'), Result::CODE_SUCCESS);
    }

    public function read(UserInterface $user)
    {

        return new Result(array('user'), Result::CODE_SUCCESS);
    }

    public function update(UserInterface $user, $roles = array())
    {
        return new Result(array('new', 'with', 'doctrine2'), Result::CODE_SUCCESS);
    }

    public function delete(UserInterface $user)
    {
        return new Result(array(), Result::CODE_SUCCESS);
    }
} 