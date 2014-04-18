<?php
/**
 * AbstractUserDataMapper.php
 *
 * AbstractUserDataMapper
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */
namespace RcmUser\User\Db;


use RcmUser\Db\DoctrineMapper;
use RcmUser\User\Entity\DoctrineUser;
use RcmUser\User\Entity\User;
use RcmUser\User\Result;

/**
 * Class AbstractUserDataMapper
 *
 * AbstractUserDataMapper
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Db
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractUserDataMapper implements UserDataMapperInterface
{
    /**
     * fetchById
     *
     * @param mixed $id     id
     * @param array $params params
     *
     * @return Result
     */
    public function fetchById($id, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be found by id.');
    }

    /**
     * fetchByUsername
     *
     * @param string $username username
     * @param array  $params   params
     *
     * @return Result
     */
    public function fetchByUsername($username, $params = array())
    {
        return new Result(
            null,
            Result::CODE_FAIL,
            'User cannot be found by username.'
        );
    }

    /**
     * create
     *
     * @param User  $user   user
     * @param array $params params
     *
     * @return Result
     */
    public function create(User $user, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be created.');
    }

    /**
     * read
     *
     * @param User  $user   user
     * @param array $params params
     *
     * @return Result
     */
    public function read(User $user, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be read.');
    }

    /**
     * update
     *
     * @param User  $user   user
     * @param array $params params
     *
     * @return Result
     */
    public function update(User $user, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be updated.');
    }

    /**
     * delete
     *
     * @param User  $user   user
     * @param array $params params
     *
     * @return mixed|Result
     */
    public function delete(User $user, $params = array())
    {
        return new Result(null, Result::CODE_FAIL, 'User cannot be deleted.');
    }

    /**
     * canUpdate
     *
     * @param User  $user   user
     * @param array $params params
     *
     * @return bool
     */
    public function canUpdate(User $user, $params = array())
    {
        $id = $user->getId();

        if (empty($id)) {

            return false;
        }

        return true;
    }

    /**
     * parseParamValue
     *
     * @param string $key    key
     * @param array  $params params
     *
     * @return mixed
     */
    protected function parseParamValue($key, $params = array())
    {
        if (isset($params[$key])) {

            return $params[$key];
        }

        return null;
    }
} 