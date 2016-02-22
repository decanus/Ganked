<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
{
    /**
     * @covers Ganked\API\Routers\PatchRequestRouter
     * @uses \Ganked\API\Factories\ControllerFactory
     * @uses \Ganked\API\Factories\ServiceFactory
     * @uses \Ganked\API\Factories\HandlerFactory
     * @uses \Ganked\API\Factories\CommandFactory
     * @uses \Ganked\API\Factories\BackendFactory
     * @uses \Ganked\API\Factories\ReaderFactory
     * @uses \Ganked\API\Factories\QueryFactory
     * @uses \Ganked\API\Handlers\Patch\Users\QueryHandler
     * @uses \Ganked\API\Handlers\Patch\Users\CommandHandler
     * @uses \Ganked\API\Commands\UpdateUserCommand
     * @uses \Ganked\API\Readers\TokenReader
     * @uses Ganked\API\Services\AbstractDatabaseService
     * @uses Ganked\API\Controllers\AbstractApiController
     * @uses \Ganked\API\Queries\FetchUserByIdQuery
     * @uses \Ganked\API\Handlers\PreHandler
     */
    class PatchRequestRouterTest extends GenericRouterTestHelper
    {
        protected function setUp()
        {
            parent::setUp();

            $this->router = new PatchRequestRouter($this->masterFactory);
            $this->request = $this->getMockBuilder(\Ganked\Api\Http\Request\PatchRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/users/55dac07209edfe700d8b4567', \Ganked\API\Controllers\GetController::class]
            ];
        }
    }
}
