<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Factories
{
    /**
     * @covers Ganked\Skeleton\Factories\CommandFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @covers Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\QueryFactory
     * @uses \Ganked\Skeleton\Commands\WriteSessionCommand
     * @uses \Ganked\Skeleton\Commands\StorePreviousUriCommand
     * @uses \Ganked\Skeleton\Commands\DestroySessionCommand
     * @uses \Ganked\Skeleton\Session\Session
     * @uses \Ganked\Skeleton\Session\SessionDataPool
     */
    class CommandFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createWriteSessionCommand', \Ganked\Skeleton\Commands\WriteSessionCommand::class],
                ['createStorePreviousUriCommand', \Ganked\Skeleton\Commands\StorePreviousUriCommand::class],
                ['createDestroySessionCommand', \Ganked\Skeleton\Commands\DestroySessionCommand::class],
            ];
        }
    }
}
