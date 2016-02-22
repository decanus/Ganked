<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Factories
{
    /**
     * @covers Ganked\Skeleton\Factories\RouterFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @covers Ganked\Skeleton\Factories\MasterFactory
     * @covers Ganked\Skeleton\Factories\QueryFactory
     * @covers Ganked\Skeleton\Factories\SessionFactory
     * @uses \Ganked\Skeleton\Routers\AbstractRouter
     * @uses Ganked\Skeleton\Factories\CommandFactory
     */
    class RouterFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createJsonErrorRouter', \Ganked\Skeleton\Routers\JsonErrorRouter::class]
            ];
        }
    }
}
