<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Queries
{

    class FetchSummonerForRegionByNameQuery extends AbstractLeagueOfLegendsQuery
    {

        /**
         * @param string $region
         * @param string $username
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute($region, $username)
        {
            return $this->getGateway()->getSummonerForRegionByName($region, $username);
        }
    }
}
