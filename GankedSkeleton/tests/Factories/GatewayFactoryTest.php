<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 

namespace Ganked\Skeleton\Factories
{

    /**
     * @covers Ganked\Skeleton\Factories\GatewayFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @covers Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\CommandFactory
     * @uses Ganked\Skeleton\Factories\LoggerFactory
     * @uses Ganked\Skeleton\Factories\ApplicationFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses \Ganked\Skeleton\Service\AbstractServiceHandler
     * @uses \Ganked\Skeleton\Gateways\AbstractGateway
     */
    class GatewayFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createSlackGateway', \Ganked\Skeleton\Gateways\SlackGateway::class],
                ['createLoLGateway', \Ganked\Skeleton\Gateways\LoLGateway::class],
                ['createTwitchGateway', \Ganked\Skeleton\Gateways\TwitchGateway::class],
                ['createCounterStrikeGateway', \Ganked\Skeleton\Gateways\CounterStrikeGateway::class],
                ['createGankedApiGateway', \Ganked\Library\Gateways\GankedApiGateway::class],
                ['createGetServiceHandler', \Ganked\Skeleton\Service\GetServiceHandler::class],
                ['createPostServiceHandler', \Ganked\Skeleton\Service\PostServiceHandler::class],
            ];
        }
    }
}
