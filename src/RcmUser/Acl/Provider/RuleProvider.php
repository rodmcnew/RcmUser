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
                array(
                    array('r.user'),
                    'core',
                )
            ),

            // Don't mix allow/deny rules if you are using role inheritance.
            // There are some weird bugs.
            //'deny' => array(
                // ...
            //),
        );
    }
}
