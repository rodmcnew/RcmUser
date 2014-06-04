<?php
/**
 * UserPropertyServiceListeners.php
 *
 * UserPropertyServiceListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Event;


use RcmUser\User\Entity\Link;
use RcmUser\User\Entity\Links;
use RcmUser\User\Entity\User;
use RcmUser\User\Entity\UserRoleProperty;
use RcmUser\User\Result;
use RcmUser\User\Service\UserRoleService;

/**
 * UserPropertyServiceListeners
 *
 * UserPropertyServiceListeners
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\Acl\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class UserPropertyServiceListeners extends AbstractUserDataServiceListeners
{
    /**
     * @var int $priority
     */
    protected $priority = 1;
    /**
     * @var array $listenerMethods
     */
    protected $listenerMethods
        = array(
            'onGetUserPropertyLinks' => 'getUserPropertyLinks',
        );

    /**
     * getUserPropertyKey
     *
     * @return string
     */
    public function getUserPropertyKey()
    {
        return UserRoleProperty::PROPERTY_KEY;
    }

    /**
     * onGetUserPropertyLinks
     *
     * @param Event $e e
     *
     * @return \RcmUser\Result
     */
    public function onGetUserPropertyLinks($e)
    {
        $user = $e->getParam('user');
        $propertyNameSpace = $e->getParam('propertyNameSpace');
        $thisPropertyNameSpace = $this->getUserPropertyKey();

        if($propertyNameSpace !== $thisPropertyNameSpace){

            return false;
        }

        $links = new Links();
        $link = new Link();
        $link->setTitle('Edit User Roles');
        $link->setType('edit');
        $link->setHelp('Edit page for adding removing user roles.');
        $link->getUrl('');
        $links->addLink($link);

        return new Result($links);
    }

    public function onGetUserPropertyIsAlloweds($e)
    {
        $user = $e->getParam('user');
        $propertyNameSpace = $e->getParam('propertyNameSpace');
        $thisPropertyNameSpace = $this->getUserPropertyKey();

        if($propertyNameSpace !== $thisPropertyNameSpace){

            return false;
        }

        $links = new Links();
        $link = new Link();
        $link->setTitle('Edit User Roles');
        $link->setType('edit');
        $link->setHelp('Edit page for adding removing user roles.');
        $link->getUrl('');
        $links->addLink($link);

        return new Result($links);
    }


} 