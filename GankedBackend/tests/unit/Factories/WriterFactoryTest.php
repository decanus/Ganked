<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{

    /**
     * @covers Ganked\Backend\Factories\WriterFactory
     * @uses Ganked\Backend\Factories\BackendFactory
     * @uses \Ganked\Backend\Writers\LeagueOfLegendsLeaderboardWriter
     */
    class WriterFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLeagueOfLegendsLeaderboardWriter', \Ganked\Backend\Writers\LeagueOfLegendsLeaderboardWriter::class],
                ['createStaticPageWriter', \Ganked\Backend\Writers\StaticPageWriter::class],
                ['createLeagueOfLegendsDataPoolWriter', \Ganked\Library\DataPool\LeagueOfLegendsDataPoolWriter::class],
            ];
        }
    }
}
