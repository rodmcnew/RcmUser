<?php

namespace RcmUser\Authentication\Service;

use RcmUser\User\Entity\User;

/**
 * Class AuthenticationService
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class AuthenticationService extends \Zend\Authentication\AuthenticationService
{
    /**
     * setIdentity - User to refresh existing session
     *
     * @param User $identity identity
     *
     * @return void
     */
    public function setIdentity(User $identity)
    {
        $storage = $this->getStorage();

        $storage->write($identity);
    }
}
