<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\Factories
{
    /**
     * @covers Ganked\Services\Factories\ServiceClientFactory
     * @uses \Ganked\Services\ServiceClients\AbstractServiceClient
     * @uses \Ganked\Services\ServiceClients\API\AbstractSteamServiceClient
     * @uses \Ganked\Services\Factories\BackendFactory
     * @uses \Ganked\Services\ServiceClients\API\LoLServiceClient
     */
    class ServiceClientFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                 ['createLoLServiceClient', \Ganked\Services\ServiceClients\API\LoLServiceClient::class],
                 ['createCounterStrikeServiceClient', \Ganked\Services\ServiceClients\API\CounterStrikeServiceClient::class],
                 ['createTwitchServiceClient', \Ganked\Services\ServiceClients\API\TwitchServiceClient::class],
            ];
        }
    }
}
