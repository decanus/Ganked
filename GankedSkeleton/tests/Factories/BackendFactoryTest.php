<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    /**
     * @covers Ganked\Skeleton\Factories\BackendFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Skeleton\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses \Ganked\Skeleton\Backends\Wrappers\Curl
     * @uses Ganked\Skeleton\Factories\CommandFactory
     */
    class BackendFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createFileBackend', \Ganked\Library\Backends\FileBackend::class],
                ['createCurl', \Ganked\Skeleton\Backends\Wrappers\Curl::class],
                ['createRedisBackend', \Ganked\Library\DataPool\RedisBackend::class],
            ];
        }
    }
}
