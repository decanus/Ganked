<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{

    /**
     * @covers Ganked\Post\Factories\ControllerFactory
     * @uses Ganked\Post\Factories\QueryFactory
     * @uses Ganked\Post\Factories\CommandFactory
     * @uses Ganked\Post\Factories\HandlerFactory
     * @uses Ganked\Post\Factories\MailFactory
     * @uses Ganked\Post\Factories\BackendFactory
     * @uses \Ganked\Post\Controllers\PostController
     * @uses \Ganked\Post\Backends\MailBackend
     * @uses \Ganked\Post\Mails\AbstractMail
     * @uses \Ganked\Post\Handlers\Redirect\AbstractRedirectHandler
     * @uses \Ganked\Post\Handlers\Redirect\ResendVerificationMailRedirectHandler
     * @uses \Ganked\Post\Commands\InsertUserCommand
     * @uses \Ganked\Post\Handlers\Request\RegistrationRequestHandler
     * @uses \Ganked\Post\Commands\VerifyUserCommand
     * @uses \Ganked\Post\Handlers\Redirect\VerificationRedirectHandler
     * @uses \Ganked\Post\Queries\IsVerifiedForBetaQuery
     * @uses \Ganked\Post\Handlers\Request\AbstractRequestHandler
     * @uses \Ganked\Post\Factories\HandlerFactory
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
    class ControllerFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @param       $method
         * @param       $instance
         * @param array $model
         *
         * @throws \PHPUnit_Framework_Exception
         * @dataProvider provideInstanceNames
         */
        public function testCreateInstanceWorks($method, $instance, $model)
        {
            $modelMock = $this->getMockBuilder($model)
                ->disableOriginalConstructor()
                ->getMock();

            $modelMock->expects($this->any())
                ->method('getTemplatePath')
                ->will($this->returnValue('templates://pages/test.xhtml'));

            $this->assertInstanceOf($instance, call_user_func_array([$this->getMasterFactory(), $method], [$modelMock]));
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLoginRequestController', \Ganked\Post\Controllers\PostController::class, \Ganked\Post\Models\JsonModel::class],
                ['createRegistrationRequestController', \Ganked\Post\Controllers\PostController::class, \Ganked\Post\Models\JsonModel::class],
                ['createVerificationRedirectController', \Ganked\Post\Controllers\PostController::class, \Ganked\Post\Models\JsonModel::class],
                ['createResendVerificationMailRedirectController', \Ganked\Post\Controllers\PostController::class, \Ganked\Post\Models\JsonModel::class],
                ['createLogoutRedirectController', \Ganked\Post\Controllers\PostController::class, \Ganked\Post\Models\JsonModel::class],
                ['createPasswordRecoveryRequestController', \Ganked\Post\Controllers\PostController::class, \Ganked\Post\Models\JsonModel::class],
                ['createForgotPasswordMailRequestController', \Ganked\Post\Controllers\PostController::class, \Ganked\Post\Models\JsonModel::class],
                ['createCreateNewPostController', \Ganked\Post\Controllers\PostController::class, \Ganked\Post\Models\JsonModel::class],
            ];
        }
    }
}
