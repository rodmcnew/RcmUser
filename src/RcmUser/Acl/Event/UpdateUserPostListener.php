<?php
/**
 * UpdateUserPostListener.php
 *
 * UpdateUserPostListener
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


use RcmUser\User\Result;

/**
 * UpdateUserPostListener
 *
 * UpdateUserPostListener
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
class UpdateUserPostListener extends AbstractUserDataServiceListener
{

    /**
     * @var string
     */
    protected $event = 'updateUser.post';
    /**
     * @var int
     */
    protected $priority = 100;

    /**
     * onEvent
     *
     * @param Event $e event
     *
     * @return mixed|Result|void
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        //$target = $e->getTarget();
        $result = $e->getParam('result');

        if ($result->isSuccess()) {

            $user = $result->getUser();

            $currentRoles = $user->getProperty($this->getUserPropertyKey(), null);

            if ($currentRoles === null) {

                $user->setProperty(
                    $this->getUserPropertyKey(),
                    $this->getDefaultAuthenticatedRoleIdentities()
                );
            }

            $aclResult = $this->getUserRolesDataMapper()->update(
                $user, $user->getProperty($this->getUserPropertyKey(), array())
            );

            if (!$aclResult->isSuccess()) {

                return $aclResult;
            }

            $user->setProperty($this->getUserPropertyKey(), $aclResult->getData());

            return new Result($user, Result::CODE_SUCCESS);
        }

        return $result;
    }
} 