<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Session\SessionData;

    class LoginUserCommand
    {
        /**
         * @var SessionData
         */
        private $sessionData;

        /**
         * @param SessionData $sessionData
         */
        public function __construct(SessionData $sessionData)
        {
            $this->sessionData = $sessionData;
        }

        /**
         * @param Email    $email
         * @param Username $username
         * @param string   $id
         *
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function execute(Email $email, Username $username, $id)
        {
            $this->sessionData->setAccount(new RegisteredAccount(new UserId((string) $id), $email, $username));
        }

    }
}
