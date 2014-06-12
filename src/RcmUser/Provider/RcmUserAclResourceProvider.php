<?php
/**
 * RcmUserAclResourceProvider.php
 *
 * RcmUserAclResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Provider;


use RcmUser\Acl\Entity\AclResource;
use RcmUser\Acl\Provider\ResourceProvider;

/**
 * RcmUserAclResourceProvider
 *
 * RcmUserAclResourceProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Provider
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class RcmUserAclResourceProvider extends ResourceProvider
{
    /**
     * @var string PROVIDER_ID This needs to be the same as the config
     */
    const PROVIDER_ID = 'RcmUser';

    /**
     * default resources  - rcm user needs these,
     * however descriptions added on construct in the factory
     *
     * @var array $rcmResources
     */
    protected $resources = array();

    /**
     * __construct
     *
     */
    public function __construct()
    {
    }

    /**
     * getResources (ALL resources)
     * Return a multi-dimensional array of resources and privileges
     * containing ALL possible resources including run-time resources
     *
     * @return array
     */
    public function getResources()
    {
        if (empty($this->resources)) {

            $this->buildResources();
        }

        return $this->resources;
    }

    /**
     * getResource
     * Return the requested resource
     * Can be used to return resources dynamically.
     *
     * @param string $resourceId resourceId
     *
     * @return array
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function getResource($resourceId)
    {

        if (empty($this->resources)) {

            $this->buildResources();
        }

        return parent::getResource($resourceId);
    }

    /**
     * buildResources - build static resources
     *
     * @return void
     */
    protected function buildResources()
    {
        $privileges = array(
            'read',
            'update',
            'create',
            'delete',
        );

        $userPrivileges = array(
            'read',
            'update',
            'create',
            'delete',
            'update_credentials',
            'create_credentials',
        );

        /* parent resource */
        $this->resources['rcmuser'] = new AclResource(
            'rcmuser'
        );
        $this->resources['rcmuser']->setName('RCM User');
        $this->resources['rcmuser']->setDescription('All RCM user access.');
        $this->resources['rcmuser']->setPrivileges($privileges);

        /* user edit */
        $this->resources['rcmuser-user-administration'] = new AclResource(
            'rcmuser-user-administration',
            'rcmuser',
            $userPrivileges
        );
        $this->resources['rcmuser-user-administration']
            ->setName('User Administration');
        $this->resources['rcmuser-user-administration']
            ->setDescription('Allows the editing of user data.');

        /* access and roles */
        $this->resources['rcmuser-acl-administration'] = new AclResource(
            'rcmuser-acl-administration',
            'rcmuser',
            $privileges
        );
        $this->resources['rcmuser-acl-administration']
            ->setName('Role and Access Administration');
        $this->resources['rcmuser-acl-administration']
            ->setDescription('Allows the editing of user access and role data.');
    }
} 