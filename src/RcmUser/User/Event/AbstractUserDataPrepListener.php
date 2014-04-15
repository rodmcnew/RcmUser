<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\User\Event;


use RcmUser\Event\AbstractListener;
use RcmUser\User\Data\UserDataPreparerInterface;

class AbstractUserDataPrepListener extends AbstractListener  {

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
     * @param UserDataPreparerInterface $UserDataPreparer
     */
    public function setUserDataPreparer(UserDataPreparerInterface $userDataPreparer)
    {
        $this->userDataPreparer = $userDataPreparer;
    }

    /**
     * @return UserDataPreparerInterface
     */
    public function getUserDataPreparer()
    {
        return $this->userDataPreparer;
    }
} 