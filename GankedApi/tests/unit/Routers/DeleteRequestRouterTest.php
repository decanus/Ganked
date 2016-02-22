<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
{
    /**
     * @covers Ganked\API\Routers\DeleteRequestRouter
     * @uses \Ganked\API\Factories\ControllerFactory
     * @uses \Ganked\API\Factories\HandlerFactory
     * @uses \Ganked\API\Factories\CommandFactory
     * @uses \Ganked\API\Factories\ReaderFactory
     * @uses Ganked\API\Controllers\AbstractApiController
     * @uses \Ganked\API\Readers\TokenReader
     * @uses \Ganked\API\Commands\DeleteAccessTokenCommand
     * @uses \Ganked\API\Handlers\Delete\AccessToken\CommandHandler
     * @uses \Ganked\API\Handlers\PreHandler
     */
    class DeleteRequestRouterTest extends GenericRouterTestHelper
    {
        protected function setUp()
        {
            parent::setUp();

            $this->router = new DeleteRequestRouter($this->masterFactory);
            $this->request = $this->getMockBuilder(\Ganked\Api\Http\Request\DeleteRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/token', \Ganked\API\Controllers\GetController::class],
                ['/fooBarError', \Ganked\API\Controllers\ErrorController::class],
            ];
        }
    }
}
