<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Commands
{

    use Ganked\Library\Gateways\FavouritesGateway;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    class UnfavouriteSummonerCommand
    {
        /**
         * @var FavouritesGateway
         */
        private $favouritesGateway;

        /**
         * @param FavouritesGateway $favouritesGateway
         */
        public function __construct(FavouritesGateway $favouritesGateway)
        {
            $this->favouritesGateway = $favouritesGateway;
        }

        /**
         * @param string $userId
         * @param string $summonerId
         * @param Region $region
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function execute($userId, $summonerId, Region $region)
        {
            return $this->favouritesGateway->unfavouriteSummoner($userId, $summonerId, $region);
        }
    }
}