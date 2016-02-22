<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Factories
{
    /**
     * @covers \Ganked\Fetch\Factories\MapperFactory
     * @uses \Ganked\Fetch\Mappers\LandingPageStreamMapper
     */
    class MapperFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLandingPageStreamMapper', \Ganked\Fetch\Mappers\LandingPageStreamMapper::class],
            ];
        }
    }
}
