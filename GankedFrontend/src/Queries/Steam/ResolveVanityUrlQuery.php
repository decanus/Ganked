<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Library\ValueObjects\Steam\SteamCustomId;
    use Ganked\Skeleton\Gateways\SteamGateway;

    class ResolveVanityUrlQuery
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
         * @param SteamCustomId $steamCustomId
         *
         * @return array
         */
        public function execute(SteamCustomId $steamCustomId)
        {
            return json_decode($this->steamGateway->resolveVanityUrl((string) $steamCustomId)->getBody(), true);
        }
    }
}
