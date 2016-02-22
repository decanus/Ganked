<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Queries
{
    class FetchSummonersByNameQuery extends AbstractLeagueOfLegendsQuery
    {

        /**
         * @param string $username
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute($username)
        {
            return $this->getGateway()->getSummonersByName($username);
        }
    }
}
