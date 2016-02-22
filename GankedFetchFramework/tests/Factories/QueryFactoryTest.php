<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Factories
{
    /**
     * @covers Ganked\Fetch\Factories\QueryFactory
     * @uses \Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery
     * @uses \Ganked\Skeleton\Queries\FetchMatchForRegionQuery
     */
    class QueryFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createFetchTwitchTopStreamsQuery', \Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery::class],
                ['createFetchMatchForRegionQuery', \Ganked\Skeleton\Queries\FetchMatchForRegionQuery::class],
            ];
        }
    }
}
