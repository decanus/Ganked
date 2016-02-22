<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Factories
{
    /**
     * @covers Ganked\Fetch\Factories\RouterFactory
     */
    class RouterFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createDataFetchRouter', \Ganked\Fetch\Routers\DataFetchRouter::class],
            ];
        }
    }
}
