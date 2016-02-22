<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Factories
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;

    /**
     * @covers Ganked\Fetch\Factories\ControllerFactory
     * @uses Ganked\Fetch\Factories\HandlerFactory
     * @uses Ganked\Fetch\Factories\QueryFactory
     * @uses Ganked\Fetch\Factories\MapperFactory
     * @uses \Ganked\Fetch\Controllers\DataFetchController
     * @uses \Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery
     * @uses \Ganked\Fetch\Mappers\LandingPageStreamMapper
     * @uses \Ganked\Fetch\Handlers\DataFetch\LandingPageStreamDataFetchHandler
     * @uses \Ganked\Fetch\Handlers\DataFetch\LeagueOfLegendsMatchDataFetchHandler
     */
    class ControllerFactoryTest extends GenericFactoryTestHelper
    {
        protected function setUp()
        {
            parent::setUp();
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../data/templates');
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLandingPageStreamController', \Ganked\Fetch\Controllers\DataFetchController::class],
                ['createFetchMatchController', \Ganked\Fetch\Controllers\DataFetchController::class],
            ];

        }
    }
}
