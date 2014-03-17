<?php
/**
 *
 */

namespace RcmUser\Acl\Provider\Rule;

use BjyAuthorize\Provider\Rule\ProviderInterface;

/**
 *
 */
class Provider implements ProviderInterface
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
                array(array('guest', 'user'), 'rmcusertest', 'wear')
            ),

            // Don't mix allow/deny rules if you are using role inheritance.
            // There are some weird bugs.
            //'deny' => array(
                // ...
            //),
        );
    }
}
