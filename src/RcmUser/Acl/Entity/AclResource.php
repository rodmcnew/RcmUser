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
class AclResource extends GenericResource
{
    /**
     * @var string
     */
    protected $description;

    /**
     * __construct
     *
     * @param string $resourceId  resourceId
     * @param string $description description
     */
    public function __construct($resourceId, $description = '')
    {
        parent::__construct($resourceId);
        $this->setDescription($description);
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
} 