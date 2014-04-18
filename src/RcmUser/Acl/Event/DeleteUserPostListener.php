<?php
/**
 * DeleteUserPostListener.php
 *
 * DeleteUserPostListener
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

namespace RcmUser\Acl\Event;


use RcmUseRcmUserResult;

/**
 * DeleteUserPostListener
 *
 * DeleteUserPostListener
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
class DeleteUserPostListener extends AbstractUserDataServiceListener
{

    /**
     * @var string
     */
    protected $event = 'deleteUser.post';
    /**
     * @var int
     */
    protected $priority = 100;

    /**
     * onEvent
     *
     * @param Event $e evnet
     *
     * @return mixed|Result|void
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        $result = $e->getParam('result');

        if ($result->isSuccess()) {

            $user = $result->getUser();

            $aclResult = $this->getUserRolesDataMapper()->delete($user);

            if (!$aclResult->isSuccess()) {

                return $aclResult;
            }

            $user->setProperty(
                $this->getUserPropertyKey(), $this->getDefaultRoleIdentities()
            );

            return new Result($user, Result::CODE_SUCCESS);
        }

        return $result;
    }
} 