<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Service;


use RcmUser\Model\Event\EventProvider;

class RcmUserPropertyService  extends EventProvider {

    /**
     * Expects the listener to set the property on the user object
     * @param User $user
     * @param string $propertyNameSpace
     * @param mixed $dflt default
     * @param bool $refresh
     *
     * @return mixed
     */
    public function getUserProperty(User $user, $propertyNameSpace, $dflt = null, $refresh = false)
    {
        $property = $user->getProperty($propertyNameSpace, null);

        // if a property is not set, see try to get it from an event listener
        if ($property === null || $refresh) {
            // @event getUserProperty.pre -
            $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('user' => $user, 'propertyNameSpace' => $propertyNameSpace));
        }

        $property = $user->getProperty($propertyNameSpace, $dflt);

        return $property;
    }

} 