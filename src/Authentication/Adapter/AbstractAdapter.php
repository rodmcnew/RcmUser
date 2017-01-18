<?php

namespace RcmUser\Authentication\Adapter;

use RcmUser\User\Entity\User;

/**
 * Class AbstractAdapter
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
abstract class AbstractAdapter extends \Zend\Authentication\Adapter\AbstractAdapter implements Adapter
{
    /**
     * @var
     */
    protected $user;

    /**
     * withUser - Immutable setting of the user
     *
     * @param User $user
     *
     * @return UserAdapter|Adapter
     */
    public function withUser(User $user)
    {
        $new = clone($this);
        $new->user = $user;

        return $new;
    }
}
