<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    /**
     * @covers Ganked\Frontend\Factories\ReaderFactory
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses \Ganked\Frontend\Readers\UrlRedirectReader
     * @uses \Ganked\Frontend\Readers\LeagueOfLegendsReader
     * @uses \Ganked\Frontend\Readers\UserReader
     * @uses Ganked\Frontend\Factories\RouterFactory
     */
    class ReaderFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createUrlRedirectReader', \Ganked\Frontend\Readers\UrlRedirectReader::class],
                ['createLeagueOfLegendsReader', \Ganked\Frontend\Readers\LeagueOfLegendsReader::class],
                ['createUserReader', \Ganked\Frontend\Readers\UserReader::class],
            ];
        }
    }
}
