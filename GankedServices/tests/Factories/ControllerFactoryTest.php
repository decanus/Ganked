<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\Factories
{
    /**
     * @covers Ganked\Services\Factories\ControllerFactory
     * @uses Ganked\Services\Factories\BackendFactory
     * @uses Ganked\Services\Factories\ServiceClientFactory
     * @uses \Ganked\Services\Controllers\SlackController
     * @uses \Ganked\Services\Backends\SlackBackend
     * @uses \Ganked\Services\ServiceClients\API\AbstractSteamServiceClient
     * @uses \Ganked\Services\Controllers\ServiceClientController
     * @uses \Ganked\Services\ServiceClients\AbstractServiceClient
     * @uses \Ganked\Services\ServiceClients\API\LoLServiceClient
     */
    class ControllerFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @param $method
         * @param $instance
         * @param $model
         * @dataProvider provideInstanceNames
         */
        public function testCreateInstanceWorks($method, $instance, $model)
        {
            $modelMock = $this->getMockBuilder($model)
                ->disableOriginalConstructor()
                ->getMock();

            $this->assertInstanceOf($instance, call_user_func_array([$this->getMasterFactory(), $method], [$modelMock]));
        }


        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createSlackController', \Ganked\Services\Controllers\SlackController::class, \Ganked\Services\Models\ServiceModel::class],
                ['createTwitchServiceClientController', \Ganked\Services\Controllers\ServiceClientController::class, \Ganked\Services\Models\ServiceModel::class],
                ['createLoLServiceClientController', \Ganked\Services\Controllers\ServiceClientController::class, \Ganked\Services\Models\ServiceModel::class],
                ['createCounterStrikeServiceClientController', \Ganked\Services\Controllers\ServiceClientController::class, \Ganked\Services\Models\ServiceModel::class],
            ];
        }
    }
}
