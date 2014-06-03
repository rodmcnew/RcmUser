<?php
/**
 * UserPropertyService.php
 *
 * UserPropertyService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Service;


use RcmUser\Event\EventProvider;
use RcmUser\Result;
use RcmUser\User\Entity\User;

/**
 * Class UserPropertyService
 *
 * UserPropertyService
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Service
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserPropertyService extends EventProvider
{

    /**
     * getUserProperty
     *
     * @param User   $user              user
     * @param string $propertyNameSpace propertyNameSpace
     * @param null   $dflt              dflt
     * @param bool   $refresh           refresh
     *
     * @return mixed
     */
    public function getUserProperty(
        User $user,
        $propertyNameSpace,
        $dflt = null,
        $refresh = false
    ) {
        $property = $user->getProperty($propertyNameSpace, null);

        // if a property is not set, see try to get it from an event listener
        if ($property === null || $refresh) {
            // @event getUserProperty.pre -
            $this->getEventManager()->trigger(
                __FUNCTION__,
                $this,
                array('user' => $user, 'propertyNameSpace' => $propertyNameSpace)
            );
        }

        $property = $user->getProperty($propertyNameSpace, $dflt);

        return $property;
    }

    /**
     * getUserPropertyEditUrl
     * Get a link to an edit page for this user
     *
     * @param User   $user              user
     * @param string $propertyNameSpace propertyNameSpace
     *
     * @return mixed
     */
    public function getUserPropertyEditUrl(
        User $user,
        $propertyNameSpace
    ) {
        $results = $this->getEventManager()->trigger(
            __FUNCTION__,
            $this,
            array('user' => $user, 'propertyNameSpace' => $propertyNameSpace),
           function ($result) {
               return $result->isSuccess();
           }
        );

        if ($results->stopped()) {

            return $results->last();
        }

        return new Result(null, Result::CODE_FAIL, 'No property link found.');
    }

} 