<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Commands
{

    use Ganked\API\Services\FavouritesService;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    class UnfavouriteSummonerCommand
    {
        /**
         * @var FavouritesService
         */
        private $favouritesService;

        /**
         * @param FavouritesService $favouritesService
         */
        public function __construct(FavouritesService $favouritesService)
        {
            $this->favouritesService = $favouritesService;
        }

        /**
         * @param \MongoId $userId
         * @param string   $summonerId
         * @param Region   $region
         *
         * @return array|bool
         */
        public function execute(\MongoId $userId, $summonerId, Region $region)
        {
            return $this->favouritesService->unfavouriteSummoner($userId, $summonerId, $region);
        }
    }
}
