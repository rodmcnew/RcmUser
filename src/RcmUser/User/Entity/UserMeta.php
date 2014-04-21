<?php
/**
 * UserMeta.php
 *
 * UserMeta
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Entity;


/**
 * Class UserMeta
 *
 * UserMeta
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserMeta extends AbstractProperty
{

    /**
     * @var DataTime $createDate
     */
    protected $createDate;
    /**
     * @var DataTime $updateDate
     */
    protected $updateDate;
    /**
     * @var mixed $updatedById
     */
    protected $updatedById;

    /**
     * setCreateDate
     *
     * @param DataTime $createDate createDate
     *
     * @return void
     */
    public function setCreateDate(DataTime $createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * getCreateDate
     *
     * @return DataTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * setUpdateDate
     *
     * @param DataTime $updateDate updateDate
     *
     * @return void
     */
    public function setUpdateDate(DataTime $updateDate)
    {
        $this->updateDate = $updateDate;
    }

    /**
     * getUpdateDate
     *
     * @return DataTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * setUpdatedById
     *
     * @param mixed $updatedById updatedById
     *
     * @return void
     */
    public function setUpdatedById($updatedById)
    {
        $this->updatedById = $updatedById;
    }

    /**
     * getUpdatedById
     *
     * @return mixed
     */
    public function getUpdatedById()
    {
        return $this->updatedById;
    }
} 