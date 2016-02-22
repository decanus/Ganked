<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    /**
     * @covers Ganked\API\Factories\RouterFactory
     */
    class RouterFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createGetRequestRouter', \Ganked\API\Routers\GetRequestRouter::class],
                ['createPostRequestRouter', \Ganked\API\Routers\PostRequestRouter::class],
                ['createDeleteRequestRouter', \Ganked\API\Routers\DeleteRequestRouter::class],
                ['createPatchRequestRouter', \Ganked\API\Routers\PatchRequestRouter::class],
            ];
        }
    }
}
