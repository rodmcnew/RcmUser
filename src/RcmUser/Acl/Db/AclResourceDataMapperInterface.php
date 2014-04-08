<?php
 /**
 * @category  RCM
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2012 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: reliv
 * @link      http://ci.reliv.com/confluence
 */

namespace RcmUser\Acl\Db;


interface AclResourceDataMapperInterface {

    public function create(AclRole $aclRole);

    public function read(AclRole $aclRole);

    public function update(AclRole $aclRole);

    public function delete(AclRole $aclRole);

} 