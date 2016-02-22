<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Skeleton\Gateways\AccountGateway;

    class FetchUserHashQuery
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
         * @return string
         */
        public function execute(Email $email)
        {
            return json_decode($this->gateway->getUserHash((string) $email)->getBody(), true)['hash'];
        }

    }
}
