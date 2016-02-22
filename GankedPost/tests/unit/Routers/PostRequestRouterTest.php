<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Routers
{
    /**
     * @covers Ganked\Post\Routers\PostRequestRouter
     * @uses \Ganked\Post\Factories\MailFactory
     * @uses \Ganked\Post\Factories\ControllerFactory
     * @uses \Ganked\Post\Factories\BackendFactory
     * @uses \Ganked\Post\Factories\CommandFactory
     * @uses \Ganked\Post\Factories\QueryFactory
     * @uses \Ganked\Post\Factories\HandlerFactory
     * @uses \Ganked\Post\Mails\AbstractMail
     * @uses \Ganked\Post\Controllers\PostController
     * @uses \Ganked\Post\Backends\MailBackend
     * @uses \Ganked\Post\Handlers\AbstractHandler
     * @uses \Ganked\Post\Handlers\Redirect\AbstractRedirectHandler
     * @uses \Ganked\Post\Handlers\Request\AbstractRequestHandler
     * @uses \Ganked\Post\Handlers\Redirect\ResendVerificationMailRedirectHandler
     * @uses \Ganked\Post\Queries\IsVerifiedForBetaQuery
     * @uses \Ganked\Post\Commands\VerifyUserCommand
     * @uses \Ganked\Post\Handlers\Redirect\VerificationRedirectHandler
     * @uses \Ganked\Post\Commands\InsertUserCommand
     * @uses \Ganked\Post\Handlers\Request\RegistrationRequestHandler
     * @uses \Ganked\Post\Handlers\Redirect\LogoutRedirectHandler
     * @uses \Ganked\Post\Handlers\Request\LoginRequestHandler
     * @uses \Ganked\Post\Commands\LoginUserCommand
     * @uses \Ganked\Post\Queries\HasBetaRequestQuery
     * @uses \Ganked\Skeleton\Queries\FetchUserHashQuery
     * @uses \Ganked\Post\Commands\UpdateUserHashCommand
     * @uses \Ganked\Post\Handlers\Request\ForgotPasswordMailRequestHandler
     * @uses \Ganked\Post\Handlers\Request\PasswordRecoveryRequestHandler
     * @uses \Ganked\Post\Commands\UpdateUserPasswordCommand
     * @uses \Ganked\Post\Handlers\Request\CreateNewPostRequestHandler
     * @uses \Ganked\Post\Commands\CreateNewPostCommand
     * @uses \Ganked\Skeleton\Queries\FetchAccountQuery
     * @uses \Ganked\Post\Commands\AuthenticationCommand
     */
    class PostRequestRouterTest extends GenericRouterTestHelper
    {
        protected function setUp()
        {
            parent::setUp();
            $this->router = new PostRequestRouter($this->masterFactory);
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/action/login',  \Ganked\Post\Controllers\PostController::class],
                ['/action/register',  \Ganked\Post\Controllers\PostController::class],
                ['/action/resend-verification',  \Ganked\Post\Controllers\PostController::class],
                ['/action/logout',  \Ganked\Post\Controllers\PostController::class],
                ['/action/verify', \Ganked\Post\Controllers\PostController::class],
                ['/action/forgot-password', \Ganked\Post\Controllers\PostController::class],
                ['/action/recover-password', \Ganked\Post\Controllers\PostController::class],
                ['/action/post/create', \Ganked\Post\Controllers\PostController::class],
            ];
        }

        public function testReturnsNullIfNotPostRequest()
        {
            $request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)->disableOriginalConstructor()->getMock();

            $request
                ->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue($uri));

            $uri
                ->expects($this->any())
                ->method('getPath')
                ->will($this->returnValue('/action/beta-request'));

            $this->assertSame(null, $this->router->route($request));
        }
    }
}
