<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{
    /**
     * @covers \Ganked\Frontend\Factories\MapperFactory
     * @uses \Ganked\Skeleton\Factories\BackendFactory
     * @uses \Ganked\Frontend\Factories\ReaderFactory
     * @uses \Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses \Ganked\Frontend\Factories\GatewayFactory
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper
     * @uses \Ganked\Skeleton\Backends\Wrappers\Curl
     * @uses \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery
     * @uses \Ganked\Frontend\Mappers\CounterStrikeUserMapper
     * @uses \Ganked\Frontend\Mappers\UserProfileMapper
     * @uses \Ganked\Frontend\Queries\Social\FetchProfileForUsernameQuery
     * @uses \Ganked\Frontend\Queries\Social\HasProfileForUsernameQuery
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsRecentGamesMapper
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsMultiSearchMapper
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRunesMapper
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper
     */
    class MapperFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLeagueOfLegendsSummonerMapper', \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper::class],
                ['createCounterStrikeUserMapper', \Ganked\Frontend\Mappers\CounterStrikeUserMapper::class],
                ['createUserProfileMapper', \Ganked\Frontend\Mappers\UserProfileMapper::class],
                ['createLeagueOfLegendsRecentGamesMapper', \Ganked\Frontend\Mappers\LeagueOfLegendsRecentGamesMapper::class],
                ['createLeagueOfLegendsSummonerRunesMapper', \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRunesMapper::class],
                ['createLeagueOfLegendsMultiSearchMapper', \Ganked\Frontend\Mappers\LeagueOfLegendsMultiSearchMapper::class],
                ['createLeagueOfLegendsSummonerRoleMapper', \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper::class],
            ];
        }
    }
}
