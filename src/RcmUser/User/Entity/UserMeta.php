<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Entity;


/**
 * Class UserMeta
 *
 * @package RcmUser\User\Entity
 */
class UserMeta extends AbstractProperty {

    /**
     * @var
     */
    protected $createDate;
    /**
     * @var
     */
    protected $updateDate;
    /**
     * @var
     */
    protected $updatedByUuid;

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param mixed $updateDate
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    }

    /**
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param mixed $updatedByUuid
     */
    public function setUpdatedByUuid($updatedByUuid)
    {
        $this->updatedByUuid = $updatedByUuid;
    }

    /**
     * @return mixed
     */
    public function getUpdatedByUuid()
    {
        return $this->updatedByUuid;
    }



} 