<?php

/**
* Copyright (c) Ganked 2015
* All rights reserved.
*/

namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Hash;
    use Ganked\Skeleton\Gateways\AccountGateway;

    class UpdateUserPasswordCommand
    {

        /**
         * @var AccountGateway
         */
        private $accountGateway;

        /**
         * @param AccountGateway $accountGateway
         */
        public function __construct(AccountGateway $accountGateway)
        {
            $this->accountGateway = $accountGateway;
        }

        /**
         * @param Hash $hash
         * @param Email $email
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute(Hash $hash, Email $email)
        {
            return $this->accountGateway->updateUserPassword((string) $hash, (string) $email);
        }
    }
}
