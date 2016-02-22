<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Factories
{
    /**
     * @covers Ganked\Fetch\Factories\HandlerFactory
     * @uses Ganked\Fetch\Factories\QueryFactory
     * @uses Ganked\Fetch\Factories\MapperFactory
     * @uses \Ganked\Fetch\Handlers\DataFetch\LandingPageStreamDataFetchHandler
     * @uses \Ganked\Fetch\Mappers\LandingPageStreamMapper
     * @uses \Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery
     * @uses \Ganked\Fetch\Handlers\DataFetch\LeagueOfLegendsMatchDataFetchHandler
     */
    class HandlerFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLandingPageStreamDataFetchHandler', \Ganked\Fetch\Handlers\DataFetch\LandingPageStreamDataFetchHandler::class],
                ['createLeagueOfLegendsMatchDataFetchHandler', \Ganked\Fetch\Handlers\DataFetch\LeagueOfLegendsMatchDataFetchHandler::class],
            ];
        }
    }
}
