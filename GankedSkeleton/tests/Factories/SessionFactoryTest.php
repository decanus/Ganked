<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{

    use Ganked\Skeleton\Session\Session;

    /**
     * @covers Ganked\Skeleton\Factories\SessionFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @covers Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\CommandFactory
     * @uses Ganked\Skeleton\Session\Session
     * @uses Ganked\Library\ValueObjects\Token
     * @uses \Ganked\Skeleton\Session\SessionDataPool
     */
    class SessionFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createSession', Session::class],
                ['createSessionDataPool', \Ganked\Skeleton\Session\SessionDataPool::class],
            ];
        }
    }
}
