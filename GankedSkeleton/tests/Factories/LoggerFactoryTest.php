<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 

namespace Ganked\Skeleton\Factories
{

    /**
     * @covers Ganked\Skeleton\Factories\LoggerFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @covers Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\GatewayFactory
     * @uses Ganked\Skeleton\Factories\CommandFactory
     * @uses Ganked\Skeleton\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses \Ganked\Skeleton\Gateways\AbstractGateway
     * @uses \Ganked\Skeleton\Service\AbstractServiceHandler
     */
    class LoggerFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLogger', \Ganked\Library\Logging\Logger::class],
                ['createLoggers', \Ganked\Library\Logging\Logger::class],
                ['createSlackLogger', \Ganked\Library\Logging\Loggers\SlackLogger::class],
            ];
        }
    }
}
