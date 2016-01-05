<?php

namespace RcmUser\Acl\Provider;

/**
 * Class RoleProviderInterface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface RoleProviderInterface
{
    /**
     * hasRole
     *
     * @param string $roleId
     *
     * @return mixed
     */
    public function hasRole($roleId);

    /**
     * getRole
     *
     * @param $roleId
     *
     * @return \Zend\Permissions\Acl\Role\RoleInterface
     */
    public function getRole($roleId);

    /**
     * getRoles
     *
     * @return array
     */
    public function getRoles();
}
