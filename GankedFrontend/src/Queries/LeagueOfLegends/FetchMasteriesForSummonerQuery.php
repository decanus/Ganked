<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{
    class FetchMasteriesForSummonerQuery extends AbstractLeagueOfLegendsQuery
    {
        /**
         * @param string $region
         * @param string $summonerName
         *
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute($region, $summonerName)
        {
            return $this->getGateway()->getMasteriesForSummoner($region, $summonerName);
        }
    }
}
