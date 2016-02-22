<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Queries
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Skeleton\Gateways\AccountGateway;

    class IsVerifiedForBetaQuery
    {
        /**
         * @var AccountGateway
         */
        private $gateway;

        /**
         * @param AccountGateway $gateway
         */
        public function __construct(AccountGateway $gateway)
        {
            $this->gateway = $gateway;
        }

        /**
         * @param Email $email
         * @return array
         */
        public function execute(Email $email)
        {
            return json_decode($this->gateway->isVerifiedForBeta((string) $email)->getBody(), true);
        }
    }
}
