<?php
/**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Model\Authentication\Adapter;


use RcmUser\Model\User\Entity\AbstractUser;
use Zend\Authentication\Adapter\AbstractAdapter;

class RcmUserAdapter extends AbstractAdapter
{

    public $user;


    public function __construct(AbstractUser $user)
    {

        $this->setCredential($user->getPassword());
        $this->setIdentity($user->getUsername());
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
     *               If authentication cannot be performed
     */
    public function authenticate()
    {

    }

    public function isValidCredentials(){

    }
} 