<?php
/**
 * AbstractUserDataPrepListener.php
 *
 * AbstractUserDataPrepListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Event;


use RcmUser\Event\AbstractListener;
use RcmUser\User\Data\UserDataPreparerInterface;

/**
 * Class AbstractUserDataPrepListener
 *
 * AbstractUserDataPrepListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractUserDataPrepListener extends AbstractListener
{

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    protected $id = 'RcmUser\User\Service\UserDataService';
    protected $event = 'userDataPrep';
    protected $priority = 5;

    /**
     * @var UserDataPreparerInterface
     */
    protected $userDataPreparer;

    /**
     * setUserDataPreparer
     *
     * @param UserDataPreparerInterface $userDataPreparer userDataPreparer
     *
     * @return void
     */
    public function setUserDataPreparer(UserDataPreparerInterface $userDataPreparer)
    {
        $this->userDataPreparer = $userDataPreparer;
    }

    /**
     * getUserDataPreparer
     *
     * @return UserDataPreparerInterface
     */
    public function getUserDataPreparer()
    {
        return $this->userDataPreparer;
    }
} 