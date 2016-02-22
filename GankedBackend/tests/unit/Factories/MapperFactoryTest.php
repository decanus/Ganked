<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{

    /**
     * @covers Ganked\Backend\Factories\MapperFactory
     */
    class MapperFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLeagueOfLegendsLeaderboardMapper', \Ganked\Backend\Mappers\LeagueOfLegendsLeaderboardMapper::class],
            ];
        }
    }
}
