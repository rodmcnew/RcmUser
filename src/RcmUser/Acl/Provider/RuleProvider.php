<?php
/**
 *
 */

namespace RcmUser\Acl\Provider;

use BjyAuthorize\Provider\Rule\ProviderInterface;

/**
 *
 */
class RuleProvider implements ProviderInterface
{
    /**
     * @return array
     */
    public function getRules()
    {
        // @todo get from data source
        return array(
            'allow' => array(
                // allow guests and users (and admins, through inheritance)
                // the "wear" privilege on the resource "pants"
                array(array('guest', 'user'), 'core', 'read')
            ),

            // Don't mix allow/deny rules if you are using role inheritance.
            // There are some weird bugs.
            //'deny' => array(
                // ...
            //),
        );
    }
}
