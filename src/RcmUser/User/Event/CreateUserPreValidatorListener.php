<?php
/**
 * CreateUserPreValidatorListener.php
 *
 * CreateUserPreValidatorListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */

namespace RcmUser\User\Event;


use RcmUser\User\Result;

/**
 * Class CreateUserPreValidatorListener
 *
 * CreateUserPreValidatorListener
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmUser\User\Event
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class CreateUserPreValidatorListener extends AbstractUserValidatorListener
{

    protected $event = 'createUser.pre';
    protected $priority = 100;

    /**
     * onEvent
     *
     * @param Event $e e
     *
     * @return Result
     */
    public function onEvent($e)
    {
        //echo $this->priority . ": ". get_class($this) . "\n";

        //$target = $e->getTarget();
        $newUser = $e->getParam('newUser');
        $creatableUser = $e->getParam('creatableUser');

        // run validation rules
        return $this->getUserValidator()->validateCreateUser(
            $newUser,
            $creatableUser
        );
    }
} 