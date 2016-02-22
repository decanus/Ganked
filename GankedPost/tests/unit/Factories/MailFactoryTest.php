<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{
    /**
     * @covers Ganked\Post\Factories\MailFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Post\Factories\QueryFactory
     * @uses Ganked\Post\Factories\BackendFactory
     * @uses Ganked\Post\Mails\AbstractMail
     * @uses Ganked\Post\Backends\MailBackend
     * @uses \Ganked\Post\Factories\HandlerFactory
     */
    class MailFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createVerifyMail', \Ganked\Post\Mails\VerifyMail::class],
                ['createForgotPasswordMail', \Ganked\Post\Mails\ForgotPasswordMail::class],
            ];
        }
    }
}
