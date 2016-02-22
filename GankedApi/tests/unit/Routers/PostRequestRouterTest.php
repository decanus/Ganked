<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
{
    /**
     * @covers Ganked\API\Routers\PostRequestRouter
     * @uses \Ganked\API\Factories\ControllerFactory
     * @uses \Ganked\API\Factories\HandlerFactory
     * @uses \Ganked\API\Factories\CommandFactory
     * @uses \Ganked\API\Factories\QueryFactory
     * @uses \Ganked\API\Factories\BackendFactory
     * @uses \Ganked\API\Factories\ServiceFactory
     * @uses \Ganked\API\Factories\ReaderFactory
     * @uses Ganked\API\Controllers\AbstractApiController
     * @uses \Ganked\API\Handlers\PreHandler
     * @uses \Ganked\API\Commands\SaveAccessTokenCommand
     * @uses \Ganked\API\Readers\TokenReader
     * @uses \Ganked\API\Handlers\Post\AccessToken\CommandHandler
     * @uses \Ganked\API\Queries\FetchUserIdForAccessTokenQuery
     * @uses \Ganked\API\Handlers\Post\Posts\QueryHandler
     * @uses \Ganked\API\Handlers\Post\Posts\CommandHandler
     * @uses \Ganked\API\Queries\HasPostByIdQuery
     * @uses \Ganked\API\Services\AbstractDatabaseService
     * @uses \Ganked\API\Handlers\Post\Posts\Likes\CommandHandler
     * @uses \Ganked\API\Handlers\Post\Posts\Likes\QueryHandler
     * @uses \Ganked\API\Commands\LikePostCommand
     * @uses \Ganked\API\Commands\InsertUserCommand
     * @uses \Ganked\API\Commands\InsertPostCommand
     * @uses \Ganked\API\Handlers\Post\Users\CommandHandler
     */
    class PostRequestRouterTest extends GenericRouterTestHelper
    {
        protected function setUp()
        {
            parent::setUp();

            $this->router = new PostRequestRouter($this->masterFactory);
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/posts/123412341234123412341234/likes', \Ganked\API\Controllers\GetController::class],
                ['/posts', \Ganked\API\Controllers\GetController::class],
                ['/token', \Ganked\API\Controllers\GetController::class],
                ['/fooBarError', \Ganked\API\Controllers\ErrorController::class],
                ['/users', \Ganked\API\Controllers\GetController::class],
            ];
        }
    }
}
