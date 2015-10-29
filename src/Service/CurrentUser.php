<?php

namespace RcmUser\Service;

use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\User\Entity\User;

/**
 * Class CurrentUserService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class CurrentUser
{
    /**
     * @var
     */
    protected $authenticationService;

    /**
     * @param UserAuthenticationService $authenticationService
     */
    public function __construct(
        UserAuthenticationService $authenticationService
    ) {
        $this->authenticationService = $authenticationService;
    }

    /**
     * __invoke
     *
     * @param null $default
     *
     * @return mixed|null
     */
    public function __invoke($default = null)
    {
        return $this->get($default = null);
    }

    /**
     * get
     *
     * @param null $default
     *
     * @return User|null
     */
    public function get($default = null)
    {
        return $this->authenticationService->getIdentity($default);
    }
}
