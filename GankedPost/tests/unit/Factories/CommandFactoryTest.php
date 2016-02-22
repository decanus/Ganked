<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{
    /**
     * @covers Ganked\Post\Factories\CommandFactory
     * @uses Ganked\Post\Factories\QueryFactory
     * @uses Ganked\Post\Factories\BackendFactory
     * @uses Ganked\Post\Factories\MailFactory
     * @uses \Ganked\Post\Mails\AbstractMail
     * @uses \Ganked\Post\Backends\MailBackend
     * @uses \Ganked\Post\Commands\VerifyUserCommand
     * @uses \Ganked\Post\Commands\InsertUserCommand
     * @uses \Ganked\Post\Commands\LoginUserCommand
     * @uses \Ganked\Post\Factories\HandlerFactory
     * @uses \Ganked\Post\Commands\UpdateUserHashCommand
     * @uses \Ganked\Post\Commands\UpdateUserPasswordCommand
     * @uses \Ganked\Post\Commands\CreateNewPostCommand
     * @uses \Ganked\Post\Commands\AuthenticationCommand
     */
    class CommandFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLoginUserCommand', \Ganked\Post\Commands\LoginUserCommand::class],
                ['createInsertUserCommand', \Ganked\Post\Commands\InsertUserCommand::class],
                ['createVerifyUserCommand', \Ganked\Post\Commands\VerifyUserCommand::class],
                ['createUpdateUserHashCommand', \Ganked\Post\Commands\UpdateUserHashCommand::class],
                ['createUpdateUserPasswordCommand', \Ganked\Post\Commands\UpdateUserPasswordCommand::class],
                ['createCreateNewPostCommand', \Ganked\Post\Commands\CreateNewPostCommand::class],
                ['createAuthenticationCommand', \Ganked\Post\Commands\AuthenticationCommand::class],
            ];
        }
    }
}
