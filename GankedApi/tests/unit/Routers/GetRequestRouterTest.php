<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
{
    /**
     * @covers Ganked\API\Routers\GetRequestRouter
     * @uses Ganked\API\Services\AbstractDatabaseService
     * @uses \Ganked\API\Queries\GetUserFromDatabaseQuery
     * @uses \Ganked\API\Factories\ControllerFactory
     * @uses \Ganked\API\Factories\ServiceFactory
     * @uses \Ganked\API\Factories\HandlerFactory
     * @uses \Ganked\API\Factories\ReaderFactory
     * @uses \Ganked\API\Factories\BackendFactory
     * @uses \Ganked\API\Factories\QueryFactory
     * @uses \Ganked\API\Controllers\GetController
     * @uses \Ganked\API\Handlers\Get\Users\QueryHandler
     * @uses \Ganked\API\Handlers\Get\Users\Posts\QueryHandler
     * @uses \Ganked\API\Handlers\PreHandler
     * @uses \Ganked\API\Readers\TokenReader
     * @uses \Ganked\API\Queries\GetPostsForUserQuery
     * @uses Ganked\API\Controllers\AbstractApiController
     * @uses \Ganked\API\Handlers\Get\Posts\QueryHandler
     * @uses \Ganked\API\Queries\GetPostByIdQuery
     * @uses \Ganked\API\Queries\FetchPostsByIdsQuery
     * @uses \Ganked\API\Queries\FetchUserByIdQuery
     * @uses \Ganked\API\Queries\FetchAccountWithEmailQuery
     * @uses \Ganked\API\Queries\FetchAccountWithUsernameQuery
     * @uses \Ganked\API\Handlers\Get\Account\QueryHandler
     * @uses \Ganked\API\Queries\FetchUserBySteamIdQuery
     */
    class GetRequestRouterTest extends GenericRouterTestHelper
    {
        protected function setUp()
        {
            parent::setUp();

            $this->router = new GetRequestRouter($this->masterFactory);
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/users/foobar', \Ganked\API\Controllers\GetController::class],
                ['/users/55dac07209edfe700d8b4567/posts', \Ganked\API\Controllers\GetController::class],
                ['/accounts/foobar', \Ganked\API\Controllers\GetController::class],
                ['/accounts/foobar@bar.net', \Ganked\API\Controllers\GetController::class],
                ['/posts/123456789123456789123456', \Ganked\API\Controllers\GetController::class],
                ['/', \Ganked\API\Controllers\ErrorController::class],
            ];
        }
    }
}
