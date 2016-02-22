<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    class FetchSummonerComparisonStatsQuery extends AbstractLeagueOfLegendsQuery
    {
        /**
         * @param array $summoners
         *
         * @return array
         */
        public function execute(array $summoners)
        {
            return json_decode($this->getGateway()->getSummonerComparisonStats($summoners)->getBody(), true);
        }
    }
}
