<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{

    /**
     * @covers Ganked\API\Factories\BackendFactory
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
