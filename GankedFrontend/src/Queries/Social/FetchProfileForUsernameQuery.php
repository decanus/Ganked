<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Queries\Social
{

    use Ganked\Library\Gateways\GankedApiGateway;
    use Ganked\Library\ValueObjects\Username;

    class FetchProfileForUsernameQuery
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
         * @return array
         */
        public function execute(Username $username)
        {
            return $this->gateway->getUserWithUsername($username)->getDecodedJsonResponse();
        }
    }
}
