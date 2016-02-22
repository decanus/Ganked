<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{

    class BackendFactory extends \Ganked\Skeleton\Factories\BackendFactory
    {
        /**
         * @return \Ganked\Post\Backends\MailBackend
         * @throws \Exception
         */
        public function createMailBackend()
        {
            $configuration = $this->getMasterFactory()->getConfiguration();

            return new \Ganked\Post\Backends\MailBackend(
                $configuration->get('mailHost'),
                $configuration->get('mailUsername'),
                $configuration->get('mailPassword'),
                new \PHPMailer(true)
            );
        }
    }
}
