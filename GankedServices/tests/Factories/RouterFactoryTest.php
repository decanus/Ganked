<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Factories
{

    /**
     * @covers Ganked\Services\Factories\RouterFactory
     * @uses \Ganked\Services\Routers\ServiceRouter
     */
    class RouterFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createServiceRouter', \Ganked\Services\Routers\ServiceRouter::class]
            ];
        }
    }
}
