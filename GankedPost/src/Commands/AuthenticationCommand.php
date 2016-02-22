<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Commands
{

    use Ganked\Library\Gateways\GankedApiGateway;

    class AuthenticationCommand
    {
        /**
         * @var GankedApiGateway
         */
        private $gateway;

        /**
         * @param GankedApiGateway $gateway
         */
        public function __construct(GankedApiGateway $gateway)
        {
            $this->gateway = $gateway;
        }

        /**
         * @param string $user
         * @param string $password
         *
         * @return array
         */
        public function execute($user, $password)
        {
            return $this->gateway->authenticate($user, $password)->getDecodedJsonResponse();
        }
    }
}
