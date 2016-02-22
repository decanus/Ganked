<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    class SummonerMultiSearchQuery extends AbstractLeagueOfLegendsQuery
    {
        /**
         * @param array  $summoners
         * @param Region $region
         *
         * @return array
         */
        public function execute(array $summoners, Region $region)
        {
            return json_decode($this->getGateway()->summonerMultiSearch($summoners, (string) $region)->getBody(), true);
        }

    }
}
