<?php

namespace RcmUser\Log\Event;

use RcmUser\Authentication\Service\UserAuthenticationService;
use RcmUser\User\Entity\User;
use Zend\Authentication\Result;
use Zend\EventManager\Event;

class OnAuthenticateFailListener extends AbstractLoggerListener implements LoggerListener
{
    /**
     * @var string|array
     */
    protected $identifier = UserAuthenticationService::class;

    /**
     * @var string
     */
    protected $event = UserAuthenticationService::EVENT_AUTHENTICATE_FAIL;

    /**
     * getMessage
     *
     * @param Event $event
     *
     * @return string
     */
    protected function getMessage(Event $event)
    {
        $message = $this->identifier . ':' . $this->event;

        /** @var User $requestUser */
        $requestUser = $event->getParam('user');

        /** @var Result $result */
        $result = $event->getParam('result');

        $message = $message . " UserName: {$requestUser->getUsername()}";
        $resultMessages = json_encode($result->getMessages());
        $message = $message . " ResultMessages: {$resultMessages}";

        // @todo log: SessionId, IP, current user id


        return $message;
    }
}
