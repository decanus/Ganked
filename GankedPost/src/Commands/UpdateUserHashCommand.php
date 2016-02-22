<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Skeleton\Gateways\AccountGateway;

    class UpdateUserHashCommand
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
         * @param Email  $email
         * @param string $hash
         */
        public function execute(Email $email, $hash)
        {
            $this->accountGateway->setUserHash((string) $email, $hash);
        }
    }
}
