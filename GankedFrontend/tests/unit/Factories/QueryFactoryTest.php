<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{
    /**
     * @covers Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses \Ganked\Frontend\Factories\GatewayFactory
     * @uses Ganked\Frontend\Queries\FetchSummonersByNameQuery
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses Ganked\Skeleton\Backends\Wrappers\Curl
     * @uses \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery
     * @uses \Ganked\Frontend\Queries\FetchRecentGamesForSummonerQuery
     * @uses \Ganked\Frontend\Queries\Social\HasProfileForUsernameQuery
     * @uses \Ganked\Frontend\Queries\Social\FetchProfileForUsernameQuery
     * @uses \Ganked\Frontend\Queries\FetchRunesForSummonerQuery
     * @uses \Ganked\Frontend\Queries\FetchMasteriesForSummonerQuery
     * @uses \Ganked\Frontend\Queries\FetchMatchlistsForSummonersInRegionByUsernameQuery
     * @uses \Ganked\Frontend\Queries\SummonerMultiSearchQuery
     * @uses \Ganked\Frontend\Queries\FetchSummonerCurrentGameQuery
     * @uses \Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Queries\AbstractLeagueOfLegendsQuery
     */
    class QueryFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createFetchSummonersByNameQuery', \Ganked\Frontend\Queries\FetchSummonersByNameQuery::class],
                ['createFetchRecentGamesForSummonerQuery', \Ganked\Frontend\Queries\FetchRecentGamesForSummonerQuery::class],
                ['createFetchSummonerForRegionByNameQuery', \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery::class],
                ['createHasProfileForUsernameQuery', \Ganked\Frontend\Queries\Social\HasProfileForUsernameQuery::class],
                ['createFetchProfileForUsernameQuery', \Ganked\Frontend\Queries\Social\FetchProfileForUsernameQuery::class],
                ['createFetchRunesForSummonerQuery', \Ganked\Frontend\Queries\FetchRunesForSummonerQuery::class],
                ['createFetchMasteriesForSummonerQuery', \Ganked\Frontend\Queries\FetchMasteriesForSummonerQuery::class],
                ['createFetchMatchlistsForSummonersInRegionQuery', \Ganked\Frontend\Queries\FetchMatchlistsForSummonersInRegionByUsernameQuery::class],
                ['createSummonerMultiSearchQuery', \Ganked\Frontend\Queries\SummonerMultiSearchQuery::class],
                ['createFetchSummonerCurrentGameQuery', \Ganked\Frontend\Queries\FetchSummonerCurrentGameQuery::class],
                ['createFetchDefaultLeagueOfLegendsRegionFromSessionQuery', \Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery::class],
                ['createHasDefaultLeagueOfLegendsRegionFromSessionQuery', \Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery::class],
            ];
        }

    }
}
