<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{
    /**
     * @covers Ganked\Backend\Factories\BackendFactory
     * @uses Ganked\Backend\Writers\StaticPageWriter
     */
    class BackendFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createMongoDatabaseBackend', \Ganked\Library\Backends\MongoDatabaseBackend::class]
            ];
        }
    }
}
