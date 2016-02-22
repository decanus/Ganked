<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;

    class FetchRankedStatsForSummonerQuery extends AbstractLeagueOfLegendsQuery
    {
        /**
         * @param Region       $region
         * @param SummonerName $summonerName
         *
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute(Region $region, SummonerName $summonerName)
        {
            return $this->getGateway()->getRankedStatsForSummoner((string) $summonerName, (string) $region);
        }

    }
}
