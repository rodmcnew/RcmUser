<?php
/**
 * AclResource.php
 *
 * AclResource
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\Acl\Entity;

use RcmUser\Exception\RcmUserException;
use Zend\Permissions\Acl\Resource\GenericResource;


/**
 * Class AclResource
 *
 * AclResource
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AclResource extends GenericResource implements \JsonSerializable
{

    /**
     * @var string $parentResourceId
     */
    protected $parentResourceId = null;

    /**
     * @var string $parentResource
     */
    protected $parentResource = null;

    /**
     * @var array $privileges
     */
    protected $privileges = array();

    /**
     * @var string $name
     */
    protected $name = '';

    /**
     * @var string $description
     */
    protected $description = '';

    /**
     * __construct
     *
     * @param string $resourceId       resourceId
     * @param null   $parentResourceId parentResourceId
     * @param array  $privileges       privileges
     */
    public function __construct(
        $resourceId,
        $parentResourceId = null,
        $privileges = array()
    ) {
        $this->setResourceId($resourceId);
        $this->setParentResourceId($parentResourceId);
        $this->setPrivileges($privileges);
    }

    /**
     * setResourceId
     *
     * @param string $resourceId resourceId
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function setResourceId($resourceId)
    {
        if (!$this->isValidResourceId($resourceId)) {

            throw new RcmUserException(
                "Resource resourceId ({$resourceId}) is invalid."
            );
        }

        $this->resourceId = $resourceId;
    }

    /**
     * setParentResourceId
     *
     * @param string $parentResourceId parentResourceId
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function setParentResourceId($parentResourceId)
    {
        if (!$this->isValidResourceId($parentResourceId)) {

            throw new RcmUserException(
                "Resource parentResourceId ({$parentResourceId}) is invalid."
            );
        }

        $this->parentResourceId = $parentResourceId;
    }

    /**
     * getParentResourceId
     *
     * @return string
     */
    public function getParentResourceId()
    {
        return $this->parentResourceId;
    }

    /**
     * setParentResource
     *
     * @param AclResource $parentResource parentResource
     *
     * @return void
     */
    public function setParentResource(AclResource $parentResource)
    {
        $this->parentResource = $parentResource;
    }

    /**
     * getParentResource
     *
     * @return string|AclResource
     */
    public function getParentResource()
    {
        if (empty($this->parentResource)) {

            return $this->getParentResourceId();
        }

        return $this->parentResource;
    }


    /**
     * setPrivileges
     *
     * @param array $privileges privileges
     *
     * @return void
     */
    public function setPrivileges($privileges)
    {
        $this->privileges = $privileges;
    }

    /**
     * getPrivileges
     *
     * @return array
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    /**
     * setName
     *
     * @param string $name name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        if (empty($this->name)) {
            return $this->getResourceId();
        }

        return $this->name;
    }

    /**
     * setDescription
     *
     * @param string $description description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * isValidResourceId
     *
     * @param string $resourceId resourceId
     *
     * @return bool
     */
    public function isValidResourceId($resourceId)
    {
        if (preg_match('/[^a-z_\-0-9]/i', $resourceId)) {
            return false;
        }

        return true;
    }

    /**
     * populate
     *
     * @param array $data data
     *
     * @return void
     * @throws \RcmUser\Exception\RcmUserException
     */
    public function populate($data = array())
    {
        if (($data instanceof AclResource)) {

            $this->setResourceId($data->getResourceId());
            $this->setParentResourceId($data->getParentResourceId());
            $this->setPrivileges($data->getPrivileges());
            $this->setName($data->getName());
            $this->setDescription($this->getDescription());

            return;
        }

        if (is_array($data)) {
            if (isset($data['resourceId'])) {
                $this->setResourceId($data['resourceId']);
            }
            if (isset($data['parentResourceId'])) {
                $this->setParentResourceId($data['parentResourceId']);
            }
            if (isset($data['privileges'])) {
                $this->setPrivileges($data['privileges']);
            }
            if (isset($data['name'])) {
                $this->setName($data['name']);
            }
            if (isset($data['description'])) {
                $this->setDescription($data['description']);
            }

            return;
        }

        throw new RcmUserException(
            'Resource data could not be populated, data format not supported'
        );
    }

    /**
     * jsonSerialize
     *
     * @return \stdClass
     */
    public function jsonSerialize()
    {
        $obj = new \stdClass();
        $obj->resourceId = $this->getResourceId();
        $obj->parentResourceId = $this->getParentResourceId();
        $obj->privileges = $this->getPrivileges();
        $obj->name = $this->getName();
        $obj->description = $this->getDescription();

        return $obj;
    }
} 