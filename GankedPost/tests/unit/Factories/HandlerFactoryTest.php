<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 

namespace Ganked\Post\Factories
{

    /**
     * @covers Ganked\Post\Factories\HandlerFactory
     * @uses Ganked\Post\Factories\CommandFactory
     * @uses Ganked\Post\Factories\QueryFactory
     * @uses Ganked\Post\Factories\MailFactory
     * @uses Ganked\Post\Factories\BackendFactory
     * @uses \Ganked\Post\Handlers\Request\LoginRequestHandler
     * @uses \Ganked\Post\Handlers\Request\RegistrationRequestHandler
     * @uses \Ganked\Post\Handlers\Redirect\LogoutRedirectHandler
     * @uses \Ganked\Post\Handlers\Redirect\ResendVerificationMailRedirectHandler
     * @uses \Ganked\Post\Handlers\Redirect\VerificationRedirectHandler
     * @uses \Ganked\Post\Handlers\Redirect\AbstractRedirectHandler
     * @uses \Ganked\Post\Commands\VerifyUserCommand
     * @uses \Ganked\Post\Backends\MailBackend
     * @uses \Ganked\Post\Mails\AbstractMail
     * @uses \Ganked\Post\Handlers\Request\AbstractRequestHandler
     * @uses \Ganked\Post\Queries\IsVerifiedForBetaQuery
     * @uses \Ganked\Post\Commands\InsertUserCommand
     * @uses \Ganked\Post\Commands\LoginUserCommand
     * @uses \Ganked\Post\Queries\HasBetaRequestQuery
     * @uses \Ganked\Skeleton\Queries\FetchUserHashQuery
     * @uses \Ganked\Skeleton\Queries\FetchAccountQuery
     * @uses \Ganked\Post\Commands\UpdateUserHashCommand
     * @uses \Ganked\Post\Handlers\Request\ForgotPasswordMailRequestHandler
     * @uses \Ganked\Post\Handlers\Request\PasswordRecoveryRequestHandler
     * @uses \Ganked\Post\Commands\UpdateUserPasswordCommand
     * @uses \Ganked\Post\Handlers\Request\CreateNewPostRequestHandler
     * @uses \Ganked\Post\Commands\CreateNewPostCommand
     * @uses \Ganked\Post\Commands\AuthenticationCommand
     */
    class HandlerFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLoginRequestHandler', \Ganked\Post\Handlers\Request\LoginRequestHandler::class],
                ['createRegistrationRequestHandler', \Ganked\Post\Handlers\Request\RegistrationRequestHandler::class],
                ['createLogoutRedirectHandler', \Ganked\Post\Handlers\Redirect\LogoutRedirectHandler::class],
                ['createResendVerificationMailRedirectHandler', \Ganked\Post\Handlers\Redirect\ResendVerificationMailRedirectHandler::class],
                ['createVerificationRedirectHandler', \Ganked\Post\Handlers\Redirect\VerificationRedirectHandler::class],
                ['createForgotPasswordMailRequestHandler', \Ganked\Post\Handlers\Request\ForgotPasswordMailRequestHandler::class],
                ['createPasswordRecoveryRequestHandler', \Ganked\Post\Handlers\Request\PasswordRecoveryRequestHandler::class],
                ['createCreateNewPostRequestHandler', \Ganked\Post\Handlers\Request\CreateNewPostRequestHandler::class],
            ];
        }
    }
}
