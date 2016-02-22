<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Factories
{
    /**
     * @covers Ganked\Services\Factories\BackendFactory
     * @uses \Ganked\Services\Backends\SlackBackend
     */
    class BackendFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createSlackBackend', \Ganked\Services\Backends\SlackBackend::class]
            ];
        }
    }
}
