<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    /**
     * @covers Ganked\API\Factories\ReaderFactory
     * @uses \Ganked\API\Readers\TokenReader
     */
    class ReaderFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createTokenReader', \Ganked\API\Readers\TokenReader::class]
            ];
        }
    }
}
