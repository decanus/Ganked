<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Queries\Social
{

    use Ganked\Frontend\Gateways\Social\ProfileGateway;
    use Ganked\Library\ValueObjects\Username;

    class HasProfileForUsernameQuery
    {
        /**
         * @var ProfileGateway
         */
        private $gateway;

        /**
         * @param ProfileGateway $gateway
         */
        public function __construct(ProfileGateway $gateway)
        {
            $this->gateway = $gateway;
        }

        /**
         * @param Username $username
         *
         * @return bool
         */
        public function execute(Username $username)
        {
            return json_decode($this->gateway->hasProfileForUsername((string) $username)->getBody(), true);
        }
    }
}
