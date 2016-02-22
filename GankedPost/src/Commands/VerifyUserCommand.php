<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Skeleton\Gateways\AccountGateway;

    class VerifyUserCommand
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
         * @param Email $email
         * @return array
         */
        public function execute(Email $email)
        {
            return json_decode($this->accountGateway->setUserVerified((string) $email)->getBody(), true);
        }
   
    }
}
