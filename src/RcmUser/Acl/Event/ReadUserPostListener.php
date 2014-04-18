<?php
/**
 * ReadUserPostListener.php
 *
 * ReadUserPostListener
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


use RcmUser\Result;

/**
 * ReadUserPostListener
 *
 * ReadUserPostListener
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
class ReadUserPostListener extends AbstractUserDataServiceListener
{

    /**
     * @var string
     */
    protected $event = 'readUser.post';
    /**
     * @var int
     */
    protected $priority = 100;

    /**
     * onEvent
     *
     * @param Event $e event
     *
     * @return Result|void
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        $result = $e->getParam('result');
        if ($result->isSuccess()) {

            $user = $result->getUser();

            $readResult = $this->getUserRolesDataMapper()->read($user);

            if ($readResult->isSuccess()) {

                $roles = $readResult->getData();
            } else {

                $roles = $this->getDefaultAuthenticatedRoleIdentities();
            }

            $user->setProperty($this->getUserPropertyKey(), $roles);

            return new Result($user, Result::CODE_SUCCESS);
        }

        return $result;
    }
} 