<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Readers
{

    use Ganked\Library\Gateways\GankedApiGateway;
    use Ganked\Library\ValueObjects\Username;

    class UserReader
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
         * @param Username $username
         *
         * @return bool
         */
        public function hasUserWithUsername(Username $username)
        {
            return $this->gateway->getUserWithUsername($username)->getResponseCode() === 200;
        }
    }
}
