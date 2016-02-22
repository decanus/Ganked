<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    /**
     * @covers Ganked\Skeleton\Factories\ApplicationFactory
     * @covers Ganked\Skeleton\Factories\MasterFactory
     * @covers Ganked\Skeleton\Factories\SessionFactory
     * @covers Ganked\Skeleton\Factories\QueryFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @covers Ganked\Skeleton\Factories\CommandFactory
     * @covers Ganked\Skeleton\Factories\BackendFactory
     */
    class ApplicationFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createCurlHandle', \Ganked\Library\Curl\Curl::class],
                ['createLeagueOfLegendsDataPoolReader', \Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader::class],
                ['createUriGenerator', \Ganked\Library\Generators\UriGenerator::class],
            ];
        }
    }
}
