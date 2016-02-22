<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{
    /**
     * @covers Ganked\Post\Factories\RouterFactory
     * @uses \Ganked\Post\Factories\HandlerFactory
     */
    class RouterFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createPostRequestRouter', \Ganked\Post\Routers\PostRequestRouter::class],
            ];
        }
    }
}
