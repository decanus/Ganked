<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Queries
{
    class FetchRecentGamesForSummonerQuery extends AbstractLeagueOfLegendsQuery
    {
        /**
         * @param string $region
         * @param int    $id
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute($region, $id)
        {
            return $this->getGateway()->getRecentGamesForSummoner($region, $id);
        }
    }
}
