<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class MailFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Post\Mails\VerifyMail
         */
        public function createVerifyMail()
        {
            return new \Ganked\Post\Mails\VerifyMail(
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode(),
                $this->getMasterFactory()->createMailBackend(),
                $this->getMasterFactory()->createGetDomFromFileQuery()
            );
        }

        /**
         * @return \Ganked\Post\Mails\ForgotPasswordMail
         */
        public function createForgotPasswordMail()
        {
            return new \Ganked\Post\Mails\ForgotPasswordMail(
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode(),
                $this->getMasterFactory()->createMailBackend(),
                $this->getMasterFactory()->createGetDomFromFileQuery()
            );
        }
    }
}
