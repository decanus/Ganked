<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{

    /**
     * @covers Ganked\Post\Factories\BackendFactory
     * @uses Ganked\Post\Backends\MailBackend
     * @uses \Ganked\Post\Factories\HandlerFactory
     */
    class BackendFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createMailBackend', \Ganked\Post\Backends\MailBackend::class],
            ];
        }
    }
}
