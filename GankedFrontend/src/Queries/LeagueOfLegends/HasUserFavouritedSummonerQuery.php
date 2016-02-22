<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Library\Gateways\FavouritesGateway;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    class HasUserFavouritedSummonerQuery
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
         * @return bool
         */
        public function execute($userId, $summonerId, Region $region)
        {
            return $this->favouritesGateway->favouritedSummoner($userId, $summonerId, $region)->getDecodedJsonResponse()['data']['isFollowing'];
        }
    }
}
