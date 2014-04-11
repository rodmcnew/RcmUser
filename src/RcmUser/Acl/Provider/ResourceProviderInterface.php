<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Provider;


interface ResourceProviderInterface {

    /**
     * Return a multi-dimensional array of resources and privileges
     * containing ALL possible resources
     *
     * @return array
     */
    public function getAll();


    /**
     * Return a multi-dimensional array of resources and privileges
     * containing a filtered list of resources
     * for example: if you have dynamic resources, you may not want to load these every time the is and acl check,
     * so you have the option to only load them when they are needed
     *
     * @return mixed
     */
    public function getAvailableAtRuntime();
} 