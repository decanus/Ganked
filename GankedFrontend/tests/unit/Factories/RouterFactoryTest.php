<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{
    /**
     * @covers Ganked\Frontend\Factories\RouterFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Frontend\Factories\ReaderFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Factories\GatewayFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Frontend\Routers\StaticPageRouter
     * @uses Ganked\Frontend\Routers\AccountPageRouter
     * @uses Ganked\Frontend\Routers\SearchPageRouter
     * @uses \Ganked\Frontend\Routers\LeagueOfLegendsPageRouter
     * @uses \Ganked\Frontend\Routers\RedirectRouter
     * @uses \Ganked\Frontend\Factories\MapperFactory
     * @uses \Ganked\Skeleton\Backends\Wrappers\Curl
     * @uses \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery
     * @uses \Ganked\Frontend\Routers\CounterStrikePageRouter
     * @uses \Ganked\Frontend\Routers\UserPageRouter
     * @uses \Ganked\Frontend\Mappers\CounterStrikeUserMapper
     * @uses \Ganked\Skeleton\Session\Session
     * @uses \Ganked\Skeleton\Session\SessionData
     * @uses \Ganked\Frontend\Queries\Social\HasProfileForUsernameQuery
     * @uses \Ganked\Frontend\Queries\Social\FetchProfileForUsernameQuery
     * @uses \Ganked\Frontend\Mappers\UserProfileMapper
     * @uses \Ganked\Frontend\Readers\UrlRedirectReader
     * @uses \Ganked\Frontend\Readers\LeagueOfLegendsReader
     * @uses \Ganked\Frontend\Readers\UserReader
     * @uses \Ganked\Frontend\Routers\SteamLoginRouter
     * @uses \Ganked\Frontend\Readers\CounterStrikeReader
     */
    class RouterFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createAccountPageRouter', \Ganked\Frontend\Routers\AccountPageRouter::class],
                ['createStaticPageRouter', \Ganked\Frontend\Routers\StaticPageRouter::class],
                ['createSearchPageRouter', \Ganked\Frontend\Routers\SearchPageRouter::class],
                ['createLeagueOfLegendsPageRouter', \Ganked\Frontend\Routers\LeagueOfLegendsPageRouter::class],
                ['createCounterStrikePageRouter', \Ganked\Frontend\Routers\CounterStrikePageRouter::class],
                ['createErrorPageRouter', \Ganked\Frontend\Routers\ErrorPageRouter::class],
                ['createUserPageRouter', \Ganked\Frontend\Routers\UserPageRouter::class],
                ['createRedirectRouter', \Ganked\Frontend\Routers\RedirectRouter::class],
                ['createSteamLoginRouter', \Ganked\Frontend\Routers\SteamLoginRouter::class],
            ];
        }
    }
}
