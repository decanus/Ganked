<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\Gateways\GankedApiGateway;
    use Ganked\Library\ValueObjects\Steam\SteamId;

    class FetchUserWithSteamIdQuery
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
         * @param SteamId $steamId
         *
         * @return array
         */
        public function execute(SteamId $steamId)
        {
            return $this->gateway->getUserWithSteamId($steamId)->getDecodedJsonResponse();
        }
    }
}
