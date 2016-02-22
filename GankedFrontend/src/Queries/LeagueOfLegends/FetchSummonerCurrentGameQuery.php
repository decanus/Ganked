<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;

    class FetchSummonerCurrentGameQuery extends AbstractLeagueOfLegendsQuery
    {

        /**
         * @param SummonerName $summonerName
         * @param Region       $region
         *
         * @return array
         */
        public function execute(SummonerName $summonerName, Region $region)
        {
            return json_decode($this->getGateway()->getCurrentGameForSummonerInRegionWithData((string) $summonerName, (string) $region)->getBody(), true);
        }
    }
}
