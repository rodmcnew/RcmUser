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
use RcmUser\Acl\Provider\ResourceProviderInterface;

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
     * @var string PROVIDER_ID
     */
    const PROVIDER_ID = 'RcmUser\Acl';

    /**
     * @var string $providerId
     */
    protected $providerId = self::PROVIDER_ID;

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
     * getProviderId
     *
     * @return string
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * getResources
     * Return a multi-dimensional array of resources and privileges
     * containing ALL possible resources
     *
     * @return array
     */
    public function getResources()
    {
        if(empty($this->rcmResources)){

            $this->buildResources();
        }

        return $this->rcmResources;
    }

    /**
     * getResource
     *
     * @param $resourceId
     *
     * @return array
     */
    public function getResource($resourceId)
    {
        if(isset($resources[$resourceId])){

            return $resources[$resourceId];
        }

        return null;
    }

    /**
     * buildResources - build static resources
     *
     * @return void
     */
    protected function buildResources()
    {

        /* parent resource */
        $this->rcmResources['rcmuser'] = new AclResource(
            'rcmuser'
        );
        $this->rcmResources['rcmuser']->setName('RCM User');
        $this->rcmResources['rcmuser']->setDescription('All RCM user access.');

        /* user edit */
        $this->rcmResources['rcmuser-user-administration'] = new AclResource(
            'rcmuser-user-administration',
            'rcmuser',
            array('read', 'write')
        );
        $this->rcmResources['rcmuser-user-administration']
            ->setName('User Administration');
        $this->rcmResources['rcmuser-user-administration']
            ->setDescription('Allows the editing of user data.');

        /* access and roles */
        $this->rcmResources['rcmuser-acl-administration'] = new AclResource(
            'rcmuser-acl-administration',
            'rcmuser',
            array()
        );
        $this->rcmResources['rcmuser-acl-administration']
            ->setName('Role and Access Administration');
        $this->rcmResources['rcmuser-acl-administration']
            ->setDescription('Allows the editing of user access and role data.');
    }
} 