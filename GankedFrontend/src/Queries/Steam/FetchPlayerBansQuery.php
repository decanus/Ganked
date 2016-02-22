<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Skeleton\Gateways\SteamGateway;

    class FetchPlayerBansQuery
    {
        /**
         * @var SteamGateway
         */
        private $steamGateway;

        /**
         * @param SteamGateway $steamGateway
         */
        public function __construct(SteamGateway $steamGateway)
        {
            $this->steamGateway = $steamGateway;
        }

        /**
         * @param array $steamIds
         *
         * @return array
         */
        public function execute(array $steamIds = [])
        {
            return json_decode($this->steamGateway->getPlayerBans($steamIds)->getBody(), true);
        }
    }
}
